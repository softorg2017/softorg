<?php
namespace App\Repositories\Admin\Article;

use App\Models\Admin\Article\Article;
use Response, Auth, Validator, DB, Excepiton;

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
        $company_id = Auth::guard("admin")->user()->company_id;
        $query = Article::select("*")->where('company_id',$company_id);
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
            $activity = Article::with(['company'])->find($decode_id);
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
            $post_data["company_id"] = $admin->company_id;
        }
        else // 编辑文章
        {
            $article = Article::find($id);
            if(!$article) return response_error();
            if($article->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $article->fill($post_data)->save();
        if($bool) return response_success(['id'=>encode($article->id)]);
        else return response_fail();
    }


}