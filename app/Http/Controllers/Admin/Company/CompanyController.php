<?php

namespace App\Http\Controllers\Admin\Company;

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


    public function index()
    {
//        return view('admin.company.index');
        return $this->repo->view_admin_index(request()->all());
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.company.edit');
//        if(request()->isMethod('get'))  return $this->repo->view_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function editAction()
    {
//        if(request()->isMethod('get')) return view('admin.company.edit');
        if(request()->isMethod('get'))  return $this->repo->view_edit(request()->all());
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
