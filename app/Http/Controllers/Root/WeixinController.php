<?php
namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Root\WeixinRepository;

class WeixinController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new WeixinRepository;
    }



    // 返回主页视图
    public function index()
    {
        return $this->repo->index();
    }

    // 公众号
    public function gongzhonghao()
    {
        $this->repo->gongzhonghao();
    }



}
