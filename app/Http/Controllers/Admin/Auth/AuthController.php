<?php
namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Administrator;
use Auth;


class AuthController extends Controller
{
    //
    private $model;
    public function __construct()
    {
        $this->model = new Administrator;
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
            return $this->repo->get_list_datatable(request()->all());
        }
    }





}
