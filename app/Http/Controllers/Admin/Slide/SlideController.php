<?php

namespace App\Http\Controllers\Admin\Slide;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\Slide\SlideService;
use App\Repositories\Admin\Slide\SlideRepository;

class SlideController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new SlideService;
        $this->repo = new SlideRepository;
    }


    public function index()
    {
        return view('admin.slide.index');
    }

    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.slide.list');
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.slide.create');
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
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
