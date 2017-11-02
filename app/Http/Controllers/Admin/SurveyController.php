<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\SurveyService;
use App\Repositories\Admin\SurveyRepository;

class SurveyController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new SurveyService;
        $this->repo = new SurveyRepository;
    }



    public function index()
    {
        return view('admin.survey.index');
    }

    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.survey.list');
        else if (request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.survey.create');
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function sortAction()
    {
        return $this->repo->sort(request()->all());
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
