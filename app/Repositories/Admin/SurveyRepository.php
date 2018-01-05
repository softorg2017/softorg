<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Option;
use App\Repositories\Common\CommonRepository;
use Response, Auth, Validator, DB, Exception;
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
        $query = Survey::select("*")->where('org_id',$org_id)->with(['admin','menu']);
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

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

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
            $survey = Survey::with([
                'menu',
                'org' => function ($query) { $query->with(['menus'])->orderBy('id','desc'); },
                'questions'=>function($query) { $query->with(['options'])->orderBy('order', 'asc'); }
            ])->find($decode_id);
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

        DB::beginTransaction();
        try
        {
            if($id == 0) // $id==0，创建一个新的调研
            {
                $survey = new Survey;
                $post_data["admin_id"] = $admin->id;
                $post_data["org_id"] = $admin->org_id;
            }
            else // 修改调研
            {
                $survey = Survey::find($id);
                if(!$survey) return response_error([],"该问卷不存在，刷新页面重试");
                if($survey->admin_id != $admin->id) return response_error([],"你没有操作权限");
            }

            $bool = $survey->fill($post_data)->save();
            if($bool)
            {
                $encode_id = encode($survey->id);
                // 目标URL
                $url = 'http://www.softorg.cn/survey?id='.$encode_id;
                // 保存位置
                $qrcode_path = 'resource/org/'.$admin->id.'/unique/surveys';
                if(!file_exists(storage_path($qrcode_path)))
                    mkdir(storage_path($qrcode_path), 0777, true);
                // qrcode图片文件
                $qrcode = $qrcode_path.'/qrcode_survey_'.$encode_id.'.png';
                QrCode::errorCorrection('H')->format('png')->size(160)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));


                if(!empty($post_data["cover"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'org-'. $admin->id.'-unique-surveys' , 'cover_survey_'.$encode_id);
                    if($result["status"])
                    {
                        $survey->cover_pic = $result["data"];
                        $survey->save();
                    }
                    else throw new Exception("upload-cover-fail");
                }

                $softorg = Softorg::find($admin->org_id);
                $create = new CommonRepository();
                $org_name = $softorg->name;
                $logo_path = '/resource/'.$softorg->logo;
                $title = $survey->title;
                $name = $qrcode_path.'/qrcode__survey_'.$encode_id.'.png';
                $create->create_qrcode_image($org_name, '问卷', $title, $qrcode, $logo_path, $name);
            }
            else throw new Exception("insert-survey-fail");

            DB::commit();
            return response_success(['id'=>$encode_id]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],'操作失败，请重试！');
        }
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
        else
        {
            $bool = Question::where('survey_id',$id)->delete();
            $bool = Option::where('survey_id',$id)->delete();
            return response_success([]);
        }
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