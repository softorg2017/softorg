<?php
namespace App\Repositories\Admin;

use App\Models\Question;
use App\Models\Option;
use Response, Auth, Validator, DB, Exception;

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
        $admin = Auth::guard('admin')->user();

        $operate = $post_data["operate"];
        $container = $post_data["container"];
        if($container == "survey")
        {
            $survey_id = decode($post_data["survey_id"]);
            if(intval($survey_id) !== 0 && !$survey_id) return response_error();
            $post_data["survey_id"] = $survey_id;
        }

        if($operate == "create") // $id==0，创建一个新的调研
        {
            $question = new Question;
            $post_data["org_id"] = $admin->org_id;
            $post_data["admin_id"] = $admin->id;

            $max_question = Question::where("survey_id",$survey_id)->orderBy("order","desc")->first();
            if($max_question) $post_data["order"] = $max_question->order + 1;
            else $post_data["order"] = 0;
        }
        else // 修改调研
        {
            $question_id = decode($post_data["question_id"]);
            $question = Question::find($question_id);
            if(!$question) return response_error();
            if($question->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $question->fill($post_data)->save();
        if(!$bool) return response_fail();

        $type = $post_data["type"];
        if($type == 3 || $type == 4 || $type == 5 || $type == 6)
        {
//            // 方案1
            foreach($post_data["option"] as $k => $v)
            {
                if($v["id"] != 0)
                {
                    $option = Option::find($v["id"]);
                    $option->title = $v["title"];
                    $option->save();
                    unset($post_data["option"][$k]);
                }
                else
                {
                    $post_data["option"][$k]["org_id"] = $admin->org_id;
                    $post_data["option"][$k]["admin_id"] = $admin->id;
                    $post_data["option"][$k]["survey_id"] = $survey_id;
                }
            }

            // 方案2
//            $num = Option::where("question_id",$question->id)->delete();
//            foreach($post_data["option"] as $k => $v)
//            {
//                $post_data["option"][$k]["org_id"] = $admin->org_id;
//                $post_data["option"][$k]["admin_id"] = $admin->id;
//                $post_data["option"][$k]["survey_id"] = $survey_id;
//            }

            $options = $question->options()->createMany($post_data["option"]);
            if(!$options) return response_fail();
        }

        if($bool) return response_success();
        else return response_fail();
    }

    // 删除
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $question_id = decode($post_data["question_id"]);
        if(intval($question_id) !== 0 && !$question_id) return response_error([],"该问题不存在，刷新页面试试");

        $question = Question::find($question_id);
        if($question->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $bool = $question->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else
        {
            $bool = Option::where('question_id',$question_id)->delete();
            return response_success([]);
        }
    }

    // 删除
    public function delete_option($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $survey_id = decode($post_data["survey_id"]);
        if(intval($survey_id) !== 0 && !$survey_id) return response_error([],"该问卷不存在，刷新页面试试");

        $question_id = decode($post_data["question_id"]);
        if(intval($question_id) !== 0 && !$question_id) return response_error([],"该问题不存在，刷新页面试试");

        $option_id = $post_data["option_id"];
        if(intval($option_id) !== 0 && !$option_id) return response_error([],"该选项不存在，刷新页面试试");

        $option = Option::find($option_id);
        if($option->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $bool = $option->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else return response_success([]);
    }



}