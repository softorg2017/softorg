<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\MenuService;
use App\Repositories\Admin\MenuRepository;

class MenuController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new MenuService;
        $this->repo = new MenuRepository;
    }



    public function index()
    {
        return view('admin.menu.index');
    }

    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.menu.list');
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    // 添加
    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.menu.edit');
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
