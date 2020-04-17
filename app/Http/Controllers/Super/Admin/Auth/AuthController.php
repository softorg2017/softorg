<?php
namespace App\Http\Controllers\Super\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Super\SuperAdministrator;

use App\Repositories\Org\Admin\OrgAuthRepository;

use Response, Auth, Validator, DB, Exception;


class AuthController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new OrgAuthRepository;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view('super.admin.auth.login');
        }
        else if(request()->isMethod('post'))
        {
            $where['email'] = request()->get('email');
            $where['mobile'] = request()->get('mobile');
            $where['password'] = request()->get('password');

//            $email = request()->get('email');
//            $admin = SuperAdministrator::whereEmail($email)->first();

            $mobile = request()->get('mobile');
            $admin = SuperAdministrator::whereMobile($mobile)->first();

            if($admin)
            {
                if($admin->active == 1)
                {
                    $password = request()->get('password');
                    if(password_check($password,$admin->password))
                    {
                        $remember = request()->get('remember');
                        if($remember) Auth::guard('super_admin')->login($admin,true);
                        else Auth::guard('super_admin')->login($admin);
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
        Auth::guard('super_admin')->logout();
        return redirect('/super-admin/login');
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

    public function activation()
    {
        return $this->repo->activation(request()->all());
    }





}
