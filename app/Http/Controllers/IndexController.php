<?php

namespace App\Http\Controllers;

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
        return view('admin.company.index');
    }


}
