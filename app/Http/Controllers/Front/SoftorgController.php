<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\SoftorgService;
use App\Repositories\Admin\SoftorgRepository;
use App\Repositories\Admin\SurveyRepository;

class SoftorgController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new SoftorgService;
        $this->repo = new SoftorgRepository;
    }



    // 返回主页视图
    public function index($org_name)
    {
        return $this->repo->view_index($org_name);
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



    // 调研回答
    public function answer()
    {
        return $this->repo->answer(request()->all());
    }



}
