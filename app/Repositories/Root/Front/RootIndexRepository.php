<?php
namespace App\Repositories\Root\Front;

use App\Http\Middleware\WwwMiddleware;

use App\User;
use App\UserExt;

use App\Models\Def\Def_Item;
use App\Models\Def\Def_Pivot_User_Item;
use App\Models\Def\Def_Pivot_User_Relation;
use App\Models\Def\Def_Pivot_Item_Relation;
use App\Models\Def\Def_Communication;
use App\Models\Def\Def_Notification;
use App\Models\Def\Def_Record;

use App\Models\Root\RootModule;
use App\Models\Root\RootMenu;
use App\Models\Root\RootItem;
use App\Models\Root\RootMessage;

use App\Repositories\Common\CommonRepository;

use Request, Response, Auth, Validator, DB, Exception, Cache;
use QrCode, Excel;

class RootIndexRepository {

    private $evn;
    private $auth_check;
    private $me;
    private $me_admin;
    private $model;
    private $modelItem;
    private $repo;
    private $service;
    public function __construct()
    {
        $this->modelUser = new User;
        $this->modelItem = new Def_Item;

        if(explode('.',request()->route()->getAction()['domain'])[0] == 'test')
        {
            $this->env = 'test';
        }
        else
        {
            $this->env = 'production';
        }

    }


    public function get_me()
    {
        if($this->env == 'test')
        {
            if(Auth::guard('test')->check())
            {
                $this->auth_check = 1;
                $this->me = Auth::guard('test')->user();
            }
        }
        else
        {
            if(Auth::check())
            {
                $this->auth_check = 1;
                $this->me = Auth::user();
            }
            else $this->auth_check = 0;
        }
    }


    // 返回【平台首页】视图
    public function view_root()
    {
        $this->get_me();

        $head_title = "如未科技";
        $return['head_title'] = $head_title;

        $page["type"] = 1;
        $page["module"] = 1;
        $page["num"] = 0;
        $page["item_id"] = 0;
        $page["user_id"] = 0;


        // 插入记录表
        $record["record_category"] = 1; // record_category=1 browse/share
        $record["record_type"] = 1; // record_type=1 browse
        $record["page_type"] = 1; // page_type=1 default platform
        $record["page_module"] = 1; // page_module=1 index
//        $record["page_num"] = $item_list->toArray()["current_page"];
        $record["page_num"] = 1;
        $record["from"] = request('from',NULL);
        $this->record($record);


        $item_type = request('item-type','recommend');
        if($item_type == 'recommend')
        {
            $item_query = $this->modelItem->select('*')
                ->with(['owner','creator'])
                ->where('owner_id','>',0)
                ->where(['item_category'=>1]);

            if($this->auth_check)
            {
                $me_id = $this->me->id;
                $item_query->with([
                    'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
                ]);
            }

            $item_list = $item_query->orderByDesc('published_at')->orderByDesc('updated_at')->paginate(20);
            foreach($item_list as $item)
            {
                $item->custom = json_decode($item->custom);
                $item->content_show = strip_tags($item->content);
                $item->img_tags = get_html_img($item->content);

                if(@getimagesize(env('DOMAIN_CDN').'/'.$item->cover_pic))
                {
                    $item->cover_picture = env('DOMAIN_CDN').'/'.$item->cover_pic;
                }
                else
                {
                    if(!empty($item->img_tags[0])) $item->cover_picture = $item->img_tags[2][0];
                }
            }
            $return['item_list'] = $item_list;

            $return['menu_active_for_recommend'] = 'active';
        }
        else if($item_type == 'focus')
        {
            $return['menu_active_for_focus'] = 'active';
        }
        else if($item_type == 'community')
        {
            $return['menu_active_for_community'] = 'active';
        }
        else
        {
        }

        $return['getType'] = 'items';
        $return['page_type'] = 'root';
        $return['page'] = $page;


        $condition = request()->all();
        $return['condition'] = $condition;

        $head_title_text = '首页';
        $head_title_prefix = '【轻博】';
        $head_title_prefix = '';
        $head_title_postfix = ' - 如未科技';

        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return['menu_active_for_root'] = 'active';

        view()->share('menu_active_for_root','active');

        $view = env('TEMPLATE_ROOT_FRONT').'entrance.root';
        return view($view)->with($return);

//        $html = view($view)->with($return)->__toString();
//        return $html;
    }

    // 返回【平台介绍】视图
    public function view_introduction()
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $record["creator_id"] = $me_id;
        }
        else $me_id = 0;

        $introduction = Def_Item::find(1);


        // 插入记录表
        $record["record_category"] = 1; // record_category=1 browse/share
        $record["record_type"] = 1; // record_type=1 browse
        $record["page_type"] = 1; // page_type=1 default platform
        $record["page_module"] = 2; // page_module=2 introduction
        $record["page_num"] = 1;
        $record["from"] = request('from',NULL);
        $this->record($record);

        $page["type"] = 1;
        $page["module"] = 2;
        $page["num"] = 0;
        $page["item_id"] = 0;
        $page["user_id"] = 0;

        $return['data'] = $introduction;
        $return['page'] = $page;

        $path = request()->path();

        return view(env('TEMPLATE_ROOT_FRONT').'entrance.root-introduction')->with($return);
    }




    // 【分享记录】
    public function record_share($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $record["creator_id"] = $me_id;
        }
        else $me_id = 0;

        $record_module = isset($post_data["record_module"]) ? $post_data["record_module"] : 0;
        $page_type = isset($post_data["page_type"]) ? $post_data["page_type"] : 0;
        $page_module = isset($post_data["page_module"]) ? $post_data["page_module"] : 0;
        $page_num = isset($post_data["page_num"]) ? $post_data["page_num"] : 0;
        $item_id = isset($post_data["item_id"]) ? $post_data["item_id"] : 0;
        $user_id = isset($post_data["user_id"]) ? $post_data["user_id"] : 0;

        // 插入记录表
        $record["record_category"] = 1; // record_category=1 browse/share
        $record["record_type"] = 2; // record_type=2 share
        $record["record_module"] = $record_module; // record_module 1.微信好友|QQ好友 2.朋友圈|QQ空间
        $record["page_type"] = $page_type; // page_type=1 default platform
        $record["page_module"] = $page_module; // page_module=2 introduction
        $record["page_num"] = $page_num;
        $record["item_id"] = $item_id;
        $record["object_id"] = $user_id;
        $record["from"] = request('from',NULL);
        $this->record($record);

        if($page_type == 1)
        {

        }
        else if($page_type == 2)
        {
            $user = User::find($user_id);
            $user->timestamps = false;
            $user->increment('share_num');
        }
        else if($page_type == 3)
        {
            $item = Def_Item::find($item_id);
            $item->timestamps = false;
            $item->increment('share_num');

            $user = User::find($item->owner_id);
            $user->timestamps = false;
            $user->increment('share_num');
        }

        return response_success([]);
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

//                    $result = upload_img_storage($post_data["portrait"],'','root/common');
                    $result = upload_img_storage($post_data["portrait"],'user_'.$me->id,'root/unique/portrait','assign');
                    if($result["result"])
                    {
                        $me->portrait_img = $result["local"];
                        $me->save();
                    }
                    else throw new Exception("upload--portrait_img--file--fail");
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

                    $result = upload_img_storage($post_data["wechat_qr_code"],'','root/common');
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




    // 【我的】【我的轻博账户】
    public function view_my_doc_account_list($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_list = User::with([])
                ->where(['user_category'=>9,'creator_id'=>$me_id])
                ->orderby('id','desc')
                ->paginate(20);

//            foreach ($user_list as $user)
//            {
//                $user->relation_with_me = $user->relation_type;
//            }

        }
        else return response_error([],"请先登录！");

        $return['user_list'] = $user_list;
        $return['menu_active_for_my_doc_account_list'] = 'active';

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.my-doc-list';
        return view($view_blade)->with($return);
    }




    // 【图文详情】返回-编辑-视图
    public function view_my_introduction_edit()
    {
        $me = Auth::user();
        $ext = UserExt::where('user_id',$me->id)->first();
        return view(env('TEMPLATE_ROOT_FRONT').'entrance.my-introduction-edit')->with(['data'=>$ext]);
    }
    // 【图文详情】保存-数据
    public function operate_my_introduction_save($post_data)
    {
        $me = Auth::user();

        $ext = UserExt::where('user_id',$me->id)->first();

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
            $bool = $ext->fill($mine_data)->save();
            if($bool)
            {
            }
            else throw new Exception("insert--ext--fail");

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




    // 【用户】首页
    public function view_my_card()
    {
        $me = Auth::user();
        $user_id = $me->id;

        $type = !empty($post_data['type']) ? $post_data['type'] : 'root';

        $user = User::select('*')
            ->with([
                'ext'
            ])
            ->withCount([
//                'items as article_count' => function($query) { $query->where(['item_status'=>1,'item_category'=>1,'item_type'=>1]); },
//                'items as activity_count' => function($query) { $query->where(['item_status'=>1,'item_category'=>1,'item_type'=>11]); },
            ])
            ->find($user_id);


        $is_follow = 0;

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $record["creator_id"] = $me_id;


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
        }


        $condition = request()->all();
        $return['condition'] = $condition;
        $return['data'] = $user;
        $return['is_follow'] = $is_follow;
        $return['menu_active_for_my_card'] = 'active';

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.my-card';
        return view($view_blade)->with($return);
    }

    // 【用户】首页
    public function view_user($post_data,$id=0)
    {
        $user_id = $id;

        $type = !empty($post_data['type']) ? $post_data['type'] : 'root';

        $user = User::select('*')
            ->with([
                'ext'
            ])
            ->withCount([
//                'items as article_count' => function($query) { $query->where(['item_status'=>1,'item_category'=>1,'item_type'=>1]); },
//                'items as activity_count' => function($query) { $query->where(['item_status'=>1,'item_category'=>1,'item_type'=>11]); },
            ])
            ->find($user_id);


        if($user)
        {
            if(!in_array($user->user_category,[1,9,11,88]))
            {
                $error["text"] = '该用户拒绝访问！';
                return view(env('TEMPLATE_ROOT_FRONT').'errors.404')->with('error',$error);
            }
            if($user->user_status != 1)
            {
                $error["text"] = '该用户被禁啦！';
                return view(env('TEMPLATE_ROOT_FRONT').'errors.404')->with('error',$error);
            }
        }
        else
        {
            $error["text"] = '该用户不存在！';
            return view(env('TEMPLATE_ROOT_FRONT').'errors.404')->with('error',$error);
        }


        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $record["creator_id"] = $me_id;
        }

        // 访问记录
        if(Auth::check() && Auth::id() == $user_id)
        {
        }
        else
        {
            $user->timestamps = false;
            $user->increment('visit_num');

            // 插入记录表
            $record["record_category"] = 1; // record_category=1 browse/share
            $record["record_type"] = 1; // record_type=1 browse
            $record["page_type"] = 2; // page_type=2 user
//        $record["page_num"] = $item_list->toArray()["current_page"];
            $record["page_num"] = 1;
            $record["object_id"] = $user_id;
            $record["from"] = request('from',NULL);
            $this->record($record);
        }



        $is_follow = 0;

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            $record["creator_id"] = $me_id;


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


        $page["type"] = 2;
        $page["module"] = 1;
//        $page["num"] = $item_list->toArray()["current_page"];
        $page["num"] = 1;
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
//                'item_list'=>$item_list,
                'is_follow'=>$is_follow,
                'page' => $page,
                $sidebar_active => 'active',
            ]);
    }




    // 【添加关注】
    public function user_relation_add($post_data)
    {
        $messages = [
            'user_id.required' => '参数有误',
            'user_id.numeric' => '参数有误',
            'user_id.exists' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'user_id' => 'required|numeric|exists:user,id'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_id = $post_data['user_id'];
            $user = User::find($user_id);

            DB::beginTransaction();
            try
            {
                $me_relation = Def_Pivot_User_Relation::where(['relation_category'=>1,'mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
                if($me_relation)
                {
                    if($me_relation->relation_type == 71) $me_relation->relation_type = 21;
                    else $me_relation->relation_type = 41;
                    $me_relation->save();
                }
                else
                {
                    $me_relation = new Def_Pivot_User_Relation;
                    $me_relation->relation_category = 1;
                    $me_relation->relation_type = 41;
                    $me_relation->mine_user_id = $me_id;
                    $me_relation->relation_user_id = $user_id;
                    $me_relation->save();
                }
                $me->timestamps = false;
                $me->increment('follow_num');

                $it_relation = Def_Pivot_User_Relation::where(['relation_category'=>1,'mine_user_id'=>$user_id,'relation_user_id'=>$me_id])->first();
                if($it_relation)
                {
                    if($it_relation->relation_type == 41) $it_relation->relation_type = 21;
                    else $it_relation->relation_type = 71;
                    $it_relation->save();
                }
                else
                {
                    $it_relation = new Def_Pivot_User_Relation;
                    $it_relation->relation_category = 1;
                    $it_relation->relation_type = 71;
                    $it_relation->mine_user_id = $user_id;
                    $it_relation->relation_user_id = $me_id;
                    $it_relation->save();
                }
                $user->timestamps = false;
                $user->increment('fans_num');

                $notification_insert['notification_category'] = 9;
                $notification_insert['notification_type'] = 1;
                $notification_insert['owner_id'] = $user_id;
                $notification_insert['user_id'] = $user_id;
                $notification_insert['belong_id'] = $user_id;
                $notification_insert['source_id'] = $me_id;

                $notification = new Def_Notification;
                $bool = $notification->fill($notification_insert)->save();
                if(!$bool) throw new Exception("insert--notification--fail");

                DB::commit();
                return response_success(['relation_type'=>$me_relation->relation_type]);
            }
            catch (Exception $e)
            {
                DB::rollback();
                $msg = '操作失败，请重试！';
                $msg = $e->getMessage();
//                exit($e->getMessage());
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");
    }
    // 【取消关注】
    public function user_relation_remove($post_data)
    {
        $messages = [
            'user_id.required' => '参数有误',
            'user_id.numeric' => '参数有误',
            'user_id.exists' => '参数有误',
        ];
        $v = Validator::make($post_data, [
            'user_id' => 'required|numeric|exists:user,id'
        ], $messages);
        if ($v->fails())
        {
            $errors = $v->errors();
            return response_error([],$errors->first());
        }

        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_id = $post_data['user_id'];
            $user = User::find($user_id);

            DB::beginTransaction();
            try
            {
                $me_relation = Def_Pivot_User_Relation::where(['relation_category'=>1,'mine_user_id'=>$me_id,'relation_user_id'=>$user_id])->first();
                if($me_relation)
                {
                    if($me_relation->relation_type == 21)
                    {
                        $me_relation->relation_type = 71;
                        $me_relation->save();
                    }
                    else if($me_relation->relation_type == 41)
                    {
//                        $me_relation->relation_type = 91;
//                        $me_relation->save();

                        $bool = $me_relation->delete();
                        if(!$bool) throw new Exception("delete--pivot_relation--fail");
                    }
                    else
                    {
//                        $me_relation->relation_type = 91;
//                        $me_relation->save();

                        $bool = $me_relation->delete();
                        if(!$bool) throw new Exception("delete--pivot_relation--fail");
                    }
                }
                $me->timestamps = false;
                $me->decrement('follow_num');

                $it_relation = Def_Pivot_User_Relation::where(['relation_category'=>1,'mine_user_id'=>$user_id,'relation_user_id'=>$me_id])->first();
                if($it_relation)
                {
                    if($it_relation->relation_type == 21)
                    {
                        $it_relation->relation_type = 41;
                        $it_relation->save();
                    }
                    else if($it_relation->relation_type == 71)
                    {
//                        $it_relation->relation_type = 92;
//                        $it_relation->save();

                        $bool = $it_relation->delete();
                        if(!$bool) throw new Exception("delete--pivot_relation--fail");
                    }
                    else
                    {
//                        $it_relation->relation_type = 92;
//                        $it_relation->save();

                        $bool = $it_relation->delete();
                        if(!$bool) throw new Exception("delete--pivot_relation--fail");
                    }
                }
                $user->timestamps = false;
                $user->decrement('fans_num');

                DB::commit();
                return response_success(['relation_type'=>$me_relation->relation_type]);
            }
            catch (Exception $e)
            {
                DB::rollback();
                $msg = '操作失败，请重试！';
                $msg = $e->getMessage();
//                exit($e->getMessage());
                return response_fail([], $msg);
            }
        }
        else return response_error([],"请先登录！");
    }




    // 【user-list】【我的关注】
    public function view_my_follow($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_list = Def_Pivot_User_Relation::with([
                    'relation_user'=>function($query) {
                        $query->withCount([
                            'fans_list as fans_count' => function($query) { $query->where(['relation_type'=>41]); },
//                            'items as article_count' => function($query) { $query->where(['item_category'=>1,'item_type'=>1]); },
//                            'items as activity_count' => function($query) { $query->where(['item_category'=>1,'item_type'=>11]); },
                        ]);
                    },
                ])
                ->where(['mine_user_id'=>$me_id])
                ->whereIn('relation_type',[21,41])
                ->orderby('id','desc')
                ->paginate(20);

            foreach ($user_list as $user)
            {
                $user->relation_with_me = $user->relation_type;
            }

        }
        else return response_error([],"请先登录！");

        $return['user_list'] = $user_list;
        $return['right_menu_my_follow_active'] = 'active';
        $return['sidebar_menu_my_follow_active'] = 'active';

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.my-follow';
        return view($view_blade)->with($return);
    }
    // 【user-list】【我的粉丝】
    public function view_my_fans($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_list = Def_Pivot_User_Relation::with(['relation_user'])
                ->where(['mine_user_id'=>$me_id])->whereIn('relation_type',[21,71])
                ->get();
            foreach ($user_list as $user)
            {
                $user->relation_with_me = $user->relation_type;
            }
        }
        else return response_error([],"请先登录！");


        return view(env('TEMPLATE_ROOT_FRONT').'entrance.my-fans')
            ->with([
                'user_list'=>$user_list,
                'sidebar_menu_my_fans_active'=>'active'
            ]);
    }


    // 【user-list】【我的名片夹】
    public function view_my_cards_case($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $user_list = Def_Pivot_User_Relation::with([
                'relation_user'=>function($query) {
                    $query->withCount([
//                        'fans_list as fans_count' => function($query) { $query->where(['relation_type'=>41]); },
                            'items as article_count' => function($query) { $query->where(['item_category'=>1,'item_type'=>1]); },
//                            'items as activity_count' => function($query) { $query->where(['item_category'=>1,'item_type'=>11]); },
                    ]);
                },
            ])
                ->where(['mine_user_id'=>$me_id])
                ->whereIn('relation_type',[21,41])
                ->orderby('id','desc')
                ->paginate(20);

            foreach ($user_list as $user)
            {
                $user->relation_with_me = $user->relation_type;
            }

        }
        else return response_error([],"请先登录！");

        $return['user_list'] = $user_list;
        $return['menu_active_for_my_cards_case'] = 'active';

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.my-follow';
        return view($view_blade)->with($return);
    }









    /*
     * ITEM
     */
    // 【ITEM】返回-添加-视图
    public function view_item_item_create($post_data)
    {
        $me = Auth::user();
//        if(!in_array($me->user_type,[0,1,9])) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');

        $operate_category = 'item';
        $operate_type = 'item';
        $operate_type_text = '内容';
        $title_text = '添加'.$operate_type_text;
        $list_text = $operate_type_text.'列表';
        $list_link = '/item/item-list';

        $return['operate'] = 'create';
        $return['operate_id'] = 0;
        $return['operate_category'] = $operate_category;
        $return['operate_type'] = $operate_type;
        $return['operate_type_text'] = $operate_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.item.item-edit';
        return view($view_blade)->with($return);
    }
    // 【ITEM】返回-编辑-视图
    public function view_item_item_edit($post_data)
    {
        $me = Auth::user();
        if(!in_array($me->user_type,[0,1])) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');

        $id = $post_data["item-id"];
        $mine = $this->modelItem->with(['owner'])->find($id);
        if(!$mine) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');


        $operate_category = 'item';

        if($mine->item_type == 0)
        {
            $operate_type = 'item';
            $operate_type_text = '内容';
            $list_link = '/home/item/item-list-for-all';
        }
        else if($mine->item_type == 1)
        {
            $operate_type = 'article';
            $operate_type_text = '文章';
            $list_link = '/home/item/item-article-list';
        }
        else if($mine->item_type == 9)
        {
            $operate_type = 'activity';
            $operate_type_text = '活动';
            $list_link = '/home/item/item-list-for-activity';
        }
        else if($mine->item_type == 11)
        {
            $operate_type = 'menu_type';
            $operate_type_text = '书目';
            $list_link = '/home/item/item-list-for-menu_type';
        }
        else if($mine->item_type == 18)
        {
            $operate_type = 'time_line';
            $operate_type_text = '时间线';
            $list_link = '/home/item/item-list-for-time_line';
        }
        else if($mine->item_type == 88)
        {
            $operate_type = 'advertising';
            $operate_type_text = '广告';
            $list_link = '/home/item/item-list-for-advertising';
        }
        else
        {
            $operate_type = 'item';
            $operate_type_text = '内容';
            $list_link = '/admin/item/item-list';
        }

        $title_text = '编辑'.$operate_type_text;
        $list_text = $operate_type_text.'列表';


        $return['operate_id'] = $id;
        $return['operate_category'] = $operate_category;
        $return['operate_type'] = $operate_type;
        $return['operate_type_text'] = $operate_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.item.item-edit';
        if($id == 0)
        {
            $return['operate'] = 'create';
            return view($view_blade)->with($return);
        }
        else
        {
            $mine = $this->modelItem->with(['owner'])->find($id);
            if($mine)
            {
                $mine->custom = json_decode($mine->custom);
                $mine->custom2 = json_decode($mine->custom2);
                $mine->custom3 = json_decode($mine->custom3);

                $return['operate'] = 'edit';
                $return['data'] = $mine;
                return view($view_blade)->with($return);
            }
            else return response("该内容不存在！", 404);
        }
    }
    // 【ITEM】保存-数据
    public function operate_item_item_save($post_data)
    {
//        dd('edit');
        $messages = [
            'operate.required' => 'operate.required',
            'title.required' => '请输入标题！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'title' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();
        if(!in_array($me->user_type,[0,1,9])) return response_error([],"用户类型错误！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];
        $operate_category = $post_data["operate_category"];
        $operate_type = $post_data["operate_type"];

        if($operate == 'create') // 添加 ( $id==0，添加一个内容 )
        {
            $mine = new Def_Item;
            $post_data["item_category"] = 1;
            $post_data["owner_id"] = $me->id;
            $post_data["creator_id"] = $me_admin->id;

//            if($type == 'item') $post_data["item_type"] = 0;
//            else if($type == 'article') $post_data["item_type"] = 1;
//            else if($type == 'activity') $post_data["item_type"] = 9;
//            else if($type == 'menu_type') $post_data["item_type"] = 11;
//            else if($type == 'time_line') $post_data["item_type"] = 18
//            else if($type == 'advertising') $post_data["item_type"] = 88;
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = $this->modelItem->find($operate_id);
            if(!$mine) return response_error([],"该内容不存在，刷新页面重试！");
            if($me->id != $me_admin->id)
            {
                if($mine->creator_id != $me_admin->id) return response_error([],"不是你创建的，你没有操作权限！");
            }
            $post_data["updater_id"] = $me_admin->id;
        }
        else return response_error([],"参数【operate】有误！");

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
            unset($mine_data['operate_category']);
            unset($mine_data['operate_type']);

            if(!empty($post_data['start'])) {
                $mine_data['time_type'] = 1;
                $mine_data['start_time'] = strtotime($post_data['start']);
            }

            if(!empty($post_data['end'])) {
                $mine_data['time_type'] = 1;
                $mine_data['end_time'] = strtotime($post_data['end']);
            }

            $bool = $mine->fill($mine_data)->save();
            if($bool)
            {

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    // 删除原封面图片
                    $mine_cover_pic = $mine->cover_pic;
                    if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                    {
                        unlink(storage_path("resource/" . $mine_cover_pic));
                    }

                    $result = upload_storage($post_data["cover"],'','doc/common');
                    if($result["result"])
                    {
                        $mine->cover_pic = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--cover_pic--fail");
                }

                // 附件
                if(!empty($post_data["attachment"]))
                {
                    // 删除原附件
                    $mine_cover_pic = $mine->attachment;
                    if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                    {
                        unlink(storage_path("resource/" . $mine_cover_pic));
                    }

                    $result = upload_file_storage($post_data["attachment"],'','doc/attachment');
                    if($result["result"])
                    {
                        $mine->attachment_name = $result["name"];
                        $mine->attachment_src = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--attachment_file--fail");
                }

                // 生成二维码
                $qr_code_path = "resource/doc/unique/qr_code/";  // 保存目录
                if(!file_exists(storage_path($qr_code_path)))
                    mkdir(storage_path($qr_code_path), 0777, true);
                // qr_code 图片文件
                $url = env('DOMAIN_DOC').'/item/'.$mine->id;  // 目标 URL
                $filename = 'qr_code_doc_item_'.$mine->id.'.png';  // 目标 file
                $qr_code = $qr_code_path.$filename;
                QrCode::errorCorrection('H')->format('png')->size(640)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qr_code));

            }
            else throw new Exception("insert--item--fail");

            DB::commit();
            return response_success(['id'=>$mine->id]);
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

    // 【ITEM】删除
    public function operate_item_item_delete_($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required',
            'id.required' => '请输入关键词ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-delete') return response_error([],"参数[operate]有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $mine = $this->modelItem->withTrashed()->find($id);
        if(!$mine) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::user();

        if($mine->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            if($id == $me->advertising_id)
            {
                $me->timestamps = false;
                $me->advertising_id = 0;
                $bool_0 = $me->save();
                if(!$bool_0) throw new Exception("update--user--fail");
            }

            $mine_cover_pic = $mine->cover_pic;
            $mine_attachment_src = $mine->attachment_src;
            $mine_content = $mine->content;


            $bool = $mine->delete();
            if(!$bool) throw new Exception("delete--item--fail");

            DB::commit();


            // 删除原封面图片
            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
            {
                unlink(storage_path("resource/" . $mine_cover_pic));
            }

            // 删除原附件
            if(!empty($mine_attachment_src) && file_exists(storage_path("resource/" . $mine_attachment_src)))
            {
                unlink(storage_path("resource/" . $mine_attachment_src));
            }

            // 删除二维码
            if(file_exists(storage_path("resource/doc/unique/qr_code/".'qr_code_doc_item_'.$id.'.png')))
            {
                unlink(storage_path("resource/doc/unique/qr_code/".'qr_code_doc_item_'.$id.'.png'));
            }

            // 删除UEditor图片
            $img_tags = get_html_img($mine_content);
            foreach ($img_tags[2] as $img)
            {
                if (!empty($img) && file_exists(public_path($img)))
                {
                    unlink(public_path($img));
                }
            }


            return response_success([]);
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


    // 【任务】获取详情
    public function operate_item_item_get($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
            'item_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'item_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-get') return response_error([],"参数[operate]有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $item = Def_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::user();
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        return response_success($item,"");

    }
    // 【任务】删除
    public function operate_item_item_delete($post_data)
    {
        $messages = [
            'operate.required' => '参数有误！',
            'item_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'item_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-delete') return response_error([],"参数[operate]有误！");
        $item_id = $post_data["item_id"];
        if(intval($item_id) !== 0 && !$item_id) return response_error([],"参数[ID]有误！");

        $item = Def_Item::withTrashed()->find($item_id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::user();
//        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");
//        if($me->user_type == 19 && ($item->item_active != 0 || $item->creator_id != $me->id)) return response_error([],"你没有操作权限！");
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->timestamps = false;
            if($item->item_active == 0 && $item->owner_id != $me->id)
            {
                $item_copy = $item;

                $bool = $item->forceDelete();
                if(!$bool) throw new Exception("item--delete--fail");
                DB::commit();

                $this->delete_the_item_files($item_copy);
            }
            else
            {
                $bool = $item->delete();
                if(!$bool) throw new Exception("item--delete--fail");
                DB::commit();
            }

            $item_html = $this->get_the_item_html($item);
            return response_success(['item_html'=>$item_html]);
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
    // 【任务】恢复
    public function operate_item_item_restore($post_data)
    {
        $messages = [
            'operate.required' => '参数有误！',
            'item_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'item_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-restore') return response_error([],"参数[operate]有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $item = Def_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::user();
//        if(!in_array($me->user_type,[0,1,9,11])) return response_error([],"用户类型错误！");
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->timestamps = false;
            $bool = $item->restore();
            if(!$bool) throw new Exception("item--restore--fail");
            DB::commit();

            $item_html = $this->get_the_item_html($item);
            return response_success(['item_html'=>$item_html]);
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
    // 【任务】彻底删除
    public function operate_item_item_delete_permanently($post_data)
    {
        $messages = [
            'operate.required' => '参数有误！',
            'item_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'item_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-delete-permanently') return response_error([],"参数[operate]有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $item = Def_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
//        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");
//        if($me->user_type == 19 && ($item->item_active != 0 || $item->creator_id != $me->id)) return response_error([],"你没有操作权限！");
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item_copy = $item;

            $bool = $item->forceDelete();
            if(!$bool) throw new Exception("item--delete--fail");
            DB::commit();

            $this->delete_the_item_files($item_copy);

            return response_success([]);
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
    // 【任务】发布
    public function operate_item_item_publish($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
            'item_id.required' => 'item_id.required.',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'item_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-publish') return response_error([],"参数[operate]有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $item = Def_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::user();
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->item_active = 1;
            $item->published_at = time();
            $bool = $item->save();
            if(!$bool) throw new Exception("item--update--fail");
            DB::commit();

            $item_html = $this->get_the_item_html($item);
            return response_success(['item_html'=>$item_html]);
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
    // 【任务】完成
    public function operate_item_item_complete($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
            'item_id.required' => 'item_id.required.',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'item_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'item-complete') return response_error([],"参数[operate]有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $item = DEF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
//        if(!in_array($me->user_type,[0,1,9,11,19,41])) return response_error([],"用户类型错误！");
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->is_completed = 1;
            $item->completer_id = $me->id;
            $item->completed_at = time();
            $item->timestamps = false;
            $bool = $item->save();
            if(!$bool) throw new Exception("item--update--fail");
            DB::commit();

            $item->custom = json_decode($item->custom);
            $item_array[0] = $item;
            $return['item_list'] = $item_array;
            $item_html = view(env('TEMPLATE_STAFF_FRONT').'component.item-list')->with($return)->__toString();
            return response_success(['item_html'=>$item_html]);
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




    // 【内容】返回-内容-HTML
    public function get_the_item_html($item)
    {
        $item->custom = json_decode($item->custom);
        $item_array[0] = $item;
        $return['item_list'] = $item_array;

        // method A
        $item_html = view(env('TEMPLATE_COMMON_FRONT').'component.item-list')->with($return)->__toString();
        // method B
//        $item_html = view(env('TEMPLATE_STAFF_FRONT').'component.item-list')->with($return)->render();
        // method C
//        $view = view(env('TEMPLATE_STAFF_FRONT').'component.item-list')->with($return);
//        $item_html=response($view)->getContent();

        return $item_html;
    }

    // 【内容】删除-内容-附属文件
    public function delete_the_item_files($item)
    {
        $mine_id = $item->id;
        $mine_cover_pic = $item->cover_pic;
        $mine_attachment_src = $item->attachment_src;
        $mine_content = $item->content;

        // 删除二维码
        if(file_exists(storage_path("resource/unique/qr_code/".'qr_code_item_'.$mine_id.'.png')))
        {
            unlink(storage_path("resource/unique/qr_code/".'qr_code_item_'.$mine_id.'.png'));
        }

        // 删除原封面图片
        if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
        {
            unlink(storage_path("resource/" . $mine_cover_pic));
        }

        // 删除原附件
        if(!empty($mine_attachment_src) && file_exists(storage_path("resource/" . $mine_attachment_src)))
        {
            unlink(storage_path("resource/" . $mine_attachment_src));
        }

        // 删除UEditor图片
        $img_tags = get_html_img($mine_content);
        foreach ($img_tags[2] as $img)
        {
            if(!empty($img) && file_exists(public_path($img)))
            {
                unlink(public_path($img));
            }
        }
    }





    /*
     *
     */
    public function view_item_content_management($post_data)
    {
        $item_id = $post_data['item-id'];
        if(!$item_id) return view('home.404')->with(['error'=>'参数有误']);

        $mine = $this->modelItem->find($item_id);
        if($mine)
        {
            if($mine->item_type == 11)
            {
                $item = $this->modelItem->with([
                    'contents'=>function($query) { $query->orderBy('rank','asc'); }
                ])->find($item_id);
                $item->contents_recursion = $this->get_recursion($item->contents,0);
                return view(env('TEMPLATE_ROOT_FRONT').'entrance.item.item-edit-for-menu_type')->with(['data'=>$item]);
            }
            else if($mine->item_type == 18)
            {
                $item = $this->modelItem->with([
                    'contents'=>function($query) {
                        $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                        $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                        $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                        $query->orderBy('time_point','asc');
                    }
                ])->find($item_id);
                return view(env('TEMPLATE_ROOT_FRONT').'entrance.item.item-edit-for-time_line')->with(['data'=>$item]);
            }
        }
        else return view(env('TEMPLATE_ROOT_FRONT').'errors.404');
    }

    // 【目录类型】返回列表数据
    public function view_item_content_menu_type($post_data)
    {
        $item_id = $post_data['id'];
        if(!$item_id) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = $this->modelItem->with([
            'contents'=>function($query) { $query->orderBy('rank','asc'); }
        ])->find($item_id);
        if($item)
        {
            $item->encode_id = encode($item->id);
//            unset($item->id);

//            $contents = $course->contents->toArray();

//            $contents_tree_array = $this->get_tree_array($contents,0);
//            $course->contents_tree_array = collect($contents_tree_array);

//            $contents_recursion_array = $this->get_recursion_array($contents,0);
//            $course->contents_recursion_array = collect($contents_recursion_array);

            $item->contents_recursion = $this->get_recursion($item->contents,0);

            return view('home.item.item-edit-for-menu_type')->with(['data'=>$item]);
        }
        else return view('home.404')->with(['error'=>'该内容不存在']);

    }
    // 【时间线】返回列表数据
    public function view_item_content_time_line($post_data)
    {
        $item_id = $post_data['id'];
        if(!$item_id) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = $this->modelItem->with([
            'contents'=>function($query) {
                $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                $query->orderBy('time_point','asc');
            }
        ])->find($item_id);
        if($item)
        {
            return view('home.item.item-edit-for-time_line')->with(['data'=>$item]);
        }
        else return view('home.404')->with(['error'=>'该内容不存在']);

    }


    // 保存【目录类型】
    public function operate_item_content_save_for_menu_type($post_data)
    {
        $messages = [
            'content_id.required' => 'content_id.required',
            'title.required' => '请输入标题！',
            'p_id.required' => '请选择目录！',
        ];
        $v = Validator::make($post_data, [
            'content_id' => 'required',
            'title' => 'required',
            'p_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();

//        $post_data["category"] = 11;
        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error();
        $item = $this->modelItem->find($item_id);
        if($item)
        {
            if($item->owner_id == $me->id)
            {

                $content_id = $post_data["content_id"];
                if(intval($content_id) !== 0 && !$content_id) return response_error();

                DB::beginTransaction();
                try
                {
                    $post_data["item_id"] = $item_id;
                    $operate = $post_data["operate"];
                    if($operate == 'create') // $id==0，添加一个新的内容
                    {
                        $content = new Def_Item;
                        $post_data["item_category"] = 1;
                        $post_data["item_type"] = 11;
                        $post_data["owner_id"] = $me->id;
                        $post_data["creator_id"] = $me_admin->id;
                    }
                    else if('edit') // 编辑
                    {
                        if($content_id == $post_data["p_id"]) return response_error([],"不能选择自己为父节点！");

                        $content = $this->modelItem->find($content_id);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试！");
                        if($content->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");
                        if($me->id != $me_admin->id)
                        {
                            if($content->creator_id != $me_admin->id) return response_error([],"该内容不是你创建的，你不能操作！");
                        }
                        $post_data["updater_id"] = $me_admin->id;
//                        if($content->type == 1) unset($post_data["type"]);

                        if($post_data["p_id"] != 0)
                        {
                            $is_child = true;
                            $p_id = $post_data["p_id"];
                            while($is_child)
                            {
                                $p = $this->modelItem->find($p_id);
                                if(!$p) return response_error([],"参数有误，刷新页面重试");
                                if($p->p_id == 0) $is_child = false;
                                if($p->p_id == $content_id)
                                {
                                    $content_children = $this->modelItem->where('p_id',$content_id)->get();
                                    $children_count = count($content_children);
                                    if($children_count)
                                    {
                                        $num = $this->modelItem->where('p_id',$content_id)->update(['p_id'=>$content->p_id]);
                                        if($num != $children_count)  throw new Exception("update--children--fail");
                                    }
                                }
                                $p_id = $p->p_id;
                            }
                        }

                        if($content_id == $item_id)
                        {
                            unset($post_data['item_id']);
                            unset($post_data['rank']);
                        }

                    }
                    else throw new Exception("operate--error");


                    if($post_data["p_id"] != 0)
                    {
                        $parent = $this->modelItem->find($post_data["p_id"]);
                        if(!$parent) return response_error([],"父节点不存在，刷新页面重试");
                    }

                    $bool = $content->fill($post_data)->save();
                    if($bool)
                    {
                        // 封面图片
                        if(!empty($post_data["cover"]))
                        {
                            // 删除原封面图片
                            $mine_cover_pic = $content->cover_pic;
                            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                            {
                                unlink(storage_path("resource/" . $mine_cover_pic));
                            }

                            $result = upload_img_storage($post_data["cover"],'','doc/common');
                            if($result["result"])
                            {
                                $content->cover_pic = $result["local"];
                                $content->save();
                            }
                            else throw new Exception("upload--cover_pic--fail");
                        }

                        // 生成二维码
                        $qr_code_path = "resource/doc/unique/qr_code/";  // 保存目录
                        if(!file_exists(storage_path($qr_code_path)))
                            mkdir(storage_path($qr_code_path), 0777, true);
                        // qr_code 图片文件
                        $url = env('DOMAIN_DOC').'/item/'.$content->id;  // 目标 URL
                        $filename = 'qr_code_doc_item_'.$content->id.'.png';  // 目标 file
                        $qr_code = $qr_code_path.$filename;
                        QrCode::errorCorrection('H')->format('png')->size(640)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qr_code));

                    }
                    else throw new Exception("insert--content--fail");


                    DB::commit();
                    return response_success(['id'=>$content->id]);
                }
                catch (Exception $e)
                {
                    DB::rollback();
                    $msg = '操作失败，请重试！';
                    $msg = $e->getMessage();
//                    exit($e->getMessage());
                    return response_fail([], $msg);
                }

            }
            else response_error([],"该内容不是你的，你不能操作！");

        }
        else return response_error([],"该内容不存在");
    }
    // 保存【时间点】
    public function operate_item_content_save_for_time_line($post_data)
    {
        $messages = [
            'content_id.required' => 'content_id.required',
            'title.required' => '请输入标题！',
            'time_point.required' => '请输入时间点！',
        ];
        $v = Validator::make($post_data, [
            'content_id' => 'required',
            'title' => 'required',
            'time_point' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();

//        $post_data["category"] = 18;
        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error();
        $item = $this->modelItem->find($item_id);
        if($item)
        {
            if($item->owner_id == $me->id)
            {

                $content_id = $post_data["content_id"];
                if(intval($content_id) !== 0 && !$content_id) return response_error();

                DB::beginTransaction();
                try
                {
                    $post_data["item_id"] = $item_id;
                    $operate = $post_data["operate"];
                    if($operate == 'create') // $id==0，添加一个新的内容
                    {
                        $content = new Def_Item;
                        $post_data["item_category"] = 1;
                        $post_data["item_type"] = 18;
                        $post_data["owner_id"] = $me->id;
                        $post_data["creator_id"] = $me_admin->id;
                    }
                    else if('edit') // 编辑
                    {
                        $content = $this->modelItem->find($content_id);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试！");
                        if($content->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");
                        if($me->id != $me_admin->id)
                        {
                            if($content->creator_id != $me_admin->id) return response_error([],"该内容不是你创建的，你不能操作！");
                        }
                        $post_data["updater_id"] = $me_admin->id;
//                        if($content->type == 1) unset($post_data["type"]);

                        if($content_id == $item_id)
                        {
                            unset($post_data['item_id']);
                            unset($post_data['time_point']);
                        }
                    }
                    else throw new Exception("operate--error");

                    $bool = $content->fill($post_data)->save();
                    if($bool)
                    {
                        // 封面图片
                        if(!empty($post_data["cover"]))
                        {
                            // 删除原封面图片
                            $mine_cover_pic = $content->cover_pic;
                            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                            {
                                unlink(storage_path("resource/" . $mine_cover_pic));
                            }

                            $result = upload_storage($post_data["cover"],'','doc/common');
                            if($result["result"])
                            {
                                $content->cover_pic = $result["local"];
                                $content->save();
                            }
                            else throw new Exception("upload--cover_pic--fail");
                        }

                        // 生成二维码
                        $qr_code_path = "resource/doc/unique/qr_code/";  // 保存目录
                        if(!file_exists(storage_path($qr_code_path)))
                            mkdir(storage_path($qr_code_path), 0777, true);
                        // qr_code 图片文件
                        $url = env('DOMAIN_DOC').'/item/'.$content->id;  // 目标 URL
                        $filename = 'qr_code_doc_item_'.$content->id.'.png';  // 目标 file
                        $qr_code = $qr_code_path.$filename;
                        QrCode::errorCorrection('H')->format('png')->size(640)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qr_code));

                    }
                    else throw new Exception("insert--content--fail");


                    DB::commit();
                    return response_success(['id'=>$content_id]);
                }
                catch (Exception $e)
                {
                    DB::rollback();
                    $msg = '操作失败，请重试！';
                    $msg = $e->getMessage();
//                    exit($e->getMessage());
                    return response_fail([], $msg);
                }

            }
            else response_error([],"该内容不是你的，您不能操作！");

        }
        else return response_error([],"该内容不存在");
    }


    // 内容获取
    public function operate_item_content_get($post_data)
    {
        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();

        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error([],"该内容不存在，刷新页面试试！");

        $content = $this->modelItem->find($item_id);
        if($content->owner_id != $me->id) return response_error([],"该内容不是你的，您不能操作！");
        else
        {
            if(!empty($content->cover_pic))
            {
                $cover_url = url(env('DOMAIN_CDN').'/'.$content->cover_pic);
                $content->cover_img = '<img src="'.$cover_url.'" alt="" />"';
            }
            else $content->cover_img = '';

            return response_success($content);
        }
    }
    // 删除
    public function operate_item_content_delete($post_data)
    {
        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();

        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(!$id) return response_error([],"该内容不存在，刷新页面试试");

        $content = $this->modelItem->find($id);
        if($content->owner_id != $me->id) return response_error([],"该内容不是你的，您不能操作！");
        if($me->id != $me_admin->id)
        {
            if($content->creator_id != $me_admin->id) return response_error([],"该内容不是你创建的，你不能操作！");
        }

        DB::beginTransaction();
        try
        {
            $content_children = $this->modelItem->where('p_id',$id)->get();
            $children_count = count($content_children);
            if($children_count)
            {
                $num = $this->modelItem->where('p_id',$id)->update(['p_id'=>$content->p_id]);
                if($num != $children_count)  throw new Exception("update--children--fail");
            }
            $bool = $content->delete();
            if(!$bool) throw new Exception("delete--content--fail");

            $mine_cover_pic = $content->cover_pic;
            $mine_attachment_src = $content->attachment_src;
            $mine_content = $content->content;

            DB::commit();


            // 删除原封面图片
            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
            {
                unlink(storage_path("resource/" . $mine_cover_pic));
            }

            // 删除原附件
            if(!empty($mine_attachment_src) && file_exists(storage_path("resource/" . $mine_attachment_src)))
            {
                unlink(storage_path("resource/" . $mine_attachment_src));
            }

            // 删除二维码
            if(file_exists(storage_path("resource/doc/unique/qr_code/".'qr_code_doc_item_'.$id.'.png')))
            {
                unlink(storage_path("resource/doc/unique/qr_code/".'qr_code_doc_item_'.$id.'.png'));
            }

            // 删除UEditor图片
            $img_tags = get_html_img($mine_content);
            foreach ($img_tags[2] as $img)
            {
                if (!empty($img) && file_exists(public_path($img)))
                {
                    unlink(public_path($img));
                }
            }

            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '删除失败，请重试';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }
    // 启用
    public function operate_item_content_enable($post_data)
    {
        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();

        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = $this->modelItem->find($id);
        if($mine->owner_id != $me->id) return response_error([],"该内容不是你的，您不能操作！");
        if($me->id != $me_admin->id)
        {
            if($mine->creator_id != $me_admin->id) return response_error([],"该内容不是你创建的，你不能操作！");
        }
        DB::beginTransaction();
        try
        {
            $update["item_active"] = 1;
            $mine->timestamps = false;
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'启用失败，请重试');
        }
    }
    // 禁用
    public function operate_item_content_disable($post_data)
    {
        $me = Auth::user();
        $me_admin = Auth::guard('doc_admin')->user();

        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $mine = $this->modelItem->find($id);
        if($mine->owner_id != $me->id) return response_error([],"该内容不是你的，您不能操作！");
        if($me->id != $me_admin->id)
        {
            if($mine->creator_id != $me_admin->id) return response_error([],"该内容不是你创建的，你不能操作！");
        }
        DB::beginTransaction();
        try
        {
            $update["item_active"] = 9;
            $mine->timestamps = false;
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            return response_fail([],'禁用失败，请重试');
        }
    }




    // 【ITEM】【添加】【点赞 | 收藏 | +待办事 | +日程】
    public function operate_item_add_this($post_data,$type=0)
    {
        if(Auth::check())
        {
            $messages = [
                'type.required' => '参数type有误！',
                'item_id.required' => '参数item_id有误！'
            ];
            $v = Validator::make($post_data, [
                'type' => 'required',
                'item_id' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $errors = $v->errors();
                return response_error([],$errors->first());
            }

            $item_id = $post_data['item_id'];
            $item = $this->modelItem->find($item_id);
            if($item)
            {
                $me = Auth::user();
                $pivot = Def_Pivot_User_Item::where(['type'=>1,'relation_type'=>$type,'user_id'=>$me->id,'item_id'=>$item_id])->first();
                if(!$pivot)
                {
                    DB::beginTransaction();
                    try
                    {
                        $time = time();
                        $me->pivot_item()->attach($item_id,['type'=>1,'relation_type'=>$type,'created_at'=>$time,'updated_at'=>$time]);
//

                        // 记录机制 Communication
                        if($type == 11)
                        {
                            // 点赞
                            $item->timestamps = false;
                            $item->increment('favor_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 11;
                        }
                        else if($type == 21)
                        {
                            // 添加收藏
                            $item->timestamps = false;
                            $item->increment('collection_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 21;
                        }
                        else if($type == 41)
                        {
                            // 添加待办
                            $item->timestamps = false;
                            $item->increment('working_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 41;
                        }
                        else if($type == 51)
                        {
                            // 添加日程
                            $item->timestamps = false;
                            $item->increment('agenda_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 51;
                        }

                        $communication_insert['user_id'] = $item->user_id;
                        $communication_insert['source_id'] = $me->id;
                        $communication_insert['item_id'] = $item_id;

                        $communication = new Def_Communication;
                        $bool = $communication->fill($communication_insert)->save();
                        if(!$bool) throw new Exception("insert--communication--fail");


                        // 通知机制 Communication
                        if($type == 11)
                        {
                            // 点赞
                            if($item->user_id != $me->id)
                            {
                                $notification_insert['type'] = 11;
                                $notification_insert['sort'] = 11;
                                $notification_insert['user_id'] = $item->user_id;
                                $notification_insert['source_id'] = $me->id;
                                $notification_insert['item_id'] = $item_id;

                                $notification_once = Def_Notification::where($notification_insert)->first();
                                if(!$notification_once)
                                {
                                    $notification = new Def_Notification;
                                    $bool = $notification->fill($notification_insert)->save();
                                    if(!$bool) throw new Exception("insert--notification--fail");
                                }
                            }
                        }

//                        $html['html'] = $this->view_item_html($item_id);

                        DB::commit();
                        return response_success([]);
                    }
                    catch (Exception $e)
                    {
                        DB::rollback();
                        $msg = '操作失败，请重试！';
                        $msg = $e->getMessage();
//                        exit($e->getMessage());
                        return response_fail([],$msg);
                    }
                }
                else
                {
                    if($type == 11) $msg = '成功点赞！';
                    else if($type == 21) $msg = '已经收藏过了了！';
                    else if($type == 41) $msg = '已经在待办事列表了！';
                    else if($type == 51) $msg = '已经在日程列表了！';
                    else $msg = '';
                    return response_fail(['reason'=>'exist'],$msg);
                }
            }
            else return response_fail([],'内容不存在！');

        }
        else return response_error([],'请先登录！');
    }
    // 【ITEM】【移除】【点赞 | 收藏 | +待办事 | +日程】
    public function operate_item_remove_this($post_data,$type=0)
    {
        if(Auth::check())
        {
            $messages = [
                'type.required' => '参数有误',
                'item_id.required' => '参数有误'
            ];
            $v = Validator::make($post_data, [
                'type' => 'required',
                'item_id' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $errors = $v->errors();
                return response_error([],$errors->first());
            }

            $item_id = $post_data['item_id'];
            $item = $this->modelItem->find($item_id);
            if($item)
            {
                $me = Auth::user();
                $pivots = Def_Pivot_User_Item::where(['type'=>1,'relation_type'=>$type,'user_id'=>$me->id,'item_id'=>$item_id])->get();
                if(count($pivots) > 0)
                {
                    DB::beginTransaction();
                    try
                    {
                        $num = Def_Pivot_User_Item::where(['type'=>1,'relation_type'=>$type,'user_id'=>$me->id,'item_id'=>$item_id])->delete();
                        if($num != count($pivots)) throw new Exception("delete--pivots--fail");

                        // 记录机制 Communication
                        if($type == 11)
                        {
                            // 移除点赞
                            $item->timestamps = false;
                            $item->decrement('favor_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 12;
                        }
                        else if($type == 21)
                        {
                            // 移除收藏
                            $item->timestamps = false;
                            $item->decrement('collection_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 22;
                        }
                        else if($type == 31)
                        {
                            // 移除待办
                            $item->timestamps = false;
                            $item->decrement('working_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 42;
                        }
                        else if($type == 32)
                        {
                            // 移除日程
                            $item->timestamps = false;
                            $item->decrement('agenda_num');
                            $communication_insert['communication_category'] = 11;
                            $communication_insert['communication_type'] = 52;
                        }

                        $communication_insert['user_id'] = $item->user_id;
                        $communication_insert['source_id'] = $me->id;
                        $communication_insert['item_id'] = $item_id;

                        $communication = new Def_Communication;
                        $bool = $communication->fill($communication_insert)->save();
                        if(!$bool) throw new Exception("insert--communication--fail");

//
//                        $html['html'] = $this->view_item_html($item_id);

                        DB::commit();
                        return response_success([]);
                    }
                    catch (Exception $e)
                    {
                        DB::rollback();
                        $msg = '操作失败，请重试！';
//                        $msg = $e->getMessage();
//                        exit($e->getMessage());
                        return response_fail([],$msg);
                    }
                }
                else
                {
                    if($type == 11) $msg = '';
                    else if($type == 21) $msg = '移除收藏成功！';
                    else if($type == 41) $msg = '移除待办事成功！';
                    else if($type == 51) $msg = '移除日程成功！';
                    else $msg = '';
                    return response_fail(['reason'=>'exist'],$msg);
                }
            }
            else return response_fail([],'内容不存在！');
        }
        else return response_error([],'请先登录！');

    }
    // 【ITEM】【转发】
    public function operate_item_forward($post_data)
    {
        if(Auth::check())
        {
            $messages = [
                'type.required' => '参数有误',
                'item_id.required' => '参数有误'
            ];
            $v = Validator::make($post_data, [
                'type' => 'required',
                'item_id' => 'required'
            ], $messages);
            if ($v->fails())
            {
                $errors = $v->errors();
                return response_error([],$errors->first());
            }

            $item_id = $post_data['item_id'];
            $item = $this->modelItem->find($item_id);
            if($item)
            {
                $me = Auth::user();
                $me_id = $me->id;

                DB::beginTransaction();
                try
                {
                    $mine = new Def_Item;
                    $post_data['user_id'] = $me_id;
                    $post_data['category'] = 99;
                    $post_data['is_shared'] = 100;
                    $bool = $mine->fill($post_data)->save();
                    if($bool)
                    {
                        $item->timestamps = false;
                        $item->increment('share_num');
                    }
                    else throw new Exception("insert--item--fail");

//                        $insert['type'] = 4;
//                        $insert['user_id'] = $user->id;
//                        $insert['item_id'] = $item_id;
//
//                        $communication = new Def_Communication;
//                        $bool = $communication->fill($insert)->save();
//                        if(!$bool) throw new Exception("insert--communication--fail");
//
//                        $html['html'] = $this->view_item_html($item_id);

                    DB::commit();
                    return response_success([]);
                }
                catch (Exception $e)
                {
                    DB::rollback();
                    $msg = '操作失败，请重试！';
//                        $msg = $e->getMessage();
//                        exit($e->getMessage());
                    return response_fail([],$msg);
                }
            }
            else return response_fail([],'内容不存在！');
        }
        else return response_error([],'请先登录！');

    }




    public function view_item($post_data,$id=0)
    {
        $user = [];
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;
            view()->share('me',$me);
        }
        else $user_id = 0;

        $id = request('id',0);
        if(intval($id) !== 0 && !$id) view('doc.frontend.errors.404');


        $item = $this->modelItem->with([
            'user',
            'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
        ])->find($id);
        if($item)
        {
            $item->timestamps = false;
            $item->increment('visit_num');

            if($item->item_type == 11)
            {
                if($item->item_id == 0)
                {
                    $parent_item = $item;
                    $parent_item->load([
                        'contents'=>function($query) { $query->where('active',1)->orderBy('rank','asc'); }
                    ]);
                }
                else $parent_item = $this->modelItem->with([
                    'contents'=>function($query) { $query->where('active',1)->orderBy('rank','asc'); }
                ])->find($item->item_id);

                $contents_recursion = $this->get_recursion($parent_item->contents,0);
                foreach ($contents_recursion as $v)
                {
                    $v->content_show = strip_tags($v->content);
                    $v->img_tags = get_html_img($v->content);
                }
                view()->share(['contents_recursion'=>$contents_recursion]);

                $parent_item->visit_total = $parent_item->visit_num + $parent_item->contents->sum('visit_num');
                $parent_item->comments_total = $parent_item->comment_num + $parent_item->contents->sum('comment_num');
                view()->share(['parent_item'=>$parent_item]);
            }
            else if($item->item_type == 18)
            {
                if($item->item_id == 0)
                {
                    $parent_item = $item;
                    $parent_item->load([
                        'contents'=>function($query) {
                            $query->where('active',1);
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                            $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                            $query->orderBy('time_point','asc');
                        }
                    ]);
                }
                else
                {
                    $parent_item = $this->modelItem->with([
                        'contents'=>function($query) {
                            $query->where('active',1);
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                            $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                            $query->orderBy('time_point','asc');
                        }
                    ])->find($item->item_id);
                }

                $time_points = $parent_item->contents;
                foreach ($time_points as $v)
                {
                    $v->content_show = strip_tags($v->content);
                    $v->img_tags = get_html_img($v->content);
                }
                view()->share(['time_points'=>$time_points]);

                $parent_item->visit_total = $parent_item->visit_num + $parent_item->contents->sum('visit_num');
                $parent_item->comments_total = $parent_item->comment_num + $parent_item->contents->sum('comment_num');
                view()->share(['parent_item'=>$parent_item]);
            }

            $item->custom_decode = json_decode($item->custom);

        }
        else return view('doc.frontend.errors.404');


        $head_title_prefix = '';
        $head_title_text = $item->title;
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return['item'] = $item;
        $return['user'] = $user;
        return view('doc.frontend.entrance.item.item')->with($return);
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



    // 返回（后台）主页视图
    public function view_item_list_for_mine($post_data)
    {
        $me = Auth::user();
        $item_query = $this->modelItem->select('*')->withTrashed()
            ->with(['owner','creator','pivot_item_relation'])
            ->where('owner_id',$me->id)
            ->where(['item_category'=>1]);


        $type = !empty($post_data['type']) ? $post_data['type'] : 'root';
        if($type == 'root')
        {
            $head_title_text = "我的轻博";
            $sidebar_active = 'sidebar_menu_for_mine_active';
            $page["module"] = 1;
        }
        else if($type == 'object')
        {
            $item_query->where('item_type',1);

            $head_title_text = "物";
            $sidebar_active = 'sidebar_menu_for_object_active';
            $page["module"] = 9;
        }
        else if($type == 'people')
        {
            $item_query->where('item_type',11);

            $head_title_text = "人";
            $sidebar_active = 'sidebar_menu_for_people_active';
            $page["module"] = 11;
        }
        else if($type == 'product')
        {
            $item_query->where('item_type',22);

            $head_title_text = "作品";
            $sidebar_active = 'sidebar_menu_for_product_active';
            $page["module"] = 11;
        }
        else if($type == 'event')
        {
            $item_query->where('item_type',33);

            $head_title_text = "事件";
            $sidebar_active = 'sidebar_menu_for_event_active';
            $page["module"] = 11;
        }
        else if($type == 'conception')
        {
            $item_query->where('item_type',91);

            $head_title_text = "概念";
            $sidebar_active = 'sidebar_menu_for_conception_active';
            $page["module"] = 11;
        }
        else
        {
            $head_title_text = "首页";
            $sidebar_active = 'sidebar_menu_for_root_active';
            $page["module"] = 1;
        }

        $item_list = $item_query->orderByDesc('updated_at')->paginate(20);
        foreach ($item_list as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);

            if(@getimagesize(env('DOMAIN_CDN').'/'.$item->cover_pic))
            {
                $item->cover_picture = env('DOMAIN_CDN').'/'.$item->cover_pic;
            }
            else
            {
                if(!empty($item->img_tags[0])) $item->cover_picture = $item->img_tags[2][0];
            }
//            dd($item->cover_picture);
        }

        $head_title_prefix = '【轻博】';
        $head_title_prefix = '';
        $head_title_text = '我的轻博';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return['menu_active_for_item_mine'] = 'active';
        $return['item_list'] = $item_list;

        $view = env('TEMPLATE_ROOT_FRONT').'entrance.root';
        return view($view)->with($return);
    }

    // 【我的原创】
    public function view_item_list_for_my_original($post_data)
    {
        if(Auth::check())
        {
            $me = Auth::user();
            $me_id = $me->id;

            $items = $this->modelItem->select("*")->with([
                'user',
                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])->where(['user_id'=>$me_id])->where('category','<>',99)->orderBy("updated_at", "desc")->paginate(20);
//            ])->where(['user_id'=>$me_id,'item_id'=>0])->where('category','<>',99)->orderBy("updated_at", "desc")->paginate(20);
        }
        else $items = [];

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-original')->with(['items'=>$items,'root_mine_active'=>'active']);
    }

    // 【待办事】
    public function view_item_list_for_my_todo_list($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id) { $query->with([
                    'user',
                    'forward_item'=>function($query) { $query->with('user'); },
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('type',31)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $items = $query->pivot_item;

//            // Method 2
//            $query = Pivot_User_Item::with([
//                    'item'=>function($query) { $query->with(['user']); }
//                ])->where(['type'=>11,'user_id'=>$user_id])->orderby('id','desc')->get();
//            dd($query->toArray());
        }
        else $items = [];

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-todolist')->with(['items'=>$items,'root_todolist_active'=>'active']);
    }
    // 【日程】
    public function view_item_list_for_my_schedule($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
//            $query = User::with([
//                'pivot_item'=>function($query) use($user_id) { $query->with([
//                    'user',
//                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
//                ])->wherePivot('type',12)->orderby('pivot_user_item.id','desc'); }
//            ])->find($user_id);
//            $items = $query->pivot_item;

            $items = [];
        }
        else $items = [];

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-schedule')->with(['items'=>$items,'root_schedule_active'=>'active']);
    }


    // 【点赞】
    public function view_item_list_for_my_favor($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id) { $query->with([
                    'user',
                    'forward_item'=>function($query) { $query->with('user'); },
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('relation_type',11)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $item_list = $query->pivot_item;
        }
        else $item_list = [];

        foreach ($item_list as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        $head_title_text = "我的点赞";
        $head_title_prefix = '【轻博】';
        $head_title_prefix = '';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return['menu_active_for_item_my_favor'] = 'active';
        $return['item_list'] = $item_list;

        $view = env('TEMPLATE_ROOT_FRONT').'entrance.my-favor';
        return view($view)->with($return);
    }
    // 【收藏】
    public function view_item_list_for_my_collection($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($user_id) { $query->with([
                    'user',
                    'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
                ])->wherePivot('relation_type',21)->orderby('pivot_user_item.id','desc'); }
            ])->find($user_id);
            $item_list = $query->pivot_item;
        }
        else $item_list = [];

        foreach ($item_list as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        $head_title_text = "我的收藏";
        $head_title_prefix = '【轻博】';
        $head_title_prefix = '';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return['menu_active_for_item_my_collection'] = 'active';
        $return['item_list'] = $item_list;
        $view = env('TEMPLATE_ROOT_FRONT').'entrance.my-collection';
        return view($view)->with($return);
    }


    // 【发现】
    public function view_item_list_for_my_discovery($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;

        $items = $this->modelItem->with([
            'user',
            'forward_item'=>function($query) { $query->with('user'); },
            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-discovery')->with(['items'=>$items,'root_discovery_active'=>'active']);
    }
    // 【关注】
    public function view_item_list_for_my_follow($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;
//
//        $items = $this->modelItem->with([
//            'user',
//            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
//        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        $user = User::with([
            'relation_items'=>function($query) use($user_id) {$query->with([
                'user',
                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
            ])->where('pivot_user_relation.relation_type','<=', 50)->where('root_items.is_shared','>=', 41); }
        ])->find($user_id);

        $items = $user->relation_items;
        $items = $items->sortByDesc('id');
//        dd($items->toArray());

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-follow')->with(['items'=>$items,'root_follow_active'=>'active']);
    }
    // 【好友圈】
    public function view_item_list_for_my_circle($post_data)
    {
        if(Auth::check())
        {
            $user = Auth::user();
            $user_id = $user->id;
        }
        else $user_id = 0;
//
//        $items = $this->modelItem->with([
//            'user',
//            'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
//        ])->where('is_shared','>=',99)->orderBy('id','desc')->get();

        $user = User::with([
            'relation_items'=>function($query) use($user_id) { $query->with([
                'user',
                'forward_item'=>function($query) { $query->with('user'); },
                'pivot_item_relation'=>function($query) use($user_id) { $query->where('user_id',$user_id); }
            ])->where('pivot_user_relation.relation_type',21)->where('root_items.is_shared','>=', 41); }
        ])->find($user_id);

        $items = $user->relation_items;
        $items = $items->sortByDesc('id');
//        dd($items->toArray());

        foreach ($items as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        return view('frontend.entrance.root-circle')->with(['items'=>$items,'root_circle_active'=>'active']);
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









    // 登录我的轻博
    /*
     * DOC
     */
    // 【ITEM】返回-添加-视图
    public function view_my_doc_create($post_data)
    {
        $me = Auth::user();

        $operate_category = 'user';
        $operate_type = 'user.doc';
        $operate_type_text = '轻博';
        $title_text = '创建新'.$operate_type_text;
        $list_text = $operate_type_text.'列表';
        $list_link = '/my-doc-list';

        $return['operate'] = 'create';
        $return['operate_id'] = 0;
        $return['operate_category'] = $operate_category;
        $return['operate_type'] = $operate_type;
        $return['item_type_text'] = $operate_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;

        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.my-doc-edit';
        return view($view_blade)->with($return);
    }
    // 【ITEM】返回-编辑-视图
    public function view_my_doc_edit($post_data)
    {
        $me = Auth::user();
//        if(!in_array($me->user_type,[0,1])) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');

        $id = $post_data["user-id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");
        if($id == 0)
        {
            $return['operate'] = 'create';
        }
        else
        {
            $mine = User::with(['creator'])->find($id);
            if(!$mine) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');
            $return['operate'] = 'edit';
            $return['data'] = $mine;
        }

        $operate_category = 'user';
        $operate_type = 'user.doc';
        $operate_type_text = '轻博账号';
        $title_text = '编辑'.$operate_type_text;
        $list_text = $operate_type_text.'列表';
        $list_link = '/my-doc-list';

        $return['operate_id'] = $id;
        $return['operate_category'] = $operate_category;
        $return['operate_type'] = $operate_type;
        $return['operate_type_text'] = $operate_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;



        $view_blade = env('TEMPLATE_ROOT_FRONT').'entrance.my-doc-edit';
        return view($view_blade)->with($return);

    }
    // 【ITEM】保存-数据
    public function operate_my_doc_save($post_data)
    {
//        dd($post_data);
        $messages = [
            'operate.required' => 'operate.required.',
            'username.required' => '请输入用户名！',
//            'mobile.required' => '请输入电话',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'username' => 'required',
//            'mobile' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }


        $me = Auth::user();
        $me_id = $me->id;
        if(!in_array($me->user_category,[0,1])) return response_error([],"你没有操作权限！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];

        if($operate == 'create') // 添加 ( $id==0，添加一个新用户 )
        {
            $mine = new User;
            $post_data["creator_id"] = $me_id;
            $post_data["user_category"] = 9;
            $post_data["active"] = 1;
            $post_data["password"] = password_encode("12345678");
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = User::find($operate_id);
            if(!$mine) return response_error([],"该用户不存在，刷新页面重试！");
        }
        else return response_error([],"参数有误！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            if(!empty($post_data['custom']))
            {
                $post_data['custom'] = json_encode($post_data['custom']);
            }

            $mine_data = $post_data;
            $mine_data['district_id'] = !empty($post_data['select2_district_id']) ? $post_data['select2_district_id'] : 0;

            unset($mine_data['operate']);
            unset($mine_data['operate_id']);
            unset($mine_data['category']);
            unset($mine_data['type']);

            $bool = $mine->fill($mine_data)->save();
            if($bool)
            {
                // 头像
                if(!empty($post_data["portrait"]))
                {
                    // 删除原图片
                    $mine_portrait_img = $mine->portrait_img;
                    if(!empty($mine_portrait_img) && file_exists(storage_path("resource/" . $mine_portrait_img)))
                    {
                        unlink(storage_path("resource/" . $mine_portrait_img));
                    }

//                    $result = upload_storage($post_data["portrait"]);
//                    $result = upload_storage($post_data["portrait"], null, null, 'assign');
                    $result = upload_img_storage($post_data["portrait"],'user_'.$mine->id,'doc/unique/portrait/','assign');
                    if($result["result"])
                    {
                        $mine->portrait_img = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--portrait--fail");
                }
                else
                {
                    if($operate == 'create')
                    {
                        copy(storage_path("resource/unique/portrait/user0.jpeg"), storage_path("resource/doc/unique/portrait/user_".$mine->id.".jpeg"));
                        $mine->portrait_img = "doc/unique/portrait/user_".$mine->id.".jpeg";
                        $mine->save();
                    }
                }

            }
            else throw new Exception("insert--user--fail");

            DB::commit();
            return response_success(['id'=>$mine->id]);
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

    // 登录我的轻博
    public function operate_my_doc_login($post_data)
    {
        $id = $post_data["user-id"];
        if(!is_numeric($id)) return response_error([],"参数ID有误！");
//        if(intval($id) !== 0 && !$id) dd("参数ID有误！");

        $me = Auth::user();
        $mine = User::with(['creator'])->find($id);
        if(!$mine) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');
        if($mine->creator_id != $me->id) return view(env('TEMPLATE_ROOT_FRONT').'errors.404');

        Auth::guard('doc')->login($mine,true);
        Auth::guard('doc_admin')->login($me,true);

        if(request()->isMethod('get')) return redirect(env('DOMAIN_DOC'));
        else if(request()->isMethod('post')) return response_success();
    }

    // 登录我的轻博
    public function operate_login_my_doc($post_data)
    {
        $me = Auth::user();

        Auth::guard('doc')->login($me,true);
        Auth::guard('doc_admin')->login($me,true);

        if(request()->isMethod('get')) return redirect(env('DOMAIN_DOC'));
        else if(request()->isMethod('post')) return response_success();
    }








    // 记录访问
    public function record($post_data)
    {
        $record = new Def_Record();

        $browseInfo = getBrowserInfo();
        $type = $browseInfo['type'];
        if($type == "Mobile") $post_data["open_device_type"] = 1;
        else if($type == "PC") $post_data["open_device_type"] = 2;

        $post_data["referer"] = $browseInfo['referer'];
        $post_data["open_system"] = $browseInfo['system'];
        $post_data["open_browser"] = $browseInfo['browser'];
        $post_data["open_app"] = $browseInfo['app'];

        $post_data["ip"] = Get_IP();
        $bool = $record->fill($post_data)->save();
        if($bool) return true;
        else return false;
    }

    // 顺序排列
    function get_recursion($result, $parent_id=0, $level=0)
    {
        /*记录排序后的类别数组*/
        static $list = array();

        foreach ($result as $k => $v)
        {
            if($v->p_id == $parent_id)
            {
                $v->level = $level;

                foreach($list as $key=>$val)
                {
                    if($val->id == $parent_id) $list[$key]->has_child = 1;
                }

                /*将该类别的数据放入list中*/
                $list[] = $v;

                $this->get_recursion($result, $v->id, $level+1);
            }
        }

        return $list;
    }


}