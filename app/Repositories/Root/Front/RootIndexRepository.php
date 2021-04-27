<?php
namespace App\Repositories\Root\Front;

use App\User;

use App\Models\Def\Def_Item;
use App\Models\Def\Def_Pivot_User_Relation;

use App\Models\Root\RootModule;
use App\Models\Root\RootMenu;
use App\Models\Root\RootItem;
use App\Models\Root\RootMessage;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode, Excel;

class RootIndexRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->model = new OrgOrganization;
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


    // root
    public function view_root()
    {
        if(auth()->check())
        {
            return redirect(env('DOMAIN_WWW').'/user/'.auth()->id());
            dd(auth()->user()->username);
        }
        else
        {

        }

        $head_title = "首页 - 朝鲜族组织平台";
        $return['head_title'] = $head_title;

        $page["type"] = 1;
        $page["module"] = 1;
        $page["num"] = 0;
        $page["item_id"] = 0;
        $page["user_id"] = 0;

        $service_items = RootItem::where(['category'=>11, 'menu_id'=>0, 'active'=>1])->orderby('id', 'desc')->paginate(8);
        $return['item_list'] = $service_items;

        $return['user_list'] = [];

//        $return[$sidebar_active] = 'active';
        $return['head_title'] = $head_title;
        $return['getType'] = 'items';
        $return['page_type'] = 'root';
        $return['page'] = $page;



        $view = 'www.frontend.entrance.root';
        return view($view)->with($return);




//        $info = json_decode(json_encode(config('mitong.company.info')));
//        $menus = RootMenu::where(['active'=>1])->orderby('order', 'asc')->get();

        $service_items = RootItem::where(['category'=>11, 'menu_id'=>0, 'active'=>1])->orderby('id', 'desc')->limit(8)->get();
        foreach($service_items as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }


        $template_menu = RootMenu::where(['name'=>'template'])->first();
        if($template_menu)
        {
            $template_items = RootItem::where(['menu_id'=>$template_menu->id, 'active'=>1])->orderby('id', 'desc')->limit(8)->get();
            foreach($template_items as $item)
            {
                $item->custom = json_decode($item->custom);
            }
        }
        else $template_items = [];

        $client_items = RootItem::where(['category'=>51, 'active'=>1])->orderby('id', 'desc')->get();
        $coverage_items = RootItem::where(['category'=>41, 'active'=>1])->orderby('id', 'desc')->get();

        $html = view('root.frontend.entrance.root')->with([
                'service_items'=>$service_items,
                'template_items'=>$template_items,
                'client_items'=>$client_items,
                'coverage_items'=>$coverage_items
            ])->__toString();
        return $html;
    }




    /*
     * 用户基本信息
     */
    // 【基本信息】返回--视图
    public function view_my_info_index()
    {
        $me = Auth::user();
        return view(env('TEMPLATE_ROOT_FRONT').'entrance.my-info-index')->with(['info'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_my_info_edit()
    {
        $me = Auth::user();
        return view(env('TEMPLATE_ROOT_FRONT').'entrance.my-info-edit')->with(['info'=>$me]);
    }
    // 【基本信息】保存-数据
    public function operate_my_info_save($post_data)
    {
        $me = Auth::user();

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            if(!empty($post_data['custom']))
            {
                $post_data['custom'] = json_encode($post_data['custom']);
            }

            $mine_data = $post_data;
            unset($mine_data['operate']);
            unset($mine_data['operate_id']);
            $bool = $me->fill($mine_data)->save();
            if($bool)
            {
                // 头像
                if(!empty($post_data["portrait"]))
                {
                    // 删除原文件
                    $mine_original_file = $me->portrait_img;
                    if(!empty($mine_original_file) && file_exists(storage_path('resource/'.$mine_original_file)))
                    {
                        unlink(storage_path('resource/'.$mine_original_file));
                    }

                    $result = upload_file_storage($post_data["portrait"]);
                    if($result["result"])
                    {
                        $me->portrait_img = $result["local"];
                        $me->save();
                    }
                    else throw new Exception("upload--portrait-img-file--fail");
                }

                // 微信二维码
                if(!empty($post_data["wechat_qr_code"]))
                {
                    // 删除原图片
                    $mine_wechat_qr_code_img = $me->wechat_qr_code_img;
                    if(!empty($mine_wechat_qr_code_img) && file_exists(storage_path("resource/" . $mine_wechat_qr_code_img)))
                    {
                        unlink(storage_path("resource/" . $mine_wechat_qr_code_img));
                    }

                    $result = upload_file_storage($post_data["wechat_qr_code"]);
                    if($result["result"])
                    {
                        $me->wechat_qr_code_img = $result["local"];
                        $me->save();
                    }
                    else throw new Exception("upload--wechat_qr_code--fail");
                }

            }
            else throw new Exception("insert--item--fail");

            DB::commit();
            return response_success(['id'=>$me->id]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }



    // root
    public function view_user1($id)
    {
        if(Auth::check())
        {
//            $me = Auth::user();
//            $return['data'] = $me;

        }
        else
        {
        }

        $user = User::find($id);
        $return['data'] = $user;

        $head_title = "首页 - 朝鲜族组织平台";
        $return['head_title'] = $head_title;

        $page["data"] = 0;

        $view = 'www.frontend.entrance.user';
        return view($view)->with($return);

        dd(1);

        $head_title = "User";

        $page["type"] = 1;
        $page["module"] = 1;
        $page["num"] = 0;
        $page["item_id"] = 0;
        $page["user_id"] = 0;

        $service_items = RootItem::where(['category'=>11, 'menu_id'=>0, 'active'=>1])->orderby('id', 'desc')->paginate(8);
        $return['item_list'] = $service_items;

        $return['user_list'] = [];

//        $return[$sidebar_active] = 'active';
        $return['head_title'] = $head_title;
        $return['getType'] = 'items';
        $return['page_type'] = 'root';
        $return['page'] = $page;



        $view = 'www.frontend.entrance.root';
        return view($view)->with($return);




//        $info = json_decode(json_encode(config('mitong.company.info')));
//        $menus = RootMenu::where(['active'=>1])->orderby('order', 'asc')->get();

        $service_items = RootItem::where(['category'=>11, 'menu_id'=>0, 'active'=>1])->orderby('id', 'desc')->limit(8)->get();
        foreach($service_items as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }


        $template_menu = RootMenu::where(['name'=>'template'])->first();
        if($template_menu)
        {
            $template_items = RootItem::where(['menu_id'=>$template_menu->id, 'active'=>1])->orderby('id', 'desc')->limit(8)->get();
            foreach($template_items as $item)
            {
                $item->custom = json_decode($item->custom);
            }
        }
        else $template_items = [];

        $client_items = RootItem::where(['category'=>51, 'active'=>1])->orderby('id', 'desc')->get();
        $coverage_items = RootItem::where(['category'=>41, 'active'=>1])->orderby('id', 'desc')->get();

        $html = view('root.frontend.entrance.root')->with([
            'service_items'=>$service_items,
            'template_items'=>$template_items,
            'client_items'=>$client_items,
            'coverage_items'=>$coverage_items
        ])->__toString();
        return $html;
    }

    public function view_user($post_data,$id=0)
    {
        $user_id = $id;

        $type = !empty($post_data['type']) ? $post_data['type'] : 'root';

        $user = User::with([
            'introduction',
//                'items'=>function($query) { $query->with('owner')->where(['item_status'=>1,'active'=>1])->orderBy('published_at','desc'); },
//                'ad',
//                'ad_list'=>function($query) { $query->where(['item_category'=>1,'item_type'=>88])->orderby('updated_at','desc'); },
//                'pivot_sponsor_list'=>function($query) { $query->where(['relation_active'=>1,'relation_category'=>88,'relation_type'=>1,'user.user_status'=>1])->orderby('updated_at','desc'); },
//                'pivot_org_list'=>function($query) { $query->where(['relation_active'=>1,'relation_category'=>88,'relation_type'=>1])->orderby('updated_at','desc'); },
        ])
            ->withCount([
                'items as article_count' => function($query) { $query->where(['item_status'=>1,'item_category'=>1,'item_type'=>1]); },
                'items as activity_count' => function($query) { $query->where(['item_status'=>1,'item_category'=>1,'item_type'=>11]); },
            ])
            ->find($user_id);


        if($user)
        {
            if($user->user_category != 1)
            {
                $error["text"] = '该用户拒绝访问！';
                return view(env('TEMPLATE_ROOT_FRONT').'errors.404')->with('error',$error);
            }
            if($user->user_status != 1)
            {
                $error["text"] = '该用户被禁啦！';
                return view(env('TEMPLATE_DEFAULT').'frontend.errors.404')->with('error',$error);
            }

            if($user->user_type == 11)
            {
                $user->load([
                    'ad',
                    'pivot_sponsor_list'=>function($query) { $query->where(['relation_active'=>1,'relation_category'=>88,'relation_type'=>1,'user.user_status'=>1])->orderby('updated_at','desc'); }
                ]);
            }
            else if($user->user_type == 88)
            {
                $user->load([
                    'pivot_org_list'=>function($query) { $query->where(['relation_active'=>1,'relation_category'=>88,'relation_type'=>1])->orderby('updated_at','desc'); }
                ]);
            }
        }
        else
        {
            $error["text"] = '该用户不存在！';
            return view(env('TEMPLATE_ROOT_FRONT').'errors.404')->with('error',$error);
        }


        $user->timestamps = false;
        $user->increment('visit_num');

        $is_follow = 0;

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $record["creator_id"] = $me_id;

            $item_query = Def_Item::with([
                'owner',
//                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])
                ->where('item_status',1)
                ->where('active',1)
                ->where('owner_id',$user_id);

            if($type == 'root')
            {
                $item_query->whereIn('item_type',[1,11]);
                $record["page_module"] = 1; // page_module=0 default index
            }
            else if($type == 'introduction')
            {
                $record["page_module"] = 2; // page_module=2 introduction
            }
            else if($type == 'article')
            {
                $item_query->whereIn('item_type',[1]);
                $record["page_module"] = 9; // page_module=0 article
            }
            else if($type == 'activity')
            {
                $item_query->whereIn('item_type',[11]);
                $record["page_module"] = 11; // page_module=0 activity
            }
            else
            {
                $record["page_module"] = 1; // page_module=0 default index
            }

            $item_list = $item_query->orderBy('published_at','desc')->paginate(20);

            if($user_id != $me_id)
            {
                $relation = Def_Pivot_User_Relation::where(['relation_category'=>1,'mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
                view()->share(['relation'=>$relation]);
            }

            $relation_with_me = Def_Pivot_User_Relation::where(['relation_category'=>1,'mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
            if($relation_with_me &&  in_array($relation_with_me->relation_type,[21,41]))
            {
                $is_follow = 1;
            }
        }
        else
        {
            $item_query = Def_Item::with(['owner'])
                ->where('item_status',1)
                ->where('active',1)
                ->where('owner_id',$user_id);

            if($type == 'root')
            {
                $item_query->whereIn('item_type',[1,11]);
                $record["page_module"] = 1; // page_module=0 default index
            }
            else if($type == 'introduction')
            {
                $record["page_module"] = 2; // page_module=2 introduction
            }
            else if($type == 'article')
            {
                $item_query->whereIn('item_type',[1]);
                $record["page_module"] = 9; // page_module=0 article
            }
            else if($type == 'activity')
            {
                $item_query->whereIn('item_type',[11]);
                $record["page_module"] = 11; // page_module=0 activity
            }
            else
            {
                $record["page_module"] = 1; // page_module=0 default index
            }

            $item_list = $item_query->orderBy('published_at','desc')->paginate(20);
        }

        foreach ($item_list as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }
//        dd($item->toArray());


        if($type == 'root')
        {
            $record["page_module"] = 1;  // page_module=0 default index
        }
        else if($type == 'introduction')
        {
            $record["page_module"] = 2;  // page_module=2 introduction
        }
        else if($type == 'article')
        {
            $record["page_module"] = 9;  // page_module=0 article
        }
        else if($type == 'activity')
        {
            $record["page_module"] = 11;  // page_module=0 activity
        }
        else
        {
            $record["page_module"] = 1;  // page_module=0 default index
        }

        // 插入记录表
        $record["record_category"] = 1; // record_category=1 browse/share
        $record["record_type"] = 1; // record_type=1 browse
        $record["page_type"] = 2; // page_type=2 user
        $record["page_num"] = $item_list->toArray()["current_page"];
        $record["object_id"] = $user_id;
        $record["from"] = request('from',NULL);
//        $this->record($record);


        $page["type"] = 2;
        $page["module"] = 1;
        $page["num"] = $item_list->toArray()["current_page"];
        $page["item_id"] = 0;
        $page["user_id"] = $id;

        $sidebar_active = '';
        if($type == 'root')
        {
            $sidebar_active = 'sidebar_menu_root_active';
            $page["module"] = 1;
        }
        else if($type == 'introduction')
        {
            $sidebar_active = 'sidebar_menu_introduction_active';
            $page["module"] = 2;
        }
        else if($type == 'article')
        {
            $sidebar_active = 'sidebar_menu_article_active';
            $page["module"] = 9;
        }
        else if($type == 'activity')
        {
            $sidebar_active = 'sidebar_menu_activity_active';
            $page["module"] = 11;
        }
        else if($type == 'org')
        {
            $sidebar_active = 'sidebar_menu_org_active';
            $page["module"] = 1;
        }


        view()->share('user_root_active','active');
        return view(env('TEMPLATE_ROOT_FRONT').'entrance.user')
            ->with([
                'data'=>$user,
                'item_list'=>$item_list,
                'is_follow'=>$is_follow,
                'page' => $page,
                $sidebar_active => 'active',
            ]);
    }


    // contact
    public function contact()
    {
        $houses = RootItem::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->get();
        foreach($houses as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }

        $html = view('frontend.entrance.contact')->with(['houses'=>$houses])->__toString();
        return $html;
    }




    // 【出租】
    public function view_rent_out_list()
    {
        $items = RootItem::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->paginate(8);
        foreach($items as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }

        $rent_items = RootItem::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->limit(6)->get();

        $html = view('frontend.entrance.list-for-rent-out')->with(['items'=>$items, 'rent_items'=>$rent_items])->__toString();
        return $html;
    }

    // 【二手批发】
    public function view_second_wholesale_list()
    {
        $items = RootItem::where(['category'=>12, 'active'=>1])->orderby('id', 'desc')->paginate(8);
        foreach($items as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }

        $rent_items = RootItem::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->limit(6)->get();

        $html = view('frontend.entrance.list-for-second-wholesale')->with(['items'=>$items, 'rent_items'=>$rent_items])->__toString();
        return $html;
    }

    // 【回收】
    public function view_recycle_page()
    {
        $items = RootItem::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->get();
        foreach($items as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }

        $html = view('frontend.entrance.page-for-recycle')->with(['items'=>$items])->__toString();
        return $html;
    }

    // 【资讯】
    public function view_coverage_list()
    {
        $items = RootItem::where(['category'=>31, 'active'=>1])->orderby('id', 'desc')->paginate(8);
        foreach($items as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->custom2 = json_decode($item->custom2);
        }

        $rent_items = RootItem::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->limit(6)->get();

        $html = view('frontend.entrance.list-for-coverage')->with(['items'=>$items, 'rent_items'=>$rent_items])->__toString();
        return $html;
    }




    // item
    public function view_item($id = 0)
    {
        if($id != 0) $mine = RootItem::where(['id'=>$id])->orderby('id', 'desc')->first();
        else $mine = RootItem::orderby('id', 'desc')->first();

        $mine->timestamps = false;
        $mine->increment('visit_num');

        $mine->custom = json_decode($mine->custom);
        $mine->custom2 = json_decode($mine->custom2);

        $rent_items = RootItem::where(['category'=>11, 'active'=>1])->where('id', '<>', $id)->orderby('id', 'desc')->limit(6)->get();
        foreach($rent_items as $item)
        {
            $item->custom = json_decode($item->custom);
        }

        $html = view('frontend.entrance.item')->with(['rent_items'=>$rent_items, 'item'=>$mine])->__toString();
        return $html;
    }




    // item
    public function view_template_item($id = 0)
    {
        if($id != 0) $mine = RootItem::where(['id'=>$id])->orderby('id', 'desc')->first();
        else $mine = RootItem::orderby('id', 'desc')->first();

        $mine->timestamps = false;
        $mine->increment('visit_num');

        $mine->custom = json_decode($mine->custom);

        $html = view('root.frontend.entrance.item-template')->with(['item'=>$mine])->__toString();
        return $html;
    }




    // 留言
    public function message_contact($post_data)
    {
        $messages = [
            'name.required' => '请输入姓名',
            'mobile.required' => '请输入电话',
        ];
        $v = Validator::make($post_data, [
            'name' => 'required',
            'mobile' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $post_data['category'] = 1;
            $mine = new RootMessage;
            $bool = $mine->fill($post_data)->save();
            if(!$bool) throw new Exception("insert--message--fail");

            DB::commit();
            $msg = '提交成功！';
            return response_success([],$msg);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '提交失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }



    }


    // ITEM 留言
    public function message_grab_item($post_data)
    {
        $messages = [
            'name.required' => '请输入姓名',
            'mobile.required' => '请输入电话',
        ];
        $v = Validator::make($post_data, [
            'name' => 'required',
            'mobile' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $post_data['category'] = 11;
            $mine = new RootMessage;
            $bool = $mine->fill($post_data)->save();
            if(!$bool) throw new Exception("insert--message--fail");

            DB::commit();
            $msg = '提交成功！';
            return response_success([],$msg);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '提交失败，请重试！';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }



    }




}