<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;



class CommonController extends Controller
{
    //
    private $repo;
    private $sms;

    public function __construct()
    {
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
