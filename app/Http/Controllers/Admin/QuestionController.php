<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\QuestionService;
use App\Repositories\Admin\QuestionRepository;

class QuestionController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new QuestionService;
        $this->repo = new QuestionRepository;
    }



    public function index()
    {
        return view('admin.survey.question.index');
    }

    public function viewList()
    {
        if(request()->isMethod('get')) return view('admin.survey.question.list');
        else if (request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return view('admin.survey.question.edit');
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
