<?php
namespace App\Repositories\Org\Admin;

use App\Models\Org\OrgModule;
use App\Models\Org\OrgMenu;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class OrgModuleRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgModule;
    }

    // 返回【列表】数据
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("org_admin")->user()->org_id;
        $query = OrgModule::select("*")->where('org_id',$org_id)->with(['admin', 'menu', 'menus']);
        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回【新建】视图
    public function view_create()
    {
        $admin = Auth::guard("org_admin")->user();
        $org_id = $admin->org_id;

        $menus = OrgMenu::where(['org_id'=>$org_id])->get();
        return view('org.admin.module.edit')->with(['operate'=>'create', 'encode_id'=>encode(0), 'menus'=>$menus]);
    }

    // 返回【编辑】视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        $admin = Auth::guard("org_admin")->user();
        $org_id = $admin->org_id;

        $menus = OrgMenu::where(['org_id'=>$org_id])->get();
        if($decode_id == 0) return view('org.admin.module.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $module = OrgModule::with(['menu','menus'])->find($decode_id);
            if($module)
            {
                unset($module->id);
                return view('org.admin.module.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$module, 'menus'=>$menus]);
            }
            else return response("该目录不存在！", 404);
        }
    }

    // 【保存】
    public function save($post_data)
    {
        $messages = [
            'encode_id.required' => '参数有误',
            'title.required' => '请输入标题',
        ];
        $v = Validator::make($post_data, [
            'encode_id' => 'required',
            'title' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $admin = Auth::guard('org_admin')->user();

        $decode_id = decode($post_data["encode_id"]);
        if(intval($decode_id) !== 0 && !$decode_id) return response_error();


        // 判断操作类型
        $operate = $post_data["operate"];
        if($operate == 'create') // 添加 ( $id==0，添加一个新的模块 )
        {
            $module = new OrgModule;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else if($operate == 'edit') // 修改
        {
            $module = OrgModule::find($decode_id);
            if(!$module) return response_error([],"该模块不存在，刷新页面试试");
            if($module->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }
        else return response_error([],"参数有误");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            if($post_data["type"] != 1) unset($post_data["menu_id"]);
            $bool = $module->fill($post_data)->save();
            if($bool)
            {
                if($post_data["type"] == 2 && !empty($post_data["menus"]))
                {
//                    $module->menus()->attach($post_data["menus"]);
                    $module->menus()->syncWithoutDetaching($post_data["menus"]);
                }

                // 轮播图片
                if($post_data["type"] == 4 && !empty($post_data["covers"]))
                {
                    foreach($post_data["covers"] as $num => $cover) {
                        // 封面图片
                        if(!empty($cover["img"]))
                        {
                            $upload = new CommonRepository();
                            $result = $upload->create($cover["img"], 'org-'. $admin->id.'-common-img_multiple', rand(100,999).$num);
                            if($result["status"])
                            {
                                $post_data["covers"][$num]["cover_pic"] = $result["data"];
                            }
                            unset($post_data["covers"][$num]["img"]);
                        }
                        else
                        {
                            unset($post_data["covers"][$num]);
                        }
                    }

                    if(!empty($module->img_multiple))
                    {
                        $img_multiple = collect(json_decode($module->img_multiple,true));
                        $covers = collect($post_data["covers"]);
                        $merged = $img_multiple->merge($covers);
                        $module->img_multiple = json_encode($merged->values()->all());
                    }
                    else $module->img_multiple = json_encode(collect($post_data["covers"])->values()->all());

                    $module->save();
                }

                $encode_id = encode($module->id);

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'org-'. $admin->id.'-unique-modules' , 'cover_module_'.$encode_id);
                    if($result["status"])
                    {
                        $module->cover_pic = $result["data"];
                        $module->save();
                    }
                    else throw new Exception("upload-cover-fail");
                }

            }
            else throw new Exception("insert--module--fail");

            DB::commit();
            return response_success(['id'=>$encode_id]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }

    public function view_sort()
    {
        $admin = Auth::guard('org_admin')->user();
        $org_id = $admin->org_id;

        $module = OrgModule::where(['org_id'=>$org_id])->orderBy('order', 'asc')->get();
        return view('org.admin.module.sort')->with(['data'=>$module]);
    }

    // 【排序】
    public function sort($post_data)
    {
        $admin = Auth::guard('org_admin')->user();

        $admin_decode = decode($post_data["admin"]);
        if(!$admin) return response_error();
        if($admin->id == $admin_decode)
        {
            $modules = collect($post_data['module'])->values()->toArray();

            foreach($modules as $k => $v)
            {
                $id = $v['id'];
                $module = OrgModule::find($id);
                if(!$module) return response_error();
                $module->timestamps = false;
                $module->order = $k;
                $bool = $module->save();
            }
            return response_success();
        }
        else return response_fail([],'用户有变更，请刷新重试！');

    }

    // 【删除】
    public function delete($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $module = OrgModule::find($id);
        if($module->admin_id != $admin->id) return response_error([],"你没有操作权限");

        // 删除目录
        $module->menus()->detach();

        $cover_pic = $module->cover_pic;

        // 删除封面图片
        if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
        {
            unlink(storage_path("resource/" . $cover_pic));
        }

        // 删除封面图片
        if(!empty($module->img_multiple))
        {
            foreach (json_decode($module->img_multiple) as $item)
            {
                if(file_exists(storage_path("resource/" . $item->cover_pic)))
                {
                    unlink(storage_path("resource/" . $item->cover_pic));
                }
            }
        }

        $bool = $module->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else return response_success([]);
    }

    // 【启用】
    public function enable($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $module = OrgModule::find($id);
        if($module->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $module->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success([]);
    }

    // 【禁用】
    public function disable($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $module = OrgModule::find($id);
        if($module->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $module->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success([]);
    }



}