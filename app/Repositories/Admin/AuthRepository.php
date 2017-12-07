<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Administrator;
use App\Repositories\Common\CommonRepository;
use Response, Auth, Validator, DB, Excepiton;
use QrCode;

class AuthRepository {

    private $model;
    public function __construct()
    {
    }

    // 注册
    public function register_org($post_data)
    {
        $messages = [
            'website_name.unique' => '企业域名已经存在，请更换一个名字',
            'website_name.alpha' => '企业域名必须是英文字符',
            'email.unique' => '管理员邮箱已存在，请更换邮箱',
        ];
        $v = Validator::make($post_data, [
            'website_name' => 'required|alpha|unique:softorg',
            'email' => 'required|email|unique:administrator',
            'password' => 'required',
            'password_confirm' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $website_name = $post_data['website_name'];
        $email = $post_data['email'];
        $password = $post_data['password'];
        $password_confirm = $post_data['password_confirm'];
        if($password == $password_confirm)
        {
            $org = new Softorg;
            $org_create['website_name'] = $website_name;
            $bool = $org->fill($org_create)->save();
            if($bool)
            {
                $admin = new Administrator;
                $admin_create['org_id'] = $org->id;
                $admin_create['email'] = $email;
                $admin_create['password'] = password_encode($password);
                $bool = $admin->fill($admin_create)->save();
                if($bool) return response_success([],'注册成功');
                else response_fail([],'注册失败！');
            }
            else return response_fail([],'注册失败！');
        }
        else return response_error([],'密码不一致！');

    }


}