<?php
namespace App\Repositories\Admin;

use App\Models\Survey;
use App\Models\Question;
use Response, Auth, Validator, DB, Excepiton;
use QrCode;

class SurveyRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Survey;
    }

    //
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Survey::select("*")->where('org_id',$org_id)->with(['admin']);
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

        if($decode_id == 0) return view('admin.slide.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $survey = Survey::with(['questions'=>function($query) {
                    $query->with(['options'])->orderBy('order', 'asc');
                }])->find($decode_id);
            if($survey)
            {
                unset($survey->id);
                foreach ($survey->questions as $k => $v)
                {
                    $survey->questions[$k]->encode_id = encode($v->id);
                }
                return view('admin.survey.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$survey]);
            }
            else return response("该调研问卷不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，创建一个新的调研
        {
            $survey = new Survey;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else // 修改调研
        {
            $survey = Survey::find($id);
            if(!$survey) return response_error();
            if($survey->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $survey->fill($post_data)->save();
        if($bool)
        {
            $encode_id = encode($survey->id);
            // 目标URL
            $url = 'http://www.softorg.cn:8088/survey?id='.$encode_id;
            // 保存位置
            $qrcodes_path = 'resource/org/'.$admin->id.'/qrcodes/surveys';
            if(!file_exists(storage_path($qrcodes_path)))
                mkdir(storage_path($qrcodes_path), 777, true);
            // qrcode图片文件
            $qrcode = $qrcodes_path.'/'.$encode_id.'.png';
            QrCode::format('png')->size(150)->generate($url,storage_path($qrcode));

            return response_success(['id'=>$encode_id]);
        }
        else return response_fail();
    }

    // 问题排序
    public function sort($post_data)
    {
        $survey_id = decode($post_data["survey_id"]);
        if(!$survey_id) return response_error();

        $questions = collect($post_data['question'])->values()->toArray();

        foreach($questions as $k => $v)
        {
            $id = $v['id'];
            $question = Question::find($id);
            if(!$question) return response_error();
            $order['order'] = $k;
            $bool = $question->fill($order)->save();
        }
        return response_success();
    }

    // 删除
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该问卷不存在，刷新页面试试");

        $survey = Survey::find($id);
        if($survey->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $bool = $survey->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else return response_success([]);
    }

    // 启用
    public function enable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该问卷不存在，刷新页面试试");

        $survey = Survey::find($id);
        if($survey->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $survey->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success([]);
    }

    // 禁用
    public function disable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该问卷不存在，刷新页面试试");

        $survey = Survey::find($id);
        if($survey->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $survey->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success([]);
    }



}