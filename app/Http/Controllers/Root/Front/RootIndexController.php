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




    // 【平台首页】视图
    public function view_root()
    {
        return $this->repo->view_root();
    }

    // 【平台介绍】视图
    public function view_introduction()
    {
        return $this->repo->view_introduction();
    }




    // 登录
    public function login_link()
    {
        $state = urlencode(url()->previous());
        $return = request('return',null);
        if($return == 'root') $state = '';
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




    // 【轻博】创建
    public function operate_my_doc_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_doc_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_my_doc_save(request()->all());
    }
    // 【轻博】编辑
    public function operate_my_doc_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_doc_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_my_doc_save(request()->all());
    }
    // 【轻博】列表
    public function view_my_doc_list()
    {
        return $this->repo->view_my_doc_list(request()->all());
    }
    // 登录我的轻博
    public function operate_my_doc_login()
    {
        return $this->repo->operate_my_doc_login(request()->all());
    }
    // 登录我的轻博
    public function operate_login_my_doc()
    {
        return $this->repo->operate_login_my_doc(request()->all());
    }




    // 【分享】
    public function record_share()
    {
        return $this->repo->record_share(request()->all());
    }




    // 返回【基本信息】视图
    public function view_my_info_index()
    {
        return $this->repo->view_my_info_index();
    }

    // 编辑【基本信息】
    public function view_my_info_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_info_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_my_info_save(request()->all());
    }

    // 编辑【图文详情】
    public function view_my_introduction_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_introduction_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_my_introduction_save(request()->all());
    }







    // 【添加关注】
    public function user_relation_add()
    {
        return $this->repo->user_relation_add(request()->all());
    }
    // 【取消关注】
    public function user_relation_remove()
    {
        return $this->repo->user_relation_remove(request()->all());
    }



    // 【我的名片】
    public function view_my_card()
    {
        return $this->repo->view_my_card();
    }
    // 【我的名片夹】
    public function view_my_cards_case()
    {
        return $this->repo->view_my_cards_case(request()->all());
    }
    // 【我的关注】
    public function view_my_follow()
    {
        return $this->repo->view_my_follow(request()->all());
    }
    // 【我的粉丝】
    public function view_my_fans()
    {
        return $this->repo->view_my_fans(request()->all());
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
