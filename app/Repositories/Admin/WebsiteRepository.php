<?php
namespace App\Repositories\Admin;

use App\Models\Website;
use App\Models\Record;
use Response, Auth, Validator, DB, Exception;

class WebsiteRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Website;
    }

    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Website::select("*")->where('org_id',$org_id)->with(['admin']);
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
        foreach ($list as $k => $v) {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }

    // 显示编辑视图
    public function view_edit()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $website = Website::where('org_id', $org_id)->first();
        return view('admin.website.edit')->with('data', $website);
    }

    // 编辑自定义网站
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $website = Website::where('org_id', $org_id)->first();
        if($website)
        {
            $type = $post_data['type'];
            $content = $post_data['content'];
            $editor[$type] = $content;
            $bool = $website->fill($editor)->save();
            if($bool) return response_success([], '修改成功');
            else return response_fail([], '修改失败，刷新页面重试');
        }
        else return response_error();
    }

    public function view_statistics()
    {
//        $sql = "select count(*) from db_company.records group by date(created_at)";
//        $results = DB::select($sql);
//        dd($results);

        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $sql = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where("org_id",$org_id);

        $all = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where("org_id",$org_id)
            ->get();

        $index = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>1])
            ->get();

        $product = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>2, 'sort'=>'product'])
            ->get();

        $activity = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id, 'type'=>2, 'sort'=>'activity'])
            ->get();

        $survey = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id,'type'=>2,'sort'=>'survey'])
            ->get();

        $article = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))
            ->where(['org_id'=>$org_id,'type'=>2,'sort'=>'article'])
            ->get();

        $open_type = Record::select('open_type',DB::raw('count(*) as count'))
            ->groupBy('open_type')
            ->where(['org_id'=>$org_id])
            ->get();
        foreach($open_type as $k => $v)
        {
            if($v->open_type == 1) $open_type[$k]->name = "移动端";
            else $open_type[$k]->name = "PC端";
        }

        $open_app = Record::select('open_app',DB::raw('count(*) as count'))
            ->groupBy('open_app')
            ->where(['org_id'=>$org_id])
            ->get();

        $open_system = Record::select('open_system',DB::raw('count(*) as count'))
            ->groupBy('open_system')
            ->where(['org_id'=>$org_id])
            ->get();

        $view["all"] = $all;
        $view["index"] = $index;
        $view["product"] = $product;
        $view["activity"] = $activity;
        $view["survey"] = $survey;
        $view["article"] = $article;
        $view["open_type"] = $open_type;
        $view["open_app"] = $open_app;
        $view["open_system"] = $open_system;

        return view('admin.website.statistics')->with($view);
    }

    public function view_page_statistics()
    {
//        $sql = "select count(*) from db_company.records group by date(created_at)";
//        $results = DB::select($sql);
//        dd($results);

        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $sql = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id);

        $all = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id)
            ->get();

        $index = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id)
            ->whereType(1)
            ->get();

        $product = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id)
            ->where(['type'=>2,'sort'=>'product'])
            ->get();

        $activity = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id)
            ->where(['type'=>2,'sort'=>'activity'])
            ->get();

        $survey = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id)
            ->where(['type'=>2,'sort'=>'survey'])
            ->get();

        $article = Record::select(DB::raw('date(from_unixtime(created_at)) as date'), DB::raw('count(*) as count'))
            ->groupBy(DB::raw("date(from_unixtime(created_at))"))->where("org_id",$org_id)
            ->where(['type'=>2,'sort'=>'article'])
            ->get();

        $view["all"] = $all;
        $view["index"] = $index;
        $view["product"] = $product;
        $view["activity"] = $activity;
        $view["survey"] = $survey;
        $view["article"] = $article;

        return view('admin.website.statistics')->with($view);
    }



}