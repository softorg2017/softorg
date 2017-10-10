<?php

namespace App\Http\Controllers\Admin\Company;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\Company\WebsiteService;
use App\Repositories\Admin\Company\WebsiteRepository;

class WebsiteController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new WebsiteService;
        $this->repo = new WebsiteRepository;
    }


    public function index()
    {
        return view('admin.website.index');
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.company.website.edit');
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return view('admin.company.website.edit');
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
