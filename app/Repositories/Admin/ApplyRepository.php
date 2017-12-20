<?php
namespace App\Repositories\Admin;

use App\Models\Activity;
use App\Models\Apply;
use Response, Auth, Validator, DB, Exception;
use QrCode;

class ApplyRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Apply;
    }

    // 返回列表视图
    public function view_list($post_data)
    {
        $sort = $post_data['sort'];
        $encode_id = $post_data['id'];
        $decode_id = decode($encode_id);
        if(!$decode_id) return response("参数有误", 404);
        if($sort == "activity")
        {
            $activity = Activity::find($decode_id);
            $title = "活动：".$activity->title;
        }

        return view('admin.apply.list')->with(['sort'=>$sort,'encode_id'=>$encode_id,'title'=>$title]);
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $encode_id = $post_data['id'];
        $decode_id = decode($encode_id);
        if(!$decode_id) return response("参数有误", 404);

        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Apply::select("*")->with('user')->where('activity_id',$decode_id);
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
        else $query->orderBy("created_at", "desc");

        $list = $query->skip($skip)->take($limit)->get();
        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回回答详情视图
    public function view_detail()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if($decode_id == 0 && !$decode_id) return response("参数有误", 404);
        else
        {
        }
    }

    // 返回回答数据分析视图
    public function view_analysis()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if($decode_id == 0 && !$decode_id) return response("参数有误", 404);
        else
        {
        }
    }


}