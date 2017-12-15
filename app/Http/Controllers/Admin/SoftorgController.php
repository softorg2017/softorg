<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\SoftorgService;
use App\Repositories\Admin\SoftorgRepository;

class SoftorgController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new SoftorgService;
        $this->repo = new SoftorgRepository;
    }


    public function index()
    {
//        return view('admin.company.index');
        return $this->repo->view_admin_index(request()->all());
    }

    public function editAction()
    {
//        if(request()->isMethod('get')) return view('admin.softorg.edit');
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

    // 下载二维码
    public function download_qrcode()
    {
        return $this->repo->download_qrcode(request()->all());
    }




}
