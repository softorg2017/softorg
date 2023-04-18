<?php
namespace App\Repositories\Org\Admin;

use App\Models\Org\OrgRecord;
use App\Models\Org\OrgMenu;
use App\Models\Org\OrgItem;

use App\Models\Product;
use App\Models\Article;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;

use Response, Auth, Validator, DB, Exception;

class OrgStatisticsRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgRecord;
    }


    // 总流量统计
    public function view_website_statistics()
    {
//        $sql = "select count(*) from db_company.records group by date(created_at)";
//        $results = DB::select($sql);
//        dd($results);

        $admin = Auth::guard('org_admin')->user();
        $org_id = $admin->org_id;
        $sql = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(["org_id"=>$org_id]);

        $all = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(["org_id"=>$org_id, 'type'=>1])
            ->get();

        $rooted = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>1, 'module'=>0])
            ->get();

        $home = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>1, 'module'=>2])
            ->get();

        $introduction = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>1, 'module'=>3])
            ->get();

        $contactus = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>1, 'module'=>4])
            ->get();

        $culture = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>1, 'module'=>5])
            ->get();

        $list = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>2])
            ->get();

        // module=1 product
        $product = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>2, 'module'=>1])
            ->get();

        // module=2 article
        $article = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1,'sort'=>2,'module'=>2])
            ->get();

        // module=3 activity
        $activity = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1, 'sort'=>2, 'module'=>3])
            ->get();

        // module=4 survey
        $survey = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1,'sort'=>2,'module'=>4])
            ->get();

        $open_type = OrgRecord::select('open_type',DB::raw('count(*) as count'))
            ->groupBy('open_type')
            ->where(['org_id'=>$org_id, 'type'=>1])
            ->get();
        foreach($open_type as $k => $v)
        {
            if($v->open_type == 1) $open_type[$k]->name = "移动端";
            else $open_type[$k]->name = "PC端";
        }

        $open_app = OrgRecord::select('open_app',DB::raw('count(*) as count'))
            ->groupBy('open_app')
            ->where(['org_id'=>$org_id, 'type'=>1])
            ->get();

        $open_system = OrgRecord::select('open_system',DB::raw('count(*) as count'))
            ->groupBy('open_system')
            ->where(['org_id'=>$org_id, 'type'=>1])
            ->get();

        $share_all = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(["org_id"=>$org_id, 'type'=>2])
            ->get();

        $share_root = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>2, 'sort'=>1, 'module'=>0])
            ->get();

        $share_menu = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>2, 'sort'=>2])
            ->get();

        $shared_all_scale = OrgRecord::select('shared_location',DB::raw('count(*) as count'))
            ->groupBy('shared_location')
            ->where(['org_id'=>$org_id, 'type'=>2])
            ->get();
        foreach($shared_all_scale as $k => $v)
        {
            if($v->shared_location == 1) $shared_all_scale[$k]->name = "微信好友";
            else if($v->shared_location == 2) $shared_all_scale[$k]->name = "微信朋友圈";
            else if($v->shared_location == 3) $shared_all_scale[$k]->name = "QQ好友";
            else if($v->shared_location == 4) $shared_all_scale[$k]->name = "QQ空间";
            else if($v->shared_location == 5) $shared_all_scale[$k]->name = "腾讯微博";
            else $shared_all_scale[$k]->name = "其他";
        }

        $shared_root_scale = OrgRecord::select('shared_location',DB::raw('count(*) as count'))
            ->groupBy('shared_location')
            ->where(['org_id'=>$org_id, 'type'=>2, 'sort'=>1, 'module'=>0])
            ->get();
        foreach($shared_root_scale as $k => $v)
        {
            if($v->shared_location == 1) $shared_root_scale[$k]->name = "微信好友";
            else if($v->shared_location == 2) $shared_root_scale[$k]->name = "微信朋友圈";
            else if($v->shared_location == 3) $shared_root_scale[$k]->name = "QQ好友";
            else if($v->shared_location == 4) $shared_root_scale[$k]->name = "QQ空间";
            else if($v->shared_location == 5) $shared_root_scale[$k]->name = "腾讯微博";
            else $shared_root_scale[$k]->name = "其他";
        }

        $view["all"] = $all;
        $view["rooted"] = $rooted;
        $view["home"] = $home;
        $view["introduction"] = $introduction;
        $view["contactus"] = $contactus;
        $view["culture"] = $culture;
        $view["list"] = $list;
        $view["product"] = $product;
        $view["activity"] = $activity;
        $view["survey"] = $survey;
        $view["article"] = $article;
        $view["open_type"] = $open_type;
        $view["open_app"] = $open_app;
        $view["open_system"] = $open_system;
        $view["share_all"] = $share_all;
        $view["share_root"] = $share_root;
        $view["share_menu"] = $share_menu;
        $view["shared_all_scale"] = $shared_all_scale;
        $view["shared_root_scale"] = $shared_root_scale;

        return view('org.admin.statistics.website')->with($view);
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
            $data = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_type = OrgRecord::select('open_type',DB::raw('count(*) as count'))
                ->groupBy('open_type')
                ->where($where)
                ->get();
            foreach($open_type as $k => $v)
            {
                if($v->open_type == 1) $open_type[$k]->name = "移动端";
                else $open_type[$k]->name = "PC端";
            }

            $where['type'] = 1;
            $open_app = OrgRecord::select('open_app',DB::raw('count(*) as count'))
                ->groupBy('open_app')
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_system = OrgRecord::select('open_system',DB::raw('count(*) as count'))
                ->groupBy('open_system')
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared_scale = OrgRecord::select('shared_location',DB::raw('count(*) as count'))
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

            return view('org.admin.statistics.statistics')->with($view);
        }
        else return response_error([],"查询不存在");
    }

    // 【目录】流量统计
    public function view_menu_statistics($post_data)
    {
        $module = 0;
        if(in_array($module, [0,1,2,3,4,5]))
        {
            $admin = Auth::guard('org_admin')->user();
            $org_id = $admin->org_id;

//            $where['org_id'] = $org_id;
            $where['sort'] = 2;
            $where['module'] = $module;
            $id = decode($post_data["id"]);
            if(intval($id) !== 0 && !$id) return response_error([],"查询不存在");
            else $where['page_id'] = $id;

            $info = OrgMenu::whereId($id)->first();

            $where['type'] = 1;
            $data = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_type = OrgRecord::select('open_type',DB::raw('count(*) as count'))
                ->groupBy('open_type')
                ->where($where)
                ->get();
            foreach($open_type as $k => $v)
            {
                if($v->open_type == 1) $open_type[$k]->name = "移动端";
                else $open_type[$k]->name = "PC端";
            }

            $where['type'] = 1;
            $open_app = OrgRecord::select('open_app',DB::raw('count(*) as count'))
                ->groupBy('open_app')
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_system = OrgRecord::select('open_system',DB::raw('count(*) as count'))
                ->groupBy('open_system')
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared_scale = OrgRecord::select('shared_location',DB::raw('count(*) as count'))
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

            return view('org.admin.statistics.statistics')->with($view);
        }
        else return response_error([],"查询不存在");
    }

    // 【内容】流量统计
    public function view_item_statistics($post_data)
    {
        $module = 0;
        if(in_array($module, [0,1,2,3,4,5]))
        {
            $admin = Auth::guard('org_admin')->user();
            $org_id = $admin->org_id;

//            $where['org_id'] = $org_id;
            $where['sort'] = 3;
            $where['module'] = $module;
            $id = decode($post_data["id"]);
            if(intval($id) !== 0 && !$id) return response_error([],"查询不存在");
            else $where['page_id'] = $id;

            if($module == 0) $info = OrgItem::whereId($id)->first();
            else if($module == 1) $info = Product::whereId($id)->first();
            else if($module == 2) $info = Article::whereId($id)->first();
            else if($module == 3) $info = Activity::whereId($id)->first();
            else if($module == 4) $info = Survey::whereId($id)->first();
            else if($module == 5) $info = Slide::whereId($id)->first();

            $where['type'] = 1;
            $data = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_type = OrgRecord::select('open_type',DB::raw('count(*) as count'))
                ->groupBy('open_type')
                ->where($where)
                ->get();
            foreach($open_type as $k => $v)
            {
                if($v->open_type == 1) $open_type[$k]->name = "移动端";
                else $open_type[$k]->name = "PC端";
            }

            $where['type'] = 1;
            $open_app = OrgRecord::select('open_app',DB::raw('count(*) as count'))
                ->groupBy('open_app')
                ->where($where)
                ->get();

            $where['type'] = 1;
            $open_system = OrgRecord::select('open_system',DB::raw('count(*) as count'))
                ->groupBy('open_system')
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared = OrgRecord::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
                ->groupBy(DB::raw("date(from_unixtime(created_at))"))
                ->where($where)
                ->get();

            $where['type'] = 2;
            $shared_scale = OrgRecord::select('shared_location',DB::raw('count(*) as count'))
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

            return view('org.admin.statistics.statistics')->with($view);
        }
        else return response_error([],"查询不存在");
    }



}