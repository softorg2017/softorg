<?php
namespace App\Repositories\Admin;

use App\Models\Question;
use Response, Auth, Validator, DB, Excepiton;

class QuestionRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Question;
    }

    //
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Question::select("*")->where('org_id',$org_id);
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

    //
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0) return view('admin.slide.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $question = Question::with(['survey'])->find($decode_id);
            if($question)
            {
                unset($question->id);
                if($question->survey)
                {
                    $question->survey->encode_id = encode($question->survey->id);
                }
                return view('admin.survey.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$question]);
            }
            else return response("问题不存在！", 404);
        }
    }

    //
    public function save($post_data)
    {
        dd($post_data);
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，创建一个新的调研
        {
            $question = new Question;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else // 修改调研
        {
            $question = Question::find($id);
            if(!$question) return response_error();
            if($question->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $question->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }



}