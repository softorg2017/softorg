<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Admin\MailRepository;

//发送短信的模块
use App\Services\MessageService;

class TestController extends Controller
{
    //
    private $repo;
    private $sms;

    public function __construct()
    {
        $this->sms = new MessageService();
    }


    public function index()
    {
        return view('admin.company.index');
    }

    public function send_email()
    {
        $send = new MailRepository();
        $post_data['admin_id'] = encode('123');
        $post_data['code'] = sha1('123');
        $post_data['target'] = 'longyun-cui@163.com';
        $send->send_admin_activation_email($post_data);
    }

    public function send_sms()
    {
        dd($this->sms->send_SMS('15800689433', 'verification_code', ['code' => 664664]));
    }
}
