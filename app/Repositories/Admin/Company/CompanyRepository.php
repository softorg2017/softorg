<?php
namespace App\Repositories\Admin\Company;

use App\Models\Admin\Company\Company;
use App\Models\Admin\Company\Website;
use App\Models\Admin\Company\Menu;
use App\Models\Admin\Company\Product;
use App\Models\Admin\Activity\Activity;
use App\Models\Admin\Survey\Survey;
use App\Models\Admin\Slide\Slide;
use App\Models\Admin\Article\Article;
use Response, Auth, Validator, DB, Excepiton;

class CompanyRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Company;
    }

    // 返回（后台）主页视图
    public function view_admin_index()
    {
        $admin = Auth::guard('admin')->user();
        $company_id = $admin->company_id;
        $company = Company::whereId($company_id)->first();

        return view('admin.company.index')->with(['company'=>$company]);
    }

    // 返回（后台）企业信息编辑视图
    public function view_edit()
    {
        $admin = Auth::guard('admin')->user();
        $company_id = $admin->company_id;
        $company = Company::whereId($company_id)->first();

        return view('admin.company.edit')->with(['company'=>$company]);

    }
    // 保存企业信息
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $company_id = $admin->company_id;
        $company = Company::find($company_id);

        $bool = $company->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }



    // 返回（前台）主页视图
    public function view_index($company)
    {
        $query = Company::with([
            'administrators','websites','menus',
            'products' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'activities' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'slides' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'surveys' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); },
            'articles' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(4); }
        ]);
        if(is_numeric($company)) $company = $query->whereId($company)->first();
        else $company = $query->where('website_name',$company)->first();

        if($company)
        {
            return view('front.'.config('common.view.front.template').'.index')->with('company',$company);
        }
        else dd("企业不存在");
    }


    // 返回（前台）产品页视图
    public function view_product($company)
    {
        $query = Company::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($company)) $company = $query->whereId($company)->first();
        else $company = $query->where('website_name',$company)->first();

        if($company)
        {
            return view('front.'.config('common.view.front.template').'.company.product.list')->with('company',$company);
        }
        else dd("企业不存在");
    }
    // 返回（前台）产品详情页视图
    public function view_product_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $product = Product::with(['company','admin'])->whereId($decode_id)->first();
        if($product)
        {
            return view('front.'.config('common.view.front.template').'.company.product.detail')->with('data',$product);
        }
        else dd("产品不存在");
    }


    // 返回（前台）活动页视图
    public function view_activity($company)
    {
        $query = Company::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($company)) $company = $query->whereId($company)->first();
        else $company = $query->where('website_name',$company)->first();

        if($company)
        {
            return view('front.'.config('common.view.front.template').'.company.activity.list')->with('company',$company);
        }
        else dd("企业不存在");
    }
    // 返回（前台）活动详情页视图
    public function view_activity_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with(['company','admin'])->whereId($decode_id)->first();
        if($activity)
        {
            return view('front.'.config('common.view.front.template').'.company.activity.detail')->with('data',$activity);
        }
        else dd("活动不存在");
    }


    // 返回（前台）幻灯片列表页视图
    public function view_slide($company)
    {
        $query = Company::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($company)) $company = $query->whereId($company)->first();
        else $company = $query->where('website_name',$company)->first();

        if($company)
        {
            return view('front.'.config('common.view.front.template').'.company.slide.list')->with('company',$company);
        }
        else dd("企业不存在");
    }
    // 返回（前台）幻灯片详情页视图
    public function view_slide_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $slide = Slide::with(['company','admin','pages'])->whereId($decode_id)->first();
        if($slide)
        {
            return view('front.'.config('common.view.front.template').'.company.slide.detail')->with('data',$slide);
        }
        else dd("幻灯片不存在");
    }


    // 返回（前台）调研列表页视图
    public function view_survey($company)
    {
        $query = Company::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($company)) $company = $query->whereId($company)->first();
        else $company = $query->where('website_name',$company)->first();

        if($company)
        {
            return view('front.'.config('common.view.front.template').'.company.survey.list')->with('company',$company);
        }
        else dd("企业不存在");
    }
    // 返回（前台）调研详情页视图
    public function view_survey_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $survey = Survey::with(['company','admin'])->whereId($decode_id)->first();
        if($survey)
        {
            return view('front.'.config('common.view.front.template').'.company.survey.detail')->with('data',$survey);
        }
        else dd("调研不存在");
    }


    // 返回（前台）文章列表页视图
    public function view_article($company)
    {
        $query = Company::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        if(is_numeric($company)) $company = $query->whereId($company)->first();
        else $company = $query->where('website_name',$company)->first();

        if($company)
        {
            return view('front.'.config('common.view.front.template').'.company.article.list')->with('company',$company);
        }
        else dd("企业不存在");
    }
    // 返回（前台）文章详情页视图
    public function view_article_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $article = Article::with(['company','admin'])->whereId($decode_id)->first();
        if($article)
        {
            return view('front.'.config('common.view.front.template').'.company.article.detail')->with('data',$article);
        }
        else dd("文章不存在");
    }

}