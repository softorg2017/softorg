<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\ProductService;
use App\Repositories\Admin\ProductRepository;

class ProductController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new ProductService;
        $this->repo = new ProductRepository;
    }



    public function index()
    {
        return view('admin.company.product.index');
    }

    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.product.list');
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    public function createAction()
    {
//        if(request()->isMethod('get')) return view('admin.company.product.edit');
        if(request()->isMethod('get')) return $this->repo->view_create(request()->all());
        else if (request()->isMethod('post')) $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function deleteAction()
    {
        return $this->repo->delete(request()->all());
    }

    public function getAction()
    {
        return $this->repo->get(request()->all());
    }




}
