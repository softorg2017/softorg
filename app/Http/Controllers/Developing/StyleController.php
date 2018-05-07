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
    //
    public function view_gps()
    {
        return view('templates.themes.index');
    }


    // 返回（前台）【根】视图
    public function view_enterprise_index()
    {
        return $this->repo->view_enterprise_index(request()->all());
    }



    //
    public function view_wicked()
    {
        return view('templates.themes.style.wicked');
    }

    //
    public function view_swimming_line()
    {
        return view('templates.themes.swimming.line');
    }
    //
    public function view_swimming_tadpole()
    {
        return view('templates.themes.swimming.tadpole');
    }
    //
    public function view_animate_hover()
    {
        return view('templates.themes.style.hover');
    }
    //
    public function view_animate_hover2()
    {
        return view('templates.themes.style.hover2');
    }
    //
    public function view_animate_3d_rotate()
    {
        return view('templates.themes.style.3d-rotate');
    }
    //
    public function view_animate_floating_button()
    {
        return view('templates.themes.style.floating-button');
    }
    //
    public function view_on_context_menu()
    {
        return view('templates.themes.style.on-context-menu');
    }






}
