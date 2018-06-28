<?php
namespace App\Http\Controllers\Outside\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Lib\Wechat\TokenManager;

use App\Repositories\Outside\OutsideRepository;

class OutsideController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new OutsideRepository;
    }


    // 返回主页视图
    public function index()
    {
        return $this->repo->view_admin_index();
    }


    // 返回主页视图
    public function weixin_getToken()
    {
        echo TokenManager::getToken();
    }





}
