<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Admin\MailRepository;

class TestController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
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


}
