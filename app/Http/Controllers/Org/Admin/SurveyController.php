<?php
namespace App\Http\Controllers\Org\Admin;

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
        if(request()->isMethod('get')) return $this->repo->view_create();
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit();
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    // 【排序】
    public function sortAction()
    {
        return $this->repo->sort(request()->all());
    }

    // 【删除】
    public function deleteAction()
    {
        return $this->repo->delete(request()->all());
    }

    // 【启用】
    public function enableAction()
    {
        return $this->repo->enable(request()->all());
    }

    // 【禁用】
    public function disableAction()
    {
        return $this->repo->disable(request()->all());
    }

    public function getAction()
    {
        return $this->repo->get(request()->all());
    }




}
