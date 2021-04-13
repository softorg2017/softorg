<?php
namespace App\Repositories\Common;

use App\Mail\OrderShipped;
use Illuminate\Support\Facades\Mail;

use Response, Auth, Validator, DB, Excepiton, Config;

class MailRepository {

    private $host;
    private $port;
    private $username;
    private $password;

    public function __construct()
    {
        $this->host = env('SOFTORG_MAIL_HOST');
        $this->port = env('SOFTORG_MAIL_PORT');
        $this->username = env('SOFTORG_MAIL_USERNAME');
        $this->password = env('SOFTORG_MAIL_PASSWORD');
    }

    // 发送管理员激活邮件
    public function send_admin_activation_email($post_data)
    {
//        Mail::to('longyun-cui@163.com')->send(new OrderShipped());
        Config::set('mail.host',$this->host);
        Config::set('mail.port',$this->port);
        Config::set('mail.username',$this->username);
        Config::set('mail.password',$this->password);

        $variate['host'] = $post_data['host'];
        $variate['user_id'] = $post_data['user_id'];
        $variate['code'] = $post_data['code'];

        // 第一个参数填写模板的路径，第二个参数填写传到模板的变量
        Mail::send('org.email.register.activation', $variate, function ($message) use ($post_data) {

            $message->from($this->username, '管理员'); // 发件人（你自己的邮箱和名称）
            $message->to($post_data['target']); // 收件人的邮箱地址
            $message->subject('激活邮箱'); // 邮件主题
        });

        return Mail::failures();
    }


}