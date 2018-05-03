<?php
namespace App\Http\Controllers\Root;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Root\CaseRepository;

class CaseController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new CaseRepository;
    }



    // 返回主页视图
    public function view_metinfo()
    {
        return $this->repo->view_metinfo();
    }



}
