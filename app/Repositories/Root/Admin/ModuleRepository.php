<?php
namespace App\Repositories\Root\Admin;

use App\Models\Root\RootModule;
use App\Models\Root\RootMenu;
use App\Models\Root\RootItem;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode;

class ModuleRepository {

    private $model;
    private $repo;
    private $commonRepo;
    public function __construct()
    {
        $this->model = new RootModule;
        $this->commonRepo = new CommonRepository();
    }

    // 返回【列表】数据
    public function get_list_datatable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $query = RootModule::select("*")->with(['admin', 'menus', 'pivot_menus']);
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
        $admin = Auth::guard('admin')->user();

        $menus = RootMenu::get();
        return view('admin.module.edit')->with(['operate'=>'create', 'encode_id'=>encode(0), 'menus'=>$menus]);
    }

    // 返回【编辑】视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        $admin = Auth::guard('admin')->user();

        $menus = RootMenu::get();
        if($decode_id == 0) return view('admin.module.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $mine = RootModule::with(['menu','menus'])->find($decode_id);
            if($mine)
            {
                unset($mine->id);
                return view('admin.module.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$mine, 'menus'=>$menus]);
            }
            else return response("该目录不存在！", 404);
        }
    }

    // 【排序】
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

        $admin = Auth::guard('admin')->user();

        $decode_id = decode($post_data["encode_id"]);
        if(intval($decode_id) !== 0 && !$decode_id) return response_error();


        // 判断操作类型
        $operate = $post_data["operate"];
        if($operate == 'create') // 添加 ( $id==0，添加一个新的模块 )
        {
            $mine = new RootModule;
            $post_data["admin_id"] = $admin->id;
        }
        else if($operate == 'edit') // 修改
        {
            $mine = RootModule::find($decode_id);
            if(!$mine) return response_error([],"该模块不存在，刷新页面试试");
            if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }
        else return response_error([],"参数有误");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            if($post_data["type"] != 1) unset($post_data["menu_id"]);
            $bool = $mine->fill($post_data)->save();
            if($bool)
            {
                if($post_data["type"] == 2 && !empty($post_data["menus"]))
                {
//                    $mine->menus()->attach($post_data["menus"]);
                    $mine->menus()->syncWithoutDetaching($post_data["menus"]);
                }

                // 链接图片
                if($post_data["type"] == 4 && !empty($post_data["multiples"]))
                {
                    foreach($post_data["multiples"] as $num => $m) {
                        // 封面图片
                        if(!empty($m["file"]))
                        {
                            $upload = new CommonRepository();
                            $result = $upload->create($m["file"], 'root-common-img_multiple', rand(100,999).$num);
                            if($result["status"])
                            {
                                $post_data["multiples"][$num]["cover_pic"] = $result["data"];
                            }
                            unset($post_data["multiples"][$num]["file"]);
                        }
                        else unset($post_data["multiples"][$num]);
                    }

                    if(!empty($mine->img_multiple))
                    {
                        $img_multiple = collect(json_decode($mine->img_multiple,true));
                        $multiples = collect($post_data["multiples"]);
                        $merged = $img_multiple->merge($multiples);
                        $mine->img_multiple = json_encode($merged->values()->all());
                    }
                    else $mine->img_multiple = json_encode(collect($post_data["multiples"])->values()->all());

                    $mine->save();
                }

                // 轮播图片
                if($post_data["type"] == 5 && !empty($post_data["carousels"]))
                {
                    foreach($post_data["carousels"] as $num => $c) {
                        // 封面图片
                        if(!empty($c["file"]))
                        {
                            $upload = new CommonRepository();
                            $result = $upload->create($c["file"], 'root-common-img_multiple', rand(100,999).$num);
                            if($result["status"])
                            {
                                $post_data["carousels"][$num]["cover_pic"] = $result["data"];
                            }
                            unset($post_data["carousels"][$num]["file"]);
                        }
                        else unset($post_data["carousels"][$num]);
                    }

                    if(!empty($mine->img_multiple))
                    {
                        $img_multiple = collect(json_decode($mine->img_multiple,true));
                        $carousels = collect($post_data["carousels"]);
                        $merged = $img_multiple->merge($carousels);
                        $mine->img_multiple = json_encode($merged->values()->all());
                    }
                    else $mine->img_multiple = json_encode(collect($post_data["carousels"])->values()->all());

                    $mine->save();
                }

                $encode_id = encode($mine->id);

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    // 删除原封面图片
                    $mine_cover_pic = $mine->cover_pic;
                    if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                    {
                        unlink(storage_path("resource/" . $mine_cover_pic));
                    }

                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'root-unique-modules' , 'cover_module_'.$encode_id);
                    if($result["status"])
                    {
                        $mine->cover_pic = $result["data"];
                        $mine->save();
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
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }



    // 返回【新建】视图
    public function view_sort()
    {
        $admin = Auth::guard('admin')->user();

        $mine = RootModule::orderBy('order', 'asc')->get();
        return view('admin.module.sort')->with(['data'=>$mine]);
    }

    // 【排序】
    public function sort($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $admin_decode = decode($post_data["admin"]);
        if(!$admin) return response_error();
        if($admin->id == $admin_decode)
        {
            $mines = collect($post_data['module'])->values()->toArray();

            foreach($mines as $k => $v)
            {
                $id = $v['id'];
                $mine = RootModule::find($id);
                if(!$mine) return response_error();
                $mine->timestamps = false;
                $mine->order = $k;
                $bool = $mine->save();
            }
            return response_success();
        }
        else return response_fail([],'用户有变更，请刷新重试！');

    }



    // 【删除】
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootModule::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");


        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $mine->pivot_menus()->detach();

            $content = $mine->content;
            $cover_pic = $mine->cover_pic;

            $bool = $mine->delete();
            if(!$bool) throw new Exception("delete--menu--fail");

            DB::commit();

            // 删除UEditor图片
            $img_tags = get_html_img($content);
            foreach ($img_tags[2] as $img)
            {
                if (!empty($img) && file_exists(public_path($img)))
                {
                    unlink(public_path($img));
                }
            }

            // 删除封面图片
            if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
            {
                unlink(storage_path("resource/" . $cover_pic));
            }

            // 删除封面图片
            if(!empty($mine->img_multiple))
            {
                foreach (json_decode($mine->img_multiple) as $item)
                {
                    if(!empty($item->cover_pic) && file_exists(storage_path("resource/" . $item->cover_pic)))
                    {
                        unlink(storage_path("resource/" . $item->cover_pic));
                    }
                }
            }

            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
//            $msg = '删除失败，请重试';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }

    // 【启用】
    public function enable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootModule::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $mine->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success([]);
    }

    // 【禁用】
    public function disable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootModule::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $mine->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success([]);
    }



    // 【删除】
    public function delete_multiple_option($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["encode_id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootModule::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");

        $num = $post_data["num"];
        $img_multiple = collect(json_decode($mine->img_multiple,true));

        $item = $img_multiple->get($num);
        $cover_pic = $item["cover_pic"];
        if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
        {
            unlink(storage_path("resource/" . $cover_pic));
        }

        $img_multiple->forget($num);
        $mine->img_multiple = json_encode($img_multiple->all());
        $mine->save();
        return response_success([]);

    }



}