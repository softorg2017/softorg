<?php
namespace App\Http\Controllers\Inside\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Inside\InsideRepository;

class InsideController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new InsideRepository;
    }


    // 返回主页视图
    public function index()
    {
        return $this->repo->view_admin_index();
    }





}
