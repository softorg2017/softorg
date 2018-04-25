<?php
namespace App\Repositories\Org\Admin;

use App\Models\Org\OrgMenu;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class OrgMenuRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgMenu;
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("org_admin")->user()->org_id;
        $query = OrgMenu::select("*")->where('org_id',$org_id)->withCount(['items'])->with(['admin']);
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

    // 返回【添加】视图
    public function view_create()
    {
        return view('org.admin.menu.edit')->with(['operate'=>'create', 'encode_id'=>encode(0)]);
    }

    // 返回【编辑】视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0) return view('org.admin.menu.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $menu = OrgMenu::with(['items'])->find($decode_id);
            if($menu)
            {
                unset($menu->id);
                return view('org.admin.menu.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$menu]);
            }
            else return response("该目录不存在！", 404);
        }
    }

    // 【保存】数据
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
        if($operate == 'create') // 添加 ( $id==0，添加一个新的目录 )
        {
            $menu = new OrgMenu;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else if($operate == 'edit') // 修改
        {
            $menu = OrgMenu::find($decode_id);
            if(!$menu) return response_error([],"该目录不存在，刷新页面试试");
            if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }
        else return response_error([],"参数有误");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $bool = $menu->fill($post_data)->save();
            if($bool) {

                $encode_id = encode($menu->id);

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'org-'. $admin->id.'-unique-menus' , 'cover_menu_'.$encode_id);
                    if($result["status"])
                    {
                        $menu->cover_pic = $result["data"];
                        $menu->save();
                    }
                    else throw new Exception("upload-cover-fail");
                }
            }
            else throw new Exception("insert--menu--fail");

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

    public function view_sort()
    {
        $admin = Auth::guard('org_admin')->user();
        $org_id = $admin->org_id;

        $menu = OrgMenu::where(['org_id'=>$org_id])->orderBy('order', 'asc')->get();
        return view('org.admin.menu.sort')->with(['data'=>$menu]);
    }

    // 【排序】
    public function sort($post_data)
    {
        $admin = Auth::guard('org_admin')->user();

        $admin_decode = decode($post_data["admin"]);
        if(!$admin) return response_error();
        if($admin->id == $admin_decode)
        {
            $menus = collect($post_data['menu'])->values()->toArray();

            foreach($menus as $k => $v)
            {
                $id = $v['id'];
                $menu = OrgMenu::find($id);
                if(!$menu) return response_error();
                $menu->order = $k;
                $bool = $menu->save();
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

        $menu = OrgMenu::find($id);
        if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $cover_pic = $menu->cover_pic;

            $bool = $menu->delete();
            if(!$bool) throw new Exception("delete--menu--fail");

            // 删除封面图片
            if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
            {
                unlink(storage_path("resource/" . $cover_pic));
            }

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '删除失败，请重试';
            return response_fail([],$msg);
        }
    }

    // 【启用】
    public function enable($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $menu = OrgMenu::find($id);
        if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $menu->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success([]);
    }

    // 【禁用】
    public function disable($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $menu = OrgMenu::find($id);
        if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $menu->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success([]);
    }



}