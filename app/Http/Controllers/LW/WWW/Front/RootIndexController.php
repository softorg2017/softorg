<?php
namespace App\Http\Controllers\LW\WWW\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\LW\WWW\Front\RootIndexRepository;

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

//        $this->middleware(function ($request, $next)
//        {
//            dd(request()->session()->all());
//            return $next($request);
//        });
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
    public function operate_my_doc_account_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_doc_account_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_my_doc_account_save(request()->all());
    }
    // 【轻博】编辑
    public function operate_my_doc_account_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_doc_account_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_my_doc_account_save(request()->all());
    }
    // 【轻博】列表
    public function view_my_doc_account_list()
    {
        return $this->repo->view_my_doc_account_list(request()->all());
    }
    // 登录我的轻博
    public function operate_my_doc_account_login()
    {
        return $this->repo->operate_my_doc_account_login(request()->all());
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
    public function view_my_card_index()
    {
        return $this->repo->view_my_card_index();
    }

    // 编辑【基本信息】
    public function view_my_card_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_card_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_my_card_save(request()->all());
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





    /*
     *
     */
    // 【ITEM】添加
    public function operate_item_item_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_item_item_save(request()->all());
    }
    // 【ITEM】编辑
    public function operate_item_item_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_item_item_save(request()->all());
    }
    // 【任务】获取-详情
    public function operate_item_task_get()
    {
        return $this->repo->operate_item_task_get(request()->all());
    }




    // 【ITEM】删除
    public function operate_item_item_delete()
    {
        return $this->repo->operate_item_item_delete(request()->all());
    }
    // 【ITEM】恢复
    public function operate_item_item_restore()
    {
        return $this->repo->operate_item_item_restore(request()->all());
    }
    // 【ITEM】永久删除
    public function operate_item_item_delete_permanently()
    {
        return $this->repo->operate_item_item_delete_permanently(request()->all());
    }
    // 【ITEM】发布
    public function operate_item_item_publish()
    {
        return $this->repo->operate_item_item_publish(request()->all());
    }
    // 【ITEM】完成
    public function operate_item_item_complete()
    {
        return $this->repo->operate_item_item_complete(request()->all());
    }
    // 【ITEM】禁用
    public function operate_item_item_disable()
    {
        return $this->repo->operate_item_admin_disable(request()->all());
    }
    // 【ITEM】启用
    public function operate_item_item_enable()
    {
        return $this->repo->operate_item_admin_enable(request()->all());
    }




    // 【ITEM-Content】内容管理
    public function view_item_content_management()
    {
        return $this->repo->view_item_content_management(request()->all());
    }

    // 【ITEM-Content】【编辑】
    public function operate_item_content_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post'))
        {
            $item_type  = request('item_type',0);
            $item_type_name  = request('item-type','');
            if($item_type == 11 && $item_type_name == 'menu_type')
            {
                return $this->repo->operate_item_content_save_for_menu_type(request()->all());
            }
            else if($item_type == 18 && $item_type_name == 'time_line')
            {
                return $this->repo->operate_item_content_save_for_time_line(request()->all());
            }
            else
            {
                return $this->repo->operate_item_content_save(request()->all());
            }
        }
    }

    // 【【ITEM-Content】编辑】目录类型
    public function operate_item_content_edit_menu_type()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_content_save_for_menu_type(request()->all());
    }
    // 【ITEM-Content】【编辑】时间线
    public function operate_item_content_edit_time_line()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_content_save_for_time_line(request()->all());
    }


    // 【ITEM-content】移动位置
    public function operate_item_content_move_menu_type()
    {
        return $this->repo->operate_item_content_move_menu_type(request()->all());
    }
    // 【ITEM-content】移动位置
    public function operate_item_content_move_time_line()
    {
        return $this->repo->operate_item_content_move_time_line(request()->all());
    }




    // 【ITEM-Content】【获取】
    public function operate_item_content_get()
    {
        return $this->repo->operate_item_content_get(request()->all());
    }
    // 【ITEM-Content】【删除】
    public function operate_item_content_delete()
    {
        return $this->repo->operate_item_content_delete(request()->all());
    }
    // 【ITEM-Content】【启用】
    public function operate_item_content_publish()
    {
        return $this->repo->operate_item_content_publish(request()->all());
    }
    // 【ITEM-Content】【启用】
    public function operate_item_content_enable()
    {
        return $this->repo->operate_item_content_enable(request()->all());
    }
    // 【ITEM-Content】【禁用】
    public function operate_item_content_disable()
    {
        return $this->repo->operate_item_content_disable(request()->all());
    }






    // 【点赞】
    public function operate_item_add_favor()
    {
        return $this->repo->operate_item_add_this(request()->all(),11);
    }
    public function operate_item_remove_favor()
    {
        return $this->repo->operate_item_remove_this(request()->all(),11);
    }
    // 【收藏】
    public function operate_item_add_collection()
    {
        return $this->repo->operate_item_add_this(request()->all(),21);
    }
    public function operate_item_remove_collection()
    {
        return $this->repo->operate_item_remove_this(request()->all(),21);
    }
    // 【待办事】
    public function operate_item_add_todo_list()
    {
        return $this->repo->operate_item_add_this(request()->all(),41);
    }
    public function operate_item_remove_todo_list()
    {
        return $this->repo->operate_item_remove_this(request()->all(),41);
    }
    // 【日程】
    public function operate_item_add_schedule()
    {
        return $this->repo->operate_item_add_this(request()->all(),51);
    }
    public function operate_item_remove_schedule()
    {
        return $this->repo->operate_item_remove_this(request()->all(),51);
    }
    // 【转发】
    public function operate_item_forward()
    {
        return $this->repo->operate_item_forward(request()->all());
    }





    // 返回【详情】视图
    public function view_item($id=0)
    {
        return $this->repo->view_item(request()->all(),$id);
    }

    // 返回【详情】视图
    public function view_template_item($id=0)
    {
        return $this->repo->view_template_item($id);
    }




    /*
     * 列表
     */
    // 【我的】
    public function view_item_list_for_mine()
    {
        return $this->repo->view_item_list_for_mine(request()->all());
    }
    // 【我的原创】
    public function view_home_mine_original()
    {
        return $this->repo->view_item_list_for_my_original(request()->all());
    }

    // 【我的待办事】
    public function view_item_list_for_my_todo_list()
    {
        return $this->repo->view_item_list_for_my_todo_list(request()->all());
    }
    // 【我的日程】
    public function view_item_list_for_my_schedule()
    {
        return $this->repo->view_item_list_for_my_schedule(request()->all());
    }
    // 【点赞内容】
    public function view_item_list_for_my_favor()
    {
        return $this->repo->view_item_list_for_my_favor(request()->all());
    }
    // 【收藏内容】
    public function view_item_list_for_my_collection()
    {
        return $this->repo->view_item_list_for_my_collection(request()->all());
    }
    // 【发现】
    public function view_home_mine_discovery()
    {
        return $this->repo->view_item_list_for_my_discovery(request()->all());
    }
    // 【我的关注】
    public function view_home_mine_follow()
    {
        return $this->repo->view_item_list_for_my_follow(request()->all());
    }
    // 【我的好友圈】
    public function view_home_mine_circle()
    {
        return $this->repo->view_item_list_for_my_circle(request()->all());
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
