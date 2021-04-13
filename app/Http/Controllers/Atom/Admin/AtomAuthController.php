<?php
namespace App\Http\Controllers\Atom\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Doc\Doc_Item;

use App\Repositories\Atom\Admin\AtomAuthRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;


class AtomAuthController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new AtomAuthRepository;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view('org.admin.auth.login');
        }
        else if(request()->isMethod('post'))
        {
            $where['email'] = request()->get('email');
            $where['mobile'] = request()->get('mobile');
            $where['password'] = request()->get('password');

//            $email = request()->get('email');
//            $admin = OrgAdministrator::whereEmail($email)->first();

            $mobile = request()->get('mobile');
            $admin = OrgAdministrator::whereMobile($mobile)->first();

            if($admin)
            {
                if($admin->active == 1)
                {
                    $password = request()->get('password');
                    if(password_check($password,$admin->password))
                    {
                        $remember = request()->get('remember');
                        if($remember) Auth::guard('org_admin')->login($admin,true);
                        else Auth::guard('org_admin')->login($admin);
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
        Auth::guard('org_admin')->logout();
        return redirect(config('common.org.admin.prefix').'/login');
    }

    // 注册
    public function register()
    {
        if(request()->isMethod('get'))
        {
            return view('org.admin.auth.register');
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
