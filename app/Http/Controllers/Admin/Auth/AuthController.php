<?php
namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\AuthService;
use App\Repositories\Admin\AuthRepository;
use App\Models\Softorg;
use App\Administrator;
use Response, Auth, Validator, DB, Excepiton;


class AuthController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new AuthService;
        $this->repo = new AuthRepository;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view('admin.auth.login');
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
                if(password_check($password,$admin->password))
                {
                    Auth::guard('admin')->login($admin,true);
                    return response_success();
                }
                else return response_error([],'账户or密码不正确 ');
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

    // 注册
    public function register()
    {
        if(request()->isMethod('get'))
        {
            return view('admin.auth.register');
        }
        else if(request()->isMethod('post'))
        {
        }
    }

    // 注册新机构
    public function register_org()
    {
        return $this->repo->register_org(request()->all());
    }





}
