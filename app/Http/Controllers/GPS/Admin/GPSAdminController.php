<?php
namespace App\Http\Controllers\GPS\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\GPS\Admin\GPSAdminRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class GPSAdminController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new GPSAdminRepository;
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
    public function navigation()
    {
        return view(env('TEMPLATE_GPS_ADMIN').'entrance.navigation');
    }

    // 测试
    public function test_list()
    {
        return view(env('TEMPLATE_GPS_ADMIN').'entrance.test-list');
    }

    // 工具
    public function tool_list()
    {
        return view(env('TEMPLATE_GPS_ADMIN').'entrance.tool-list');
    }

    // 模板
    public function template_list()
    {
        return view(env('TEMPLATE_GPS_ADMIN').'entrance.template-list');
    }



    //
    public function tool()
    {
        $type = request()->get("type");
        if($type == "type")
        {
            return response_success([],"type");
        }
        // 生成密码
        else if($type == "password_encode")
        {
            $password = request("password");
            $password_encode = password_encode($password);
            return response_success(['password_encode'=>$password_encode]);
        }
        else if($type == "xx")
        {
            return response_success([]);
        }
    }




}

