<?php

namespace App\Http\Controllers\Admin\Article;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\Article\ArticleService;
use App\Repositories\Admin\Article\ArticleRepository;

class ArticleController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new ArticleService;
        $this->repo = new ArticleRepository;
    }


    public function index()
    {
        return view('admin.article.index');
    }

    // 列表
    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.article.list');
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    // 添加
    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.article.edit');
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    // 编辑
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
