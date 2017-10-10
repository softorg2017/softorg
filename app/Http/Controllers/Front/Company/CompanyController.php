<?php
namespace App\Http\Controllers\Front\Company;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\Company\CompanyService;
use App\Repositories\Admin\Company\CompanyRepository;

class CompanyController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new CompanyService;
        $this->repo = new CompanyRepository;
    }

    // 返回主页视图
    public function index($company_name)
    {
        return $this->repo->view_index($company_name);
    }



    // 返回产品列表视图
    public function product($company_name)
    {
        return $this->repo->view_product($company_name);
    }
    // 返回产品详情视图
    public function view_product_detail()
    {
        return $this->repo->view_product_detail();
    }



    // 返回活动列表视图
    public function activity($company_name)
    {
        return $this->repo->view_activity($company_name);
    }
    // 返回活动详情视图
    public function view_activity_detail()
    {
        return $this->repo->view_activity_detail();
    }



    // 返回调研列表视图
    public function survey($company_name)
    {
        return $this->repo->view_survey($company_name);
    }
    // 返回调研详情视图
    public function view_survey_detail()
    {
        return $this->repo->view_survey_detail();
    }



    // 返回幻灯片列表视图
    public function slide($company_name)
    {
        return $this->repo->view_slide($company_name);
    }
    // 返回幻灯片详情视图
    public function view_slide_detail()
    {
        return $this->repo->view_slide_detail();
    }



    // 返回文章列表视图
    public function article($company_name)
    {
        return $this->repo->view_article($company_name);
    }
    // 返回文章详情视图
    public function view_article_detail()
    {
        return $this->repo->view_article_detail();
    }



}
