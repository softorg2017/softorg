<?php

namespace App\Http\Controllers\Developing;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
    }


    public function index()
    {
        return view('developing.index');
    }

    public function index1()
    {
        return view('developing.index1');
    }


}
