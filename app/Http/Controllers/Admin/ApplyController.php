<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\ApplyService;
use App\Repositories\Admin\ApplyRepository;

class ApplyController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new ApplyService;
        $this->repo = new ApplyRepository;
    }



    public function index()
    {
        return view('admin.apply.index');
    }

    // 列表
    public function viewList()
    {
        if(request()->isMethod('get')) return $this->repo->view_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }




}
