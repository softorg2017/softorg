<?php
namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\UserExt;
use Auth, Validator, DB;


class AuthController extends Controller
{
    //
    private $model;
    public function __construct()
    {
        $this->model = new User;
    }

    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view('front.'.config('common.view.front.template').'.auth.login');
        }
        else if(request()->isMethod('post'))
        {
            $where['email'] = request()->get('email');
            $where['password'] = request()->get('password');
            $email = request()->get('email');
            $password = request()->get('password');
            $admin = User::whereEmail($email)->first();
            if($admin)
            {
                if(password_check($password,$admin->password))
                {
                    Auth::login($admin,true);
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
        Auth::logout();
        return redirect('/user/login');
    }

    // 注册
    public function register()
    {
        if(request()->isMethod('get'))
        {
            return view('front.'.config('common.view.front.template').'.auth.register');
        }
        else if(request()->isMethod('post'))
        {
            $post_data = request()->all();

            $message = array(
                "required" => ":attribute 不能为空",
                "between" => ":attribute 长度有误",
                "email" => ":attribute 格式有误",
                "unique" => ":attribute 已存在",
            );
            $attributes = array(
                "email" => '电子邮件',
                'password' => '用户密码',
                'name' => '用户名',
            );
            $validator = Validator::make($post_data, [
                'email' => 'required|email',
                'password' => 'required|between:1,20',
                'password_confirm' => 'required|between:1,20',
                'name' => 'required|between:1,64',
            ],$message, $attributes);
//            dd($validator->errors()->toArray());

            if ($validator->fails()) {
                return response_error([],"数据有误");
            }

            $name = request()->get('name');
            $email = request()->get('email');
            $password = request()->get('password');
            $password_confirm = request()->get('password_confirm');
            if($password != $password_confirm) return response_error([],'两次密码不一致');

            $user = User::whereEmail($email)->first();
            if(!$user)
            {
                DB::beginTransaction();
                try {
                    $register["email"] = $email;
                    $register["password"] = password_encode($password);
                    $register["name"] = $name;
                    $user = User::create($register);

                    $user_id = $user->id;
                    $registerExt["user_id"] = $user_id;
                    $registerExt["name"] = $name;
                    $user_info = UserExt::create($registerExt);

                    DB::commit();
                    return response_success([],"注册成功，请登录！");
                } catch (PDOException $ex) {
                    DB::rollback();
                    return response_error([],'注册失败，请刷新页面重试！');
                }
            }
            else return response_error([],'该邮箱已经注册过啦！');
        }
    }





}
