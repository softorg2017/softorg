<?php
namespace App\Repositories\Root\Front;

use App\User;
use App\UserExt;

use App\Models\Def\Def_Item;
use App\Models\Def\Def_Pivot_User_Relation;
use App\Models\Def\Def_Notification;
use App\Models\Def\Def_Record;

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
    private $service;
    public function __construct()
    {
//        $this->model = new User;
    }


    // 返回【平台首页】视图
    public function view_root()
    {
        if(auth()->check())
        {
            return redirect(env('DOMAIN_WWW').'/user/'.auth()->id());
        }

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


        $sidebar_active  = 'menu';
        $return[$sidebar_active] = 'active';
        $return['head_title'] = $head_title;
        $return['getType'] = 'items';
        $return['page_type'] = 'root';
        $return['page'] = $page;




        $view = env('TEMPLATE_ROOT_FRONT').'entrance.root';
        return view($view)->with($return);




//        $info = json_decode(json_encode(config('mitong.company.info')));
//        $menus = RootMenu::where(['active'=>1])->orderby('order', 'asc')->get();

//        $service_items = Def_Item::where(['category'=>11, 'active'=>1])->orderby('id', 'desc')->limit(8)->get();
//        foreach($service_items as $item)
//        {
//            $item->custom = json_decode($item->custom);
//            $item->custom2 = json_decode($item->custom2);
//        }
//
//
//        $template_menu = RootMenu::where(['name'=>'template'])->first();
//        if($template_menu)
//        {
//            $template_items = RootItem::where(['menu_id'=>$template_menu->id, 'active'=>1])->orderby('id', 'desc')->limit(8)->get();
//            foreach($template_items as $item)
//            {
//                $item->custom = json_decode($item->custom);
//            }
//        }
//        else $template_items = [];
//
//        $client_items = RootItem::where(['category'=>51, 'active'=>1])->orderby('id', 'desc')->get();
//        $coverage_items = RootItem::where(['category'=>41, 'active'=>1])->orderby('id', 'desc')->get();

//        $html = view('root.frontend.entrance.root')->with([
////                'service_items'=>$service_items,
////                'template_items'=>$template_items,
////                'client_items'=>$client_items,
////                'coverage_items'=>$coverage_items
//            ])->__toString();
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
            if($user->user_category != 1)
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




    // 【我的】【关注】
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

        return view(env('TEMPLATE_ROOT_FRONT').'entrance.my-follow')
            ->with([
                'user_list'=>$user_list,
                'sidebar_menu_my_follow_active'=>'active'
            ]);
    }
    // 【我的】【粉丝】
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




    // 登录我的轻博
    public function operate_login_my_doc($post_data)
    {
        $me = Auth::user();

        Auth::guard('doc')->login($me,true);
        Auth::guard('doc_admin')->login($me,true);

        if(request()->isMethod('get')) return redirect(env('DOMAIN_DOC').'/home');
        else if(request()->isMethod('post')) return response_success();
    }




}