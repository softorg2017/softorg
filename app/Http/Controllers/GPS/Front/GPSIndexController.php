<?php
namespace App\Http\Controllers\GPS\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\GPS\Front\GPSIndexRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class GPSIndexController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new GPSIndexRepository;
    }

	public function index()
	{
        return view('admin.index.index');
	}

    public function dataTableI18n()
    {
    	return trans('pagination.i18n');
    }




    // 导航
    public function view_developing()
    {
        return $this->repo->view_developing();
//        return view(env('TEMPLATE_GPS').'developing.index');
    }


    // 导航
    public function view_template_test()
    {
        return view(env('TEMPLATE_GPS').'template.test');
    }

    // 导航
    public function view_template_metinfo()
    {
        return view(env('TEMPLATE_GPS').'template.metinfo');
    }







}

