<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\WebsiteService;
use App\Repositories\Admin\WebsiteRepository;

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

    public function statistics()
    {
        return $this->repo->view_statistics(request()->all());
//        if(request()->isMethod('get')) return $this->repo->view_statistics(request()->all());
//        else if (request()->isMethod('post')) return $this->repo->statistics(request()->all());
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.website.edit');
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit();
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
