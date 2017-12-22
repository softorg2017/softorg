<?php
namespace App\Http\Controllers\Super;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\SoftorgService;
use App\Repositories\Super\SuperRepository;

class SuperController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new SuperRepository;
    }



    // 返回主页视图
    public function index()
    {
        return $this->repo->view_super_index();
    }

    // 列表
    public function viewList()
    {
        if(request()->isMethod('get')) return view('super.list');
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    // 返回自定义首页视图
    public function home($org_name)
    {
        return $this->repo->view_home($org_name);
    }

    // 返回自定义简介视图
    public function introduction($org_name)
    {
        return $this->repo->view_introduction($org_name);
    }

    // 返回自定义联系我们视图
    public function information($org_name)
    {
        return $this->repo->view_information($org_name);
    }



    // 返回产品列表视图
    public function product($org_name)
    {
        return $this->repo->view_product($org_name);
    }
    // 返回产品详情视图
    public function view_product_detail()
    {
        return $this->repo->view_product_detail();
    }



    // 返回活动列表视图
    public function activity($org_name)
    {
        return $this->repo->view_activity($org_name);
    }
    // 返回活动详情视图
    public function view_activity_detail()
    {
        return $this->repo->view_activity_detail();
    }
    // 返回活动报名视图
    public function view_activity_apply()
    {
        return $this->repo->view_activity_apply();
    }



    // 返回调研列表视图
    public function survey($org_name)
    {
        return $this->repo->view_survey($org_name);
    }
    // 返回调研详情视图
    public function view_survey_detail()
    {
        return $this->repo->view_survey_detail();
    }



    // 返回幻灯片列表视图
    public function slide($org_name)
    {
        return $this->repo->view_slide($org_name);
    }
    // 返回幻灯片详情视图
    public function view_slide_detail()
    {
        return $this->repo->view_slide_detail();
    }



    // 返回文章列表视图
    public function article($org_name)
    {
        return $this->repo->view_article($org_name);
    }
    // 返回文章详情视图
    public function view_article_detail()
    {
        return $this->repo->view_article_detail();
    }



    // 活动报名
    public function apply()
    {
        return $this->repo->apply(request()->all());
    }

    // 非注册用户报名email确认
    public function apply_activation()
    {
        return $this->repo->apply_activation(request()->all());
    }

    // 活动签到
    public function sign()
    {
        return $this->repo->sign(request()->all());
    }


    // 调研回答
    public function answer()
    {
        return $this->repo->answer(request()->all());
    }



}
