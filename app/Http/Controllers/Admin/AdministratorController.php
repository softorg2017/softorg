<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Administrator;
use Response, Auth, Validator, DB, Excepiton;

class AdministratorController extends Controller
{

	public function index()
	{
        return view('admin.index.index');
	}

    // 添加
    public function password_reset()
    {
        if(request()->isMethod('get')) return view('admin.administrator.password');
        else if (request()->isMethod('post'))
        {
            $post_data = request()->all();
            $messages = [
                'password_pre.required' => '请输入旧密码',
                'password_new.required' => '请输入新密码',
                'password_confirm.required' => '请输入确认密码',
            ];
            $v = Validator::make($post_data, [
                'password_pre' => 'required',
                'password_new' => 'required',
                'password_confirm' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $messages = $v->errors();
                return response_error([],$messages->first());
            }

            $password_pre = request()->get('password_pre');
            $password_new = request()->get('password_new');
            $password_confirm = request()->get('password_confirm');

            if($password_new == $password_confirm)
            {
                $admin = Auth::guard('admin')->user();
                if(password_check($password_pre,$admin->password))
                {
                    Auth::guard('admin')->login($admin,true);
                    $admin->password = password_encode($password_new);
                    $bool = $admin->save();
                    if($bool) return response_success([], '密码修改成功');
                    else return response_fail([], '密码修改失败');
                }
            }
            else response_error([],'两次密码输入不一致');
        }
    }
}
