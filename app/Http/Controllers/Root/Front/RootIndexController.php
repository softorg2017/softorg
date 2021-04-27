<?php
namespace App\Http\Controllers\Root\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Root\Front\RootIndexRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode, Excel;

class RootIndexController extends Controller
{

    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new RootIndexRepository;
    }




    // 主页视图
    public function view_root()
    {
        return $this->repo->view_root();
    }


    // 【K】【】
    public function login_link()
    {
        $state  = url()->previous();
        if(is_weixin())
        {
            $app_id = env('WECHAT_LOOKWIT_APPID');
            $app_secret = env('WECHAT_LOOKWIT_SECRET');
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$app_id}&redirect_uri=http%3A%2F%2Fwww.lookwit.com%2Fweixin%2Fauth&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect";
            return redirect($url);

        }
        else
        {
            $app_id = env('WECHAT_WEBSITE_LOOKWIT_APPID');
            $app_secret = env('WECHAT_WEBSITE_LOOKWIT_SECRET');
            $url = "https://open.weixin.qq.com/connect/qrconnect?appid={$app_id}&redirect_uri=http%3A%2F%2Fwww.lookwit.com%2Fweixin%2Flogin&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
            return redirect($url);
        }
    }

    // 退出
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }




    // 【K】【基本信息】返回
    public function view_my_info_index()
    {
        return $this->repo->view_my_info_index();
    }

    // 【K】【基本信息】编辑
    public function view_my_info_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_info_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_my_info_save(request()->all());
    }

    // 返回【联系我们】视图
    public function view_contact()
    {
        return $this->repo->contact();
    }

    // 返回【详情】视图
    public function view_user($id=0)
    {
        return $this->repo->view_user(request()->all(),$id);
    }

    // 返回【详情】视图
    public function view_item($id=0)
    {
        return $this->repo->view_item($id);
    }

    // 返回【详情】视图
    public function view_template_item($id=0)
    {
        return $this->repo->view_template_item($id);
    }


    // 返回【钢琴出租】【列表】视图
    public function view_rent_out_list()
    {
        return $this->repo->view_rent_out_list();
    }
    // 返回【二手批发】【列表】视图
    public function view_second_wholesale_list()
    {
        return $this->repo->view_second_wholesale_list();
    }

    // 返回【钢琴回收】【单页】视图
    public function view_recycle_page()
    {
        return $this->repo->view_recycle_page();
    }


    // 返回【最新动态】【列表】视图
    public function view_coverage_list()
    {
        return $this->repo->view_coverage_list();
    }



    // 【留言】
    public function message_contact()
    {
        return $this->repo->message_contact(request()->all());
    }
    // 【询价】
    public function message_grab_item()
    {
        return $this->repo->message_grab_item(request()->all());
    }



}
