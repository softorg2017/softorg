<?php
namespace App\Repositories\Admin;

use App\Models\Article;
use Response, Auth, Validator, DB, Excepiton;
use QrCode;

class ArticleRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Article;
    }

    // 返回列表数据
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Article::select("*")->where('org_id',$org_id)->with(['admin']);
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

        if($decode_id == 0) return view('admin.article.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $activity = Article::with(['org'])->find($decode_id);
            if($activity)
            {
                unset($activity->id);
                return view('admin.article.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$activity]);
            }
            else return response("文章不存在！", 404);
        }
    }

    // 保存数据
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，添加一个新的文章
        {
            $article = new Article;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;

        }
        else // 编辑文章
        {
            $article = Article::find($id);
            if(!$article) return response_error();
            if($article->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $article->fill($post_data)->save();
        if($bool)
        {
            $encode_id = encode($article->id);
            // 目标URL
            $url = 'http://www.softorg.cn:8088/article?id='.$encode_id;
            // 保存位置
            $qrcodes_path = 'resource/org/'.$admin->id.'/qrcodes/articles';
            if(!file_exists(storage_path($qrcodes_path)))
                mkdir(storage_path($qrcodes_path), 777, true);
            // qrcode图片文件
            $qrcode = $qrcodes_path.'/'.$encode_id.'.png';
            QrCode::format('png')->size(150)->generate($url,storage_path($qrcode));

            return response_success(['id'=>$encode_id]);
        }
        else return response_fail();
    }

    // 删除
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $article = Article::find($id);
        if($article->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $bool = $article->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else return response_success();
    }

    // 启用
    public function enable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $article = Article::find($id);
        if($article->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $article->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success();
    }

    // 禁用
    public function disable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $article = Article::find($id);
        if($article->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $article->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success();
    }


}