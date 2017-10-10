<?php
namespace App\Repositories\Admin\Company;

use App\Models\Admin\Company\Menu;
use Response, Auth, Validator, DB, Excepiton;

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
        $company_id = Auth::guard("admin")->user()->company_id;
        $query = Menu::select("*")->where('company_id',$company_id)->withCount(['products']);
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

        if($decode_id == 0) return view('admin.company.menu.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $menu = Menu::with(['products'])->find($decode_id);
            if($menu)
            {
                unset($menu->id);
                return view('admin.company.menu.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$menu]);
            }
            else return response("该目录不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，添加一个新的产品目录
        {
            $menu = new Menu;
            $post_data["admin_id"] = $admin->id;
            $post_data["company_id"] = $admin->company_id;
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



}