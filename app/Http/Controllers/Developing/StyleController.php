<?php

namespace App\Http\Controllers\Developing;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Developing\StyleRepository;


class StyleController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new StyleRepository;
    }


    // 返回（前台）【根】视图
    public function view_enterprise_index()
    {
        return $this->repo->view_enterprise_index(request()->all());
    }




    //
    //
    public function view_animate_hover_screen_1()
    {
        return view('templates.themes.style.hover-screen-1');
    }






}
