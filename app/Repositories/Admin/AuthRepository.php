<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Models\SoftorgExt;
use App\Administrator;
use App\Models\Website;
use App\Models\Verification;
use App\Repositories\Common\CommonRepository;
use Response, Auth, Validator, DB, Exception;
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
            'type.required' => '请选择机构类型',
            'type.numeric' => '请选择机构代码',
            'captcha.required' => '请输入验证码',
            'captcha.captcha' => '验证码有误',
            'website_name.unique' => '企业域名已经存在，请更换一个名字',
            'website_name.alpha' => '企业域名必须是英文字符',
            'email.unique' => '管理员邮箱已存在，请更换邮箱',
        ];
        $v = Validator::make($post_data, [
            'captcha' => 'required|captcha',
            'type' => 'required|numeric',
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


        $type = $post_data['type'];
        $name = $post_data['name'];
        $website_name = $post_data['website_name'];
        $email = $post_data['email'];
        $password = $post_data['password'];
        $password_confirm = $post_data['password_confirm'];
        if($password == $password_confirm)
        {
            DB::beginTransaction();
            try
            {
                // 注册企业
                $org = new Softorg;
                $org_create['type'] = $type;
                $org_create['name'] = $name;
                $org_create['website_name'] = $website_name;
                $bool_1 = $org->fill($org_create)->save();
                if($bool_1)
                {
                    $ext = new SoftorgExt();
                    $ext_create['org_id'] = $org->id;
                    $bool_2 = $ext->fill($ext_create)->save();
                    if($bool_2)
                    {
                        $website = new Website();
                        $website_create['org_id'] = $org->id;
                        $bool_3 = $website->fill($website_create)->save();
                        if($bool_3)
                        {
                            // 注册超级管理员
                            $admin = new Administrator;
                            $admin_create['org_id'] = $org->id;
                            $admin_create['email'] = $email;
                            $admin_create['password'] = password_encode($password);
                            $bool_4 = $admin->fill($admin_create)->save();
                            if($bool_4)
                            {
                                $string = 'org_id='.$org->id.'&admin_id='.$admin->id.'&time='.time();
                                $code = hash("sha512", $string);

                                $verification_create['type'] = 1;
                                $verification_create['org_id'] = $org->id;
                                $verification_create['admin_id'] = $admin->id;
                                $verification_create['email'] = $email;
                                $verification_create['code'] = $code;

                                $verification = new Verification;
                                $bool4 = $verification->fill($verification_create)->save();
                                if($bool4)
                                {
                                    $post_data['host'] = config('common.host');
                                    $post_data['sort'] = 'admin_activation';
                                    $post_data['type'] = 1;
                                    $post_data['admin_id'] = encode($admin->id);
                                    $post_data['code'] = $code;
                                    $post_data['target'] = $email;

//                                    $mail = new MailRepository();
    //                                $flag = $mail->send_admin_activation_email($post_data);
    //                                if(count($flag) >= 1)
    //                                {
    //                                }

//                                    $url = 'http://qingorg.cn:8088/email/send';
                                    $url = config('common.MailService').'/softorg/email/activation';
                                    $ch = curl_init();
                                    curl_setopt($ch, CURLOPT_URL, $url);
                                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
                                    curl_setopt($ch, CURLOPT_POST, 1);
                                    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                                    $response = curl_exec($ch);
                                    curl_close($ch);
                                    if(empty($response)) throw new Exception('curl get request failed');
                                    else
                                    {
                                        $response = json_decode($response,true);
                                        if(!$response['success']) throw new Exception("send-email-failed");
                                    }
                                }
                            }
                            else throw new Exception("insert-admin-failed");
                        }
                        else throw new Exception("insert-website-failed");
                    }
                    else throw new Exception("insert-org-ext-failed");
                }
                else throw new Exception("insert-org-failed");

                DB::commit();
                return response_success([],'注册成功,请前往邮箱激活管理员');
            }
            catch (Exception $e)
            {
                DB::rollback();
//                exit($e->getMessage());
                $msg = $e->getMessage();
                $msg = '注册失败！';
                return response_fail([], $msg);
            }
        }
        else return response_error([],'密码不一致！');
    }

    // 管理员激活
    public function activation($post_data)
    {
        $admin_id = decode($post_data['admin']);
        $where['admin_id'] = $admin_id;
        $where['type'] = $post_data['type'];
        $where['code'] = $post_data['code'];
        $verification = Verification::where($where)->first();
        if($verification)
        {
            if($verification->active == 0)
            {
                $admin = Administrator::where('id',$admin_id)->first();
                if($admin)
                {
                    $admin->active = 1;
                    $bool1 = $admin->save();
                    if($bool1)
                    {
                        $verification->active = 1;
                        $bool2 = $verification->save();
                        header("Refresh:5;url=/admin");
                        if($bool2) echo('验证成功，5秒后跳转后台页面！');
                        else echo('验证成功2，5秒后跳转后台页面！');
                    }
                    else dd('验证失败');
                }
            }
            else
            {
                header("Refresh:5;url=/admin");
                echo('已经验证过了，5秒后跳转后台页面！');
            }
        }
        else dd('参数有误');
    }


}