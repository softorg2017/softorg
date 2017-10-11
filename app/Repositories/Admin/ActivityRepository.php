<?php
namespace App\Repositories\Admin;

use App\Models\Activity;
use Response, Auth, Validator, DB, Excepiton;

class ActivityRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Activity;
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Activity::select("*")->where('org_id',$org_id)->with(['admin']);
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

        if($decode_id == 0) return view('admin.activity.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $activity = Activity::with(['org'])->find($decode_id);
            if($activity)
            {
                unset($activity->id);
                return view('admin.activity.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$activity]);
            }
            else return response("活动不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，添加一个新的活动
        {
            $activity = new Activity;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else // 修改活动
        {
            $activity = Activity::find($id);
            if(!$activity) return response_error();
            if($activity->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $activity->fill($post_data)->save();
        if($bool) return response_success(['id'=>encode($activity->id)]);
        else return response_fail();
    }


}