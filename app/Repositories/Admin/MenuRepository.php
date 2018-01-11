<?php
namespace App\Repositories\Admin;

use App\Models\Menu;
use Response, Auth, Validator, DB, Exception;

class MenuRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Menu;
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Menu::select("*")->where('org_id',$org_id)->withCount(['products'])->with(['admin']);
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

    // 返回编辑视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0) return view('admin.menu.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $menu = Menu::with(['products'])->find($decode_id);
            if($menu)
            {
                unset($menu->id);
                return view('admin.menu.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$menu]);
            }
            else return response("该目录不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $messages = [
            'id.required' => '参数有误',
            'name.required' => '请输入名称',
            'title.required' => '请输入标题',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
            'name' => 'required',
            'title' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，添加一个新的产品目录
        {
            $menu = new Menu;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else // 修改幻灯片
        {
            $menu = Menu::find($id);
            if(!$menu) return response_error([],"该目录不存在，刷新页面试试");
            if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $menu->fill($post_data)->save();
        if($bool) return response_success(['id'=>encode($menu->id)]);
        else return response_fail();
    }

    public function view_sort()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $menu = Menu::where(['org_id'=>$org_id])->orderBy('order', 'asc')->get();
        return view('admin.menu.sort')->with(['data'=>$menu]);
    }

    // 排序
    public function sort($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $admin_decode = decode($post_data["admin"]);
        if(!$admin) return response_error();
        if($admin->id == $admin_decode)
        {
            $menus = collect($post_data['menu'])->values()->toArray();

            foreach($menus as $k => $v)
            {
                $id = $v['id'];
                $menu = Menu::find($id);
                if(!$menu) return response_error();
                $menu->order = $k;
                $bool = $menu->save();
            }
            return response_success();
        }
        else return response_fail([],'用户有变更，请刷新重试！');

    }

    // 删除
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $menu = Menu::find($id);
        if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $bool = $menu->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else return response_success([]);
    }

    // 启用
    public function enable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $menu = Menu::find($id);
        if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $menu->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success([]);
    }

    // 禁用
    public function disable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $menu = Menu::find($id);
        if($menu->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $menu->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success([]);
    }



}