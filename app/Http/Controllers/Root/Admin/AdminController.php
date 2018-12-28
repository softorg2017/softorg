<?php
namespace App\Http\Controllers\Root\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Root\Admin\AdminRepository;

class AdminController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new AdminRepository;
    }


    public function index()
    {
//        return view('admin.company.index');
        return $this->repo->view_admin_index();
    }


    public function view_404()
    {
        return view('admin.errors.404');
    }



}
