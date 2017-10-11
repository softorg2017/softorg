<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Models\Website;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use Response, Auth, Validator, DB, Excepiton;

class SoftorgRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Softorg;
    }

    // 返回（后台）主页视图
    public function view_admin_index()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::whereId($org_id)->first();

        return view('admin.softorg.index')->with(['org'=>$org]);
    }

    // 返回（后台）企业信息编辑视图
    public function view_edit()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::whereId($org_id)->first();

        return view('admin.softorg.edit')->with(['org'=>$org]);

    }
    // 保存企业信息
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::find($org_id);

        $bool = $org->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }



    // 返回（前台）主页视图
    public function view_index($org)
    {
        $query = Softorg::with([
            'administrators','websites','menus',
            'products' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'activities' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'slides' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'surveys' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'articles' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.index')->with('org',$org);
        }
        else dd("企业不存在");
    }


    // 返回（前台）产品页视图
    public function view_product($org)
    {
        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.product.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）产品详情页视图
    public function view_product_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $product = Product::with(['org','admin'])->whereId($decode_id)->first();
        if($product)
        {
            return view('front.'.config('common.view.front.template').'.product.detail')->with('data',$product);
        }
        else dd("产品不存在");
    }


    // 返回（前台）活动页视图
    public function view_activity($org)
    {
        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.activity.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）活动详情页视图
    public function view_activity_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with(['org','admin'])->whereId($decode_id)->first();
        if($activity)
        {
            return view('front.'.config('common.view.front.template').'.activity.detail')->with('data',$activity);
        }
        else dd("活动不存在");
    }


    // 返回（前台）幻灯片列表页视图
    public function view_slide($org)
    {
        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.slide.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）幻灯片详情页视图
    public function view_slide_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $slide = Slide::with(['org','admin','pages'])->whereId($decode_id)->first();
        if($slide)
        {
            return view('front.'.config('common.view.front.template').'.slide.detail')->with('data',$slide);
        }
        else dd("幻灯片不存在");
    }


    // 返回（前台）调研列表页视图
    public function view_survey($org)
    {
        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.survey.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）调研详情页视图
    public function view_survey_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $survey = Survey::with(['org','admin'])->whereId($decode_id)->first();
        if($survey)
        {
            return view('front.'.config('common.view.front.template').'.survey.detail')->with('data',$survey);
        }
        else dd("调研不存在");
    }


    // 返回（前台）文章列表页视图
    public function view_article($org)
    {
        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.article.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）文章详情页视图
    public function view_article_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $article = Article::with(['org','admin'])->whereId($decode_id)->first();
        if($article)
        {
            return view('front.'.config('common.view.front.template').'.article.detail')->with('data',$article);
        }
        else dd("文章不存在");
    }

}