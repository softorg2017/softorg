<?php
namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Root\IndexRepository;

class IndexController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new IndexRepository;
    }



    // 返回主页视图
    public function index()
    {
        return $this->repo->index();
    }

    // 返回主页视图
    public function view_website_templates()
    {
        return $this->repo->website_templates();
    }



}
