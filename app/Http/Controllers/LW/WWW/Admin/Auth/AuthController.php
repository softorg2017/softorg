<?php
namespace App\Http\Controllers\LW\WWW\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Root\Admin\RootAuthRepository;

use App\Administrator;
use Response, Auth, Validator, DB, Exception;


class RootAuthController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new RootAuthRepository;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view('root.admin.auth.login');
        }
        else if(request()->isMethod('post'))
        {
            $where['email'] = request()->get('email');
            $where['password'] = request()->get('password');
            $email = request()->get('email');
            $password = request()->get('password');
            $admin = Administrator::whereEmail($email)->first();
            if($admin)
            {
                if($admin->active == 1)
                {
                    if(password_check($password,$admin->password))
                    {
                        Auth::guard('admin')->login($admin,true);
                        return response_success();
                    }
                    else return response_error([],'账户or密码不正确 ');
                }
                else return response_error([],'账户尚未激活，请先去邮箱激活。');
            }
            else return response_error([],'账户不存在');
        }
    }

    // 退出
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/login');
    }





}
