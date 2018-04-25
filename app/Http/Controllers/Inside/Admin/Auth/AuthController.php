<?php
namespace App\Http\Controllers\Inside\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Inside\InsideAdministrator;

use Response, Auth, Validator, DB, Exception;


class AuthController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
//        $this->repo = new InsideAuthRepository;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view('inside.admin.auth.login');
        }
        else if(request()->isMethod('post'))
        {
            $where['email'] = request()->get('email');
            $where['password'] = request()->get('password');
            $email = request()->get('email');
            $password = request()->get('password');
            $admin = InsideAdministrator::whereEmail($email)->first();
            if($admin)
            {
                if($admin->active == 1)
                {
                    if(password_check($password,$admin->password))
                    {
                        Auth::guard('inside_admin')->login($admin,true);
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
        Auth::guard('inside_admin')->logout();
        return redirect('/inside/admin/login');
    }






}
