<?php
namespace App\Repositories\Admin;

use App\Models\Record;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use Response, Auth, Validator, DB, Excepiton;

class StatisticsRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Record;
    }


    public function view_page_statistics($post_data)
    {
        $sort = $post_data["sort"];
        if(in_array($sort,config('common.common.type')))
        {

            $admin = Auth::guard('admin')->user();
            $org_id = $admin->org_id;

//            $where['org_id'] = $org_id;
            $where['type'] = 3;
            $where['sort'] = $sort;
            $id = decode($post_data["id"]);
            if(intval($id) !== 0 && !$id) return response_error([],"查询不存在");
            else $where['page_id'] = $id;

            if($sort == "product") $info = Product::whereId($id)->first();
            else if($sort == "activity") $info = Activity::whereId($id)->first();
            else if($sort == "slide") $info = Slide::whereId($id)->first();
            else if($sort == "survey") $info = Survey::whereId($id)->first();
            else if($sort == "article") $info = Article::whereId($id)->first();

            $data = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $view["info"] = $info;
            $view["data"] = $data;

            return view('admin.layout.statistics')->with($view);
        }
        else return response_error([],"查询不存在");
    }



}