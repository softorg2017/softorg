<?php
namespace App\Repositories\Admin;

use App\Models\Record;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use Response, Auth, Validator, DB, Exception;

class StatisticsRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Record;
    }


    // 单页流量统计
    public function view_page_statistics($post_data)
    {
        $module = $post_data["module"];
        if(in_array($module, [1,2,3,4,5]))
        {

            $admin = Auth::guard('admin')->user();
            $org_id = $admin->org_id;

//            $where['org_id'] = $org_id;
            $where['sort'] = 3;
            $where['module'] = $module;
            $id = decode($post_data["id"]);
            if(intval($id) !== 0 && !$id) return response_error([],"查询不存在");
            else $where['page_id'] = $id;

            if($module == 1) $info = Product::whereId($id)->first();
            else if($module == 2) $info = Article::whereId($id)->first();
            else if($module == 3) $info = Activity::whereId($id)->first();
            else if($module == 4) $info = Survey::whereId($id)->first();
            else if($module == 5) $info = Slide::whereId($id)->first();

            $where['type'] = 1;
            $data = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_type = Record::select('open_type',DB::raw('count(*) as count'))
                ->groupBy('open_type')
                ->where($where)
                ->get();
            foreach($open_type as $k => $v)
            {
                if($v->open_type == 1) $open_type[$k]->name = "移动端";
                else $open_type[$k]->name = "PC端";
            }

            $where['type'] = 1;
            $open_app = Record::select('open_app',DB::raw('count(*) as count'))
                ->groupBy('open_app')
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_system = Record::select('open_system',DB::raw('count(*) as count'))
                ->groupBy('open_system')
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared_scale = Record::select('shared_location',DB::raw('count(*) as count'))
                ->groupBy('shared_location')
                ->where($where)
                ->get();
            foreach($shared_scale as $k => $v)
            {
                if($v->shared_location == 1) $shared_scale[$k]->name = "微信好友";
                else if($v->shared_location == 2) $shared_scale[$k]->name = "微信朋友圈";
                else if($v->shared_location == 3) $shared_scale[$k]->name = "QQ好友";
                else if($v->shared_location == 4) $shared_scale[$k]->name = "QQ空间";
                else if($v->shared_location == 5) $shared_scale[$k]->name = "腾讯微博";
                else $shared_scale[$k]->name = "其他";
            }

            $view["info"] = $info;
            $view["data"] = $data;
            $view["open_type"] = $open_type;
            $view["open_app"] = $open_app;
            $view["open_system"] = $open_system;
            $view["shared"] = $shared;
            $view["shared_scale"] = $shared_scale;

            return view('admin.layout.statistics')->with($view);
        }
        else return response_error([],"查询不存在");
    }



}