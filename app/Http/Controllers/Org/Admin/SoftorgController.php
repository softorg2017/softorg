<?php
namespace App\Http\Controllers\Org\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\SoftorgService;
use App\Repositories\Admin\SoftorgRepository;

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


    public function index()
    {
//        return view('admin.company.index');
        return $this->repo->view_admin_index(request()->all());
    }

    // 编辑基本资料
    public function editAction()
    {
//        if(request()->isMethod('get')) return view('admin.softorg.edit');
        if(request()->isMethod('get'))  return $this->repo->view_edit();
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }



    // 编辑 自定义首页
    public function homeAction()
    {
        if(request()->isMethod('get'))  return $this->repo->view_edit_home();
        else if (request()->isMethod('post')) return $this->repo->save_ext(request()->all());
    }
    // 编辑 自定义信息
    public function informationAction()
    {
        if(request()->isMethod('get'))  return $this->repo->view_edit_information();
        else if (request()->isMethod('post')) return $this->repo->save_ext(request()->all());
    }
    // 编辑 简介
    public function introductionAction()
    {
        if(request()->isMethod('get'))  return $this->repo->view_edit_introduction();
        else if (request()->isMethod('post')) return $this->repo->save_ext(request()->all());
    }
    // 编辑 联系我们
    public function contactusAction()
    {
        if(request()->isMethod('get'))  return $this->repo->view_edit_contactus();
        else if (request()->isMethod('post')) return $this->repo->save_ext(request()->all());
    }
    // 编辑 企业文化
    public function cultureAction()
    {
        if(request()->isMethod('get'))  return $this->repo->view_edit_culture();
        else if (request()->isMethod('post')) return $this->repo->save_ext(request()->all());
    }











    public function deleteAction()
    {
        return $this->repo->delete(request()->all());
    }

    public function getAction()
    {
        return $this->repo->get(request()->all());
    }

    // 下载根二维码
    public function download_root_qrcode()
    {
        return $this->repo->download_root_qrcode(request()->all());
    }

    // 下载二维码
    public function download_qrcode()
    {
        return $this->repo->download_qrcode(request()->all());
    }




}
