<?php

namespace App\Http\Controllers\Admin\Slide;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\Slide\PageService;
use App\Repositories\Admin\Slide\PageRepository;

class PageController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new PageService;
        $this->repo = new PageRepository;
    }


    public function index()
    {
        return view('admin.slide.page.index');
    }

    // 幻灯片列表
    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.slide.page.list');
        else if(request()->isMethod('post')) return $this->repo->view_list(request()->all());
    }

    // 幻灯页排序
    public function orderAction()
    {
        return $this->repo->order(request()->all());
    }

    // 添加幻灯页
    public function addAction()
    {

        if(request()->isMethod('get')) return view('admin.slide.page.edit');
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    // 编辑幻灯页
    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    // 删除
    public function deleteAction()
    {
        return $this->repo->delete(request()->all());
    }

    public function getAction()
    {
        return $this->repo->get(request()->all());
    }


}
