<?php
namespace App\Repositories\Admin;

use App\Models\Answer;
use App\Models\Survey;
use App\Models\Page;
use Response, Auth, Validator, DB, Exception;
use QrCode;

class AnswerRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Answer;
    }

    // 返回列表视图
    public function view_list($post_data)
    {
        $type = $post_data['type'];
        $encode_id = $post_data['id'];
        $decode_id = decode($encode_id);
        if(!$decode_id) return response("参数有误", 404);
        if($type == "survey")
        {
            $answer = Survey::find($decode_id);
            $title = "问卷：".$answer->title;
        }
        else if($type == "slide")
        {
            $answer = Page::find($decode_id);
            $title = "幻灯片：".$answer->title;
        }
        return view('admin.answer.list')->with(['type'=>$type,'encode_id'=>$encode_id,'title'=>$title]);
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $encode_id = $post_data['id'];
        $decode_id = decode($encode_id);
        if(!$decode_id) return response("参数有误", 404);

        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Answer::select("*")->where('survey_id',$decode_id);
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

    // 返回回答详情视图
    public function view_detail()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if($decode_id == 0 && !$decode_id) return response("参数有误", 404);
        else
        {
            $answer = Answer::find($decode_id);
            $answer_id = $answer->id;
            $answer = Answer::with(['survey'=>function($query) use($answer_id) {
                $query->with(['questions'=>function($queryX) use($answer_id) {
                    $queryX->with(['options','choices'=>function($queryY) use($answer_id){
                        $queryY->with(['option'])->where("answer_id",$answer_id);
                    }])->orderBy('order', 'asc');;
                }]);
            }])->find($decode_id);
            if($answer)
            {
                return view('admin.answer.detail')->with(['data'=>$answer->survey]);
            }
            else return response("回答不存在！", 404);
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
            $survey = Survey::with(['questions'=>function($queryX) {
                    $queryX->with(['options'=>function($queryY) {
                        $queryY->withCount(['choices']);
                    }]);
                }])->find($decode_id);
            if($survey)
            {
                return view('admin.answer.analysis')->with(['data'=>$survey]);
            }
            else return response("回答不存在！", 404);
        }
    }


}