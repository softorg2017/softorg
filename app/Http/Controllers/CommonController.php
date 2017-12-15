<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\SoftorgService;
use App\Repositories\Admin\SoftorgRepository;


class CommonController extends Controller
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
        return view('admin.company.index');
    }

    public function change_captcha()
    {
        return response_success(['src'=>captcha_src()],'');
//        return response_success(['img'=>captcha_img()],'');
    }

}
