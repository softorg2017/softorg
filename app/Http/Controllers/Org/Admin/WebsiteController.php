<?php
namespace App\Http\Controllers\Org\Admin;

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

    public function viewStyle()
    {
        if(request()->isMethod('get')) return $this->repo->view_style();
        else if (request()->isMethod('post')) return $this->repo->save_style(request()->all());
    }









}
