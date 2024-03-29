<?php
namespace App\Repositories\LW\Doc\Front;

use App\User;
use App\Models\Def\Def_Item;
use App\Models\Def\Def_Pivot_User_Item;
use App\Models\Def\Def_Pivot_User_Relation;
use App\Models\Def\Def_Pivot_Item_Relation;
use App\Models\Def\Def_Communication;
use App\Models\Def\Def_Notification;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Blade;
use QrCode, Excel;

class DocIndexRepository {

    private $evn;
    private $auth_check;
    private $me;
    private $me_admin;
    private $model;
    private $modelUser;
    private $modelItem;
    private $repo;
    private $view_blade_404;
    public function __construct()
    {
        $this->modelItem = new Def_Item;
        $this->view_template_front = env('LW_TEMPLATE_DOC_FRONT');

        $this->view_blade_404 = env('TEMPLATE_ROOT_FRONT').'errors.404';

        Blade::setEchoFormat('%s');
        Blade::setEchoFormat('e(%s)');
        Blade::setEchoFormat('nl2br(e(%s))');
    }


    public function get_me()
    {
        if(Auth::guard("doc")->check())
        {
            $this->auth_check = 1;
            $this->me = Auth::guard("doc")->user();
            $this->me_admin = Auth::guard("doc_admin")->user();
            view()->share('me',$this->me);

            if(Auth::guard("doc_admin")->check())
            {
                $this->me_admin = Auth::guard("doc_admin")->user();
            }
            else
            {
                $this->me_admin = $this->me;
            }
        }
        else $this->auth_check = 0;

        view()->share('auth_check',$this->auth_check);
    }


    // 返回（后台）主页视图
    public function view_root($post_data)
    {
        $this->get_me();

        if($this->auth_check)
        {
            $me = $this->me;
            $me_id = $me->id;
        }
        else
        {
            $me = [];
            $me_id = 0;
        }

        $item_query = $this->modelItem->select('*')->withTrashed()
            ->with([
                'owner',
                'creator',
                'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
            ])
            ->where('owner_id','>',0)
            ->where(['is_published'=>1,'item_category'=>1]);

        $menu_active = 'sidebar_menu_root_active';


        $condition = request()->all();

        $type = !empty($post_data['type']) ? $post_data['type'] : 'root';
        if($type == 'root')
        {
            $head_title_text = "首页";
            $sidebar_active = 'sidebar_menu_for_root_active';
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

        $item_list = $item_query->orderByDesc('published_at')->orderByDesc('id')->paginate(20);
        foreach ($item_list as $item)
        {
            $item->custom = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);

            if(@getimagesize(env('LW_DOMAIN_CDN').'/'.$item->cover_pic))
            {
                $item->cover_picture = env('LW_DOMAIN_CDN').'/'.$item->cover_pic;
            }
            else
            {
                if(!empty($item->img_tags[0])) $item->cover_picture = $item->img_tags[2][0];
            }
//            dd($item->cover_picture);
        }

        $return['condition'] = $condition;
        $head_title_prefix = '';
        $head_title_prefix = '';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return[$sidebar_active] = 'active';
        $return[$menu_active] = 'active';
        $return['item_list'] = $item_list;

        $view = env('LW_TEMPLATE_DOC_FRONT').'entrance.root';
        return view($view)->with($return);
    }




    // 【内容详情】
    public function view_item($post_data,$id=0)
    {
        $this->get_me();

        if($this->auth_check)
        {
            $me = $this->me;
            $me_id = $me->id;
        }
        else
        {
            $me = [];
            $me_id = 0;
        }

        $id = request('id',0);
        if(intval($id) !== 0 && !$id) view($this->view_blade_404);


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
                        'contents'=>function($query) use($me_id) {
                            $query->where(['is_published'=>1,'item_active'=>1])
                                ->orWhere('owner_id', $me_id)
                                ->orWhere('creator_id', $me_id)
                                ->orderBy('rank','asc');
                        }
                    ]);
                }
                else $parent_item = $this->modelItem->with([
                    'contents'=>function($query) use($me_id) {
                        $query->where(['is_published'=>1,'item_active'=>1])
                            ->orWhere('owner_id', $me_id)
                            ->orWhere('creator_id', $me_id)
                            ->orderBy('rank','asc');
                }
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
                        'contents'=>function($query) use($me_id) {
                            $query->where(['is_published'=>1,'item_active'=>1])
                                ->orWhere('owner_id', $me_id)
                                ->orWhere('creator_id', $me_id);
//                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
//                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
//                            $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
//                            $query->orderBy('time_point','asc');
                            $query->orderBy('rank','asc');
                            $query->orderBy('id','asc');
                        }
                    ]);
                }
                else
                {
                    $parent_item = $this->modelItem->with([
                        'contents'=>function($query) use($me_id) {
                            $query->where(['is_published'=>1,'item_active'=>1])
                                ->orWhere('owner_id', $me_id)
                                ->orWhere('creator_id', $me_id);
//                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
//                            $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
//                            $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
//                            $query->orderBy('time_point','asc');
                            $query->orderBy('rank','asc');
                            $query->orderBy('id','asc');
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
        else return view($this->view_blade_404);


        $head_title_prefix = '';
        $head_title_prefix = '';
        $head_title_text = $item->title;
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return['item'] = $item;
        $return['user'] = $me;

        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.item.item';
        return view($view_blade)->with($return);
    }




    /*
     * 用户基本信息
     */
    // 【基本信息】返回视图
    public function view_my_info_index()
    {
        $this->get_me();
        $me = $this->me;
        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.my-info-index';
        return view($view_blade)->with(['info'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_my_info_edit()
    {
        $this->get_me();
        $me = $this->me;
        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.my-info-edit';
        return view($view_blade)->with(['info'=>$me]);
    }
    // 【基本信息】保存数据
    public function operate_my_info_save($post_data)
    {
        $this->get_me();
        $me = $this->me;

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
                    $mine_portrait_img = $me->portrait_img;
                    if(!empty($mine_portrait_img) && file_exists(storage_resource_path($mine_portrait_img)))
                    {
                        unlink(storage_resource_path($mine_portrait_img));
                    }

                    $result = upload_img_storage($post_data["portrait"],'portrait_for_user_by_user_'.$me->id,'www/unique/portrait_for_user','');
                    if($result["result"])
                    {
                        $me->portrait_img = $result["local"];
                        $me->save();
                    }
                    else throw new Exception("upload--portrait_img--file--fail");
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

    // 【密码】返回-修改-视图
    public function view_my_info_password_reset()
    {
        $this->get_me();
        $me = $this->me;
        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.my-info.my-info-password-reset';
        return view($view_blade)->with(['data'=>$me]);
    }
    // 【密码】保存数据
    public function operate_my_info_password_reset_save($post_data)
    {
        $messages = [
            'password_pre.required' => '请输入旧密码',
            'password_new.required' => '请输入新密码',
            'password_confirm.required' => '请输入确认密码',
        ];
        $v = Validator::make($post_data, [
            'password_pre' => 'required',
            'password_new' => 'required',
            'password_confirm' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $password_pre = request()->get('password_pre');
        $password_new = request()->get('password_new');
        $password_confirm = request()->get('password_confirm');

        if($password_new == $password_confirm)
        {
            $me = Auth::guard('staff')->user();
            if(password_check($password_pre,$me->password))
            {
                $me->password = password_encode($password_new);
                $bool = $me->save();
                if($bool) return response_success([], '密码修改成功！');
                else return response_fail([], '密码修改失败！');
            }
            else
            {
                return response_fail([], '原密码有误！');
            }
        }
        else return response_error([],'两次密码输入不一致！');
    }





    /*
     * ITEM
     */
    // 【ITEM】返回-添加-视图
    public function view_item_item_create($post_data)
    {
        $this->get_me();
        $me = $this->me;
        $me_admin = $this->me_admin;
//        if(!in_array($me->user_type,[0,1,9])) return view($this->view_blade_404);

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

        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.item.item-edit';
        return view($view_blade)->with($return);
    }
    // 【ITEM】返回-编辑-视图
    public function view_item_item_edit($post_data)
    {
        $this->get_me();
        $me = $this->me;
        $me_admin = $this->me_admin;
//        if(!in_array($me->user_type,[0,1])) return view($this->view_blade_404);

        $id = $post_data["item-id"];
        $mine = $this->modelItem->with(['owner'])->find($id);
        if(!$mine) return view($this->view_blade_404);


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

        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.item.item-edit';

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

        $me = Auth::guard('doc')->user();
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

                    $result = upload_img_storage($post_data["cover"],'','common');
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
                    if(!empty($mine_cover_pic) && file_exists(storage_resource_path($mine_cover_pic)))
                    {
                        unlink(storage_resource_path($mine_cover_pic));
                    }

                    $result = upload_file_storage($post_data["attachment"],'','attachment');
                    if($result["result"])
                    {
                        $mine->attachment_name = $result["name"];
                        $mine->attachment_src = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--attachment_file--fail");
                }

                // 生成二维码
                $date_today = date('Y-m-d');
                $qr_code_path = "www/unique/qr_code_for_item/".$date_today.'/';  // 保存目录
                if(!file_exists(storage_resource_path($qr_code_path)))
                {
                    mkdir(storage_resource_path($qr_code_path), 0777, true);
                }
                // qr_code 图片文件
                $url = env('DOMAIN_DOC').'/item/'.$mine->id;  // 目标 URL
                $filename = 'qr_code_for_item_by_item_'.$mine->id.'.png';  // 目标 file
                $qr_code_file = $qr_code_path.$filename;
                QrCode::errorCorrection('H')->format('png')->size(640)->margin(0)->encoding('UTF-8')->generate($url,storage_resource_path($qr_code_file));

                $mine->unique_path = $qr_code_path;
                $mine->save();

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




    // 【ITEM】获取详情
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

        $this->get_me();
        $me = $this->me;
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        return response_success($item,"");

    }
    // 【ITEM】删除
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

        $this->get_me();
        $me = $this->me;
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
    // 【ITEM】恢复
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

        $this->get_me();
        $me = $this->me;
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
    // 【ITEM】彻底删除
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

        $this->get_me();
        $me = $this->me;
//        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");
//        if($me->user_type == 19 && ($item->item_active != 0 || $item->creator_id != $me->id)) return response_error([],"你没有操作权限！");
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

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
    // 【ITEM】发布
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

        $this->get_me();
        $me = $this->me;
        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->is_published = 1;
            $item->published_at = time();
            $item->timestamps = false;
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
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }
    // 【ITEM】完成
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

        $this->get_me();
        $me = $this->me;
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
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }

    }





    /*
     *
     */
    // 【ITEM-Content】
    public function view_item_content_management($post_data)
    {
        $this->get_me();

        $item_id = $post_data['item-id'];
        if(!$item_id) return view($this->view_blade_404)->with(['error'=>'参数有误']);

        $mine = $this->modelItem->find($item_id);
        if($mine)
        {
            if($mine->owner_id != $this->me->id)
            {
                $error['text'] = '不是你的内容，你不能操作！';
                return view(env('LW_TEMPLATE_DOC_FRONT').'errors.404')->with(['error'=>$error]);
            }

            if($mine->item_type == 11)
            {
                $item = $this->modelItem->with([
                    'contents'=>function($query) {
                        $query->select('id','is_published','item_active','rank','item_id','p_id','title')
                            ->orderBy('rank','asc')->orderBy('id','asc');
                    }
                ])->find($item_id);
                $item->contents_recursion = $this->get_recursion($item->contents,0);
                $contents_recursion_menu = [];
                foreach($item->contents_recursion as  $key => $content)
                {
                    // 如果是第一个，可以向前移动
                    if($content->oldest)
                    {
                        $menu_before = [];
                        $spacing = '';
                        for ($i = 0; $i < $content->level; $i++)
                        {
//                            $spacing .= '·· &nbsp';
                            $spacing .= '·· ';
                        }
                        $menu_before["id"] = $content->id;
                        $menu_before["p_id"] = $content->p_id;
                        $menu_before["value"] = $content->id.'-before';
                        $menu_before["direction"] = 'before';
                        $menu_before["title"] = $spacing.$content->title.' 之前';

                        $contents_recursion_menu[] = $menu_before;
                    }

                    // 向后移动
                    $menu_after = [];
                    $spacing = '';
                    for ($i = 0; $i < $content->level; $i++)
                    {
                        $spacing .= '·· ';
                    }
                    $menu_after["id"] = $content->id;
                    $menu_after["p_id"] = $content->p_id;
                    $menu_after["value"] = $content->id.'-after';
                    $menu_after["direction"] = 'after';
                    $menu_after["title"] = $spacing.$content->title.' 之后';

                    $contents_recursion_menu[] = $menu_after;


                    // 插入子节点
//                    if(!$content->has_child)
//                    {
//                        $menu_append = [];
//                        $spacing = '';
//                        for ($i = 0; $i < $content->level; $i++)
//                        {
//                            $spacing .= '·· ';
//                        }
//                        $menu_append["id"] = $content->id;
//                        $menu_append["p_id"] = $content->p_id;
//                        $menu_append["value"] = $content->id.'-append';
//                        $menu_append["title"] = $spacing.$content->title.'(插入子节点)';
//
//                        $contents_recursion_menu[] = $menu_append;
//                    }
                }
                $item->contents_recursion_menu = $contents_recursion_menu;
//                dd($item->contents_recursion_menu);
                return view(env('LW_TEMPLATE_DOC_FRONT').'entrance.item.item-edit-for-menu_type')->with(['data'=>$item]);
            }
            else if($mine->item_type == 18)
            {
                $item = $this->modelItem->with([
                    'contents'=>function($query) {
//                        $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
//                        $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
//                        $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
//                        $query->orderBy('time_point','asc');
                        $query->orderBy('rank','asc');
                        $query->orderBy('id','asc');
                    }
                ])->find($item_id);
                return view(env('LW_TEMPLATE_DOC_FRONT').'entrance.item.item-edit-for-time_line')->with(['data'=>$item]);
            }
        }
        else return view($this->view_blade_404);
    }

    // 【ITEM-Content】【目录类型】返回列表数据
    public function view_item_content_menu_type($post_data)
    {
        $item_id = $post_data['id'];
        if(!$item_id) return view($this->view_blade_404)->with(['error'=>'参数有误']);
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
        else return view($this->view_blade_404)->with(['error'=>'该内容不存在']);

    }
    // 【ITEM-Content】【时间线】返回列表数据
    public function view_item_content_time_line($post_data)
    {
        $item_id = $post_data['id'];
        if(!$item_id) return view($this->view_blade_404)->with(['error'=>'参数有误']);
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
        else return view($this->view_blade_404)->with(['error'=>'该内容不存在']);

    }


    // 【ITEM-Content】【目录类型】保存
    public function operate_item_content_save_for_menu_type($post_data)
    {
        $messages = [
            'item_id.required' => 'item_id.required',
            'content_id.required' => 'content_id.required',
            'title.required' => '请输入标题！',
            'p_id.required' => '请选择目录！',
        ];
        $v = Validator::make($post_data, [
            'item_id' => 'required',
            'content_id' => 'required',
            'title' => 'required',
            'p_id' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $this->get_me();
        $me = Auth::guard('doc')->user();
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

                        $content_brother = $this->modelItem->where(['item_id'=>$post_data["item_id"],'p_id'=>$post_data["p_id"]])->orderBy('rank','desc')->first();
                        if($content_brother) $post_data["rank"] = $content_brother->rank + 1;
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
                            if(!empty($mine_cover_pic) && file_exists(storage_resource_path($mine_cover_pic)))
                            {
                                unlink(storage_resource_path($mine_cover_pic));
                            }

                            $result = upload_img_storage($post_data["cover"],'','common');
                            if($result["result"])
                            {
                                $content->cover_pic = $result["local"];
                                $content->save();
                            }
                            else throw new Exception("upload--cover_pic--fail");
                        }

                        // 生成二维码
                        $date_today = date('Y-m-d');
                        $qr_code_path = "www/unique/qr_code_for_item/".$date_today.'/';  // 保存目录
                        if(!file_exists(storage_resource_path($qr_code_path)))
                        {
                            mkdir(storage_resource_path($qr_code_path), 0777, true);
                        }
                        // qr_code 图片文件
                        $url = env('DOMAIN_DOC').'/item/'.$content->id;  // 目标 URL
                        $filename = 'qr_code_for_item_by_item_'.$content->id.'.png';  // 目标 file
                        $qr_code_file = $qr_code_path.$filename;
                        QrCode::errorCorrection('H')->format('png')->size(640)->margin(0)->encoding('UTF-8')->generate($url,storage_resource_path($qr_code_file));

                        $content->unique_path = $qr_code_path;
                        $content->save();

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
    // 【ITEM-Content】【时间点】保存
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

        $me = Auth::guard('doc')->user();
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

                        $content_brother = $this->modelItem->where(['item_id'=>$post_data["item_id"]])->orderBy('rank','desc')->first();
                        if($content_brother) $post_data["rank"] = $content_brother->rank + 1;
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
                            if(!empty($mine_cover_pic) && file_exists(storage_resource_path($mine_cover_pic)))
                            {
                                unlink(storage_resource_path($mine_cover_pic));
                            }

                            $result = upload_img_storage($post_data["cover"],'','common');
                            if($result["result"])
                            {
                                $content->cover_pic = $result["local"];
                                $content->save();
                            }
                            else throw new Exception("upload--cover_pic--fail");
                        }

                        // 生成二维码
                        $date_today = date('Y-m-d');
                        $qr_code_path = "www/unique/qr_code_for_item/".$date_today.'/';  // 保存目录
                        if(!file_exists(storage_resource_path($qr_code_path)))
                        {
                            mkdir(storage_resource_path($qr_code_path), 0777, true);
                        }
                        // qr_code 图片文件
                        $url = env('DOMAIN_DOC').'/item/'.$content->id;  // 目标 URL
                        $filename = 'qr_code_for_item_by_item_'.$content->id.'.png';  // 目标 file
                        $qr_code_file = $qr_code_path.$filename;
                        QrCode::errorCorrection('H')->format('png')->size(640)->margin(0)->encoding('UTF-8')->generate($url,storage_resource_path($qr_code_file));

                        $content->unique_path = $qr_code_path;
                        $content->save();

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


    // 【ITEM-Content】【目录类型】移动
    public function operate_item_content_move_menu_type($post_data)
    {
        $messages = [
            'content_id.required' => 'content_id.required.',
            'menu_id.required' => 'menu_id.required.',
            'position_id.required' => 'position_id.required.',
//            'position_direction.required' => 'position_direction.required.',
        ];
        $v = Validator::make($post_data, [
            'content_id' => 'required',
            'menu_id' => 'required',
            'position_id' => 'required',
//            'position_direction' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $this->get_me();
        $me = $this->me;
        $me_admin = $this->me_admin;

        $menu_id = $post_data["menu_id"];
        $position_id = $post_data["position_id"];


        $content_id = $post_data["content_id"];
        if(!$content_id) return response_error();
        $content = $this->modelItem->find($content_id);
        if($content)
        {
            if($content->owner_id == $me->id)
            {
                DB::beginTransaction();
                try
                {
                    $is_my_child = 0;
                    $last_brother_rank = 0;

                    if($position_id == 0)
                    {
                        $position_recursion_id = $menu_id;

                        while($position_recursion_id > 0)
                        {
                            $position_recursion_content = $this->modelItem->find($position_recursion_id);
                            if($position_recursion_content->id == $content_id)
                            {
                                $is_my_child = 1;
                                break;
                            }
                            else
                            {
                                $position_recursion_id = $position_recursion_content->p_id;
                            }

                        }
                    }
                    elseif($position_id != 0)
                    {
                        $position_recursion_id = $position_id;

                        while($position_recursion_id > 0)
                        {
                            $position_recursion_content = $this->modelItem->find($position_recursion_id);
                            if($position_recursion_content->id == $content_id)
                            {
                                $is_my_child = 1;
                                break;
                            }
                            else
                            {
                                $position_recursion_id = $position_recursion_content->p_id;
                            }

                        }
                    }


                    if($is_my_child || $content_id == $menu_id)
                    {
                        // 查找最后一个节点
                        $last_brother = $this->modelItem
                            ->where('item_id',$content->item_id)
                            ->where('p_id',$content->p_id)
                            ->orderBy('rank','desc')->first();
                        $last_brother_rank = $last_brother->rank;
                        $last_brother_rank_plus = $last_brother_rank + 2;

                        $content_children = $this->modelItem->where('item_id',$content->item_id)->where('p_id',$content_id)->get();
                        $children_count = count($content_children);
                        if($children_count)
                        {
                            $this->modelItem->timestamps;
                            $this->modelItem->where('p_id',$content_id)->increment('rank',$last_brother_rank_plus);
                            $num = $this->modelItem->where('p_id',$content_id)->update(['p_id'=>$content->p_id]);
//                            $content_children->increament('rank',$last_brother_rank_plus);
//                            $content_children->update(['p_id'=>$item->p_id]);
//                            if($num != $children_count)  throw new Exception("update--children--fail");
                        }
                    }

                    if($content_id != $menu_id)
                    {
                        $content->p_id = $menu_id;
                        $content->timestamps = false;
                        $content->save();
                    }

                    if($position_id != 0)
                    {
                        $position_content = $this->modelItem->find($position_id);
                        $position_content_rank = $position_content->rank;
                        $position_direction = $post_data["position_direction"];
                        if($position_direction == "before")
                        {

                            if($content_id == $menu_id)
                            {
                                $content->rank = $last_brother_rank + 1;
                            }
                            else
                            {
                                $position_content_brother = $this->modelItem
                                    ->where('p_id',$position_content->p_id)
                                    ->where('id','!=',$content_id)
                                    ->get();
                                $brother_count = count($position_content_brother);
                                if($brother_count)
                                {
                                    $this->modelItem->timestamps;
                                    $num = $this->modelItem
                                        ->where('p_id',$position_content->p_id)
                                        ->where('id','!=',$content_id)
                                        ->increment('rank');
//                                if($num != $brother_count)  throw new Exception("update--brother--fail");
                                }

                                $content->rank = 0;
                            }
//                            dd($content->rank);
                            $content->timestamps = false;
                            $content->save();
                        }
                        else if($position_direction == "after")
                        {

                            $position_content_brother = $this->modelItem
                                ->where('p_id',$position_content->p_id)
//                                ->where('rank','>=',$position_content->rank)
//                                ->where('id','>=',$position_content->id)
                                ->where(function ($query) use($position_content) {
                                    $query->where('rank','>',$position_content->rank)->orWhere(function($query2) use($position_content) {
                                        $query2->where('rank','=',$position_content->rank)->where('id','>',$position_content->id);
                                    });
                                })
                                ->where('id','!=',$position_id)
                                ->where('id','!=',$content_id)
                                ->get();
                            $brother_count = count($position_content_brother);
                            if($brother_count)
                            {
                                $this->modelItem->timestamps;
                                $num = $this->modelItem
                                    ->where('p_id',$position_content->p_id)
                                    ->where(function ($query) use($position_content) {
                                        $query->where('rank','>',$position_content->rank)->orWhere(function($query2) use($position_content) {
                                            $query2->where('rank','=',$position_content->rank)->where('id','>',$position_content->id);
                                        });
                                    })
                                    ->where('id','!=',$position_id)
                                    ->where('id','!=',$content_id)
                                    ->increment('rank');
//                            if($num != $brother_count)  throw new Exception("update--brother--fail");
                            }

                            $content->rank = $position_content_rank + 1;
                            $content->timestamps = false;
                            $content->save();
//                        dd($item->toArray());

                        }
                    }
                    else
                    {
                        $content->rank = 0;
                        $content->timestamps = false;
                        $content->save();
                    }

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
            else response_error([],"该内容不是你的，你不能操作！");

        }
        else return response_error([],"该内容不存在！");
    }
    // 【ITEM-Content】【时间点】移动
    public function operate_item_content_move_time_line($post_data)
    {
        $messages = [
            'content_id.required' => 'content_id.required.',
            'position_id.required' => 'position_id.required.',
//            'position_direction.required' => 'position_direction.required.',
        ];
        $v = Validator::make($post_data, [
            'content_id' => 'required',
            'position_id' => 'required',
//            'position_direction' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $this->get_me();
        $me = $this->me;
        $me_admin = $this->me_admin;


        $content_id = $post_data["content_id"];
        if(!$content_id) return response_error();
        $content = $this->modelItem->find($content_id);
        if($content)
        {
            if($content->owner_id == $me->id)
            {
                $position_id = $post_data["position_id"];

//                $my_younger_brother = $this->modelItem->where(['item_id'=>$position_content->item_id])
//                    ->where(function ($query) use($position_content) {
//                        $query->where('rank','<',$position_content->rank)->orWhere(function($query2) use($position_content) {
//                            $query2->where('rank','=',$position_content->rank)->where('id','<',$position_content->id);
//                        });
//                    })
//                    ->where('id','!=',$position_content->id)
//                    ->orderBy('rank','desc')
//                    ->orderBy('id','desc')
//                    ->first();
//                dd($my_younger_brother->rank.'->'.$my_younger_brother->time_point.'->'.$my_younger_brother->title);

//                $my_older_brother = $this->modelItem->where(['item_id'=>$position_content->item_id])
//                    ->where(function ($query) use($position_content) {
//                        $query->where('rank','>',$position_content->rank)->orWhere(function($query2) use($position_content) {
//                            $query2->where('rank','=',$position_content->rank)->where('id','>',$position_content->id);
//                        });
//                    })
//                    ->where('id','!=',$position_content->id)
//                    ->orderBy('rank','asc')
//                    ->orderBy('id','asc')
//                    ->first();
//                dd($my_older_brother->rank.'->'.$my_older_brother->time_point.'->'.$my_older_brother->title);


                DB::beginTransaction();
                try
                {
                    if($position_id == 0)
                    {
                        $content->rank = 0;
                        $content->timestamps = false;
                        $content->save();

                        $this->modelItem->timestamps = false;
//                        $num = $this->modelItem->where(['item_id'=>$content->item_id])
//                            ->where('id','!=',$content->id)
//                            ->increment('rank');

                        $my_brother_contents = $this->modelItem->where(['item_id'=>$content->item_id])
                            ->where('id','!=',$content->id)
                            ->orderBy('rank','asc')
                            ->orderBy('id','asc')
                            ->get();

                        foreach($my_brother_contents as $key => $value)
                        {
                            $value->timestamps = false;
                            $value->rank = $key + 1;
                            $value->save();
                        }

                    }
                    elseif($position_id != 0)
                    {
                        $position_content = $this->modelItem->find($position_id);
                        if(!$position_content) return response_error([],"该位置不存在！");
                        if($position_content->item_id != $content->item_id)  return response_error([],"不是同一个时间线！");

                        $content->rank = $position_content->rank + 1;
                        $content->timestamps = false;
                        $content->save();

                        $this->modelItem->timestamps = false;
                        $num = $this->modelItem->where(['item_id'=>$content->item_id])
                            ->where(function ($query) use($position_content) {
                                $query->where('rank','>',$position_content->rank)->orWhere(function($query2) use($position_content) {
                                    $query2->where('rank','=',$position_content->rank)->where('id','>',$position_content->id);
                                });
                            })
                            ->where('id','!=',$content->id)
                            ->where('id','!=',$position_content->id)
                            ->increment('rank',2);
                    }

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
            else response_error([],"该内容不是你的，你不能操作！");

        }
        else return response_error([],"该内容不存在！");
    }


    // 【ITEM-Content】内容获取
    public function operate_item_content_get($post_data)
    {
        $this->get_me();
        $me = $this->me;
        $me_admin = $this->me_admin;

        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error([],"该内容不存在，刷新页面试试！");

        $content = $this->modelItem->find($item_id);
        if($content->owner_id != $me->id) return response_error([],"该内容不是你的，您不能操作！");
        else
        {
            if(@getimagesize(env('LW_DOMAIN_CDN').'/'.$content->cover_pic))
            {
                $cover_url = url(env('LW_DOMAIN_CDN').'/'.$content->cover_pic);
                $content->cover_img = '<img src="'.$cover_url.'" alt="" />"';
            }
            else $content->cover_img = '';

            return response_success($content);
        }
    }


    // 【ITEM-Content】删除
    public function operate_item_content_delete($post_data)
    {
        $me = Auth::guard('doc')->user();
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
    // 【ITEM-Content】发布
    public function operate_item_content_publish($post_data)
    {
        $me = Auth::guard('doc')->user();
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
            $update["is_published"] = 1;
            $update["published_at"] = time();
            $mine->timestamps = false;
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }
    // 【ITEM-Content】启用
    public function operate_item_content_enable($post_data)
    {
        $me = Auth::guard('doc')->user();
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
            $msg = '操作失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }
    // 【ITEM-Content】禁用
    public function operate_item_content_disable($post_data)
    {
        $me = Auth::guard('doc')->user();
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
            $msg = '操作失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }








    // 返回（后台）主页视图
    public function view_item_list_for_mine($post_data)
    {
        $this->get_me();
        $me = $this->me;

        $item_query = $this->modelItem->select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where('owner_id',$me->id)
            ->where(['item_category'=>1]);

        $menu_active = 'sidebar_menu_root_active';

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

            if(@getimagesize(env('LW_DOMAIN_CDN').'/'.$item->cover_pic))
            {
                $item->cover_picture = env('LW_DOMAIN_CDN').'/'.$item->cover_pic;
            }
            else
            {
                if(!empty($item->img_tags[0])) $item->cover_picture = $item->img_tags[2][0];
            }
//            dd($item->cover_picture);
        }

        $head_title_prefix = '';
//        $head_title_prefix = '';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return[$sidebar_active] = 'active';
        $return[$menu_active] = 'active';
        $return['item_list'] = $item_list;

        $view_blade = env('LW_TEMPLATE_DOC_FRONT').'entrance.root';
        return view($view_blade)->with($return);
    }

    // 【我的原创】
    public function view_item_list_for_my_original($post_data)
    {
        $this->get_me();

        if($this->auth_check)
        {
            $me = $this->me;
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
        $this->get_me();

        if($this->auth_check)
        {
            $user = $this->me;
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
        $this->get_me();

        if($this->auth_check)
        {
            $user = $this->me;
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
        $this->get_me();

        if($this->auth_check)
        {
            $me = $this->me;
            $me_id = $me->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($me_id) { $query->with([
                    'user',
                    'forward_item'=>function($query) { $query->with('user'); },
                    'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
                ])->wherePivot('relation_type',11)->orderby('pivot_user_item.id','desc'); }
            ])->find($me_id);
            $item_list = $query->pivot_item;
        }
        else $item_list = [];

        foreach ($item_list as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        $menu_active = 'sidebar_menu_for_my_favor_active';
        $sidebar_active = 'sidebar_menu_for_my_favor_active';

        $head_title_text = "我的点赞";
        $head_title_prefix = '';
        $head_title_prefix = '';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return[$sidebar_active] = 'active';
        $return[$menu_active] = 'active';
        $return['item_list'] = $item_list;

        $view = env('LW_TEMPLATE_DOC_FRONT').'entrance.my-favor';
        return view($view)->with($return);
    }
    // 【收藏】
    public function view_item_list_for_my_collection($post_data)
    {
        $this->get_me();

        if($this->auth_check)
        {
            $me = $this->me;
            $me_id = $me->id;

            // Method 1
            $query = User::with([
                'pivot_item'=>function($query) use($me_id) { $query->with([
                    'user',
                    'pivot_item_relation'=>function($query) use($me_id) { $query->where('user_id',$me_id); }
                ])->wherePivot('relation_type',21)->orderby('pivot_user_item.id','desc'); }
            ])->find($me_id);
            $item_list = $query->pivot_item;
        }
        else $item_list = [];

        foreach ($item_list as $item)
        {
            $item->custom_decode = json_decode($item->custom);
            $item->content_show = strip_tags($item->content);
            $item->img_tags = get_html_img($item->content);
        }

        $menu_active = 'sidebar_menu_for_my_collection_active';
        $sidebar_active = 'sidebar_menu_for_my_collection_active';

        $head_title_text = "我的收藏";
        $head_title_prefix = '';
        $head_title_prefix = '';
        $head_title_postfix = ' - 如未轻博';
        $return['head_title'] = $head_title_prefix.$head_title_text.$head_title_postfix;
        $return[$sidebar_active] = 'active';
        $return[$menu_active] = 'active';
        $return['item_list'] = $item_list;
        $view = env('LW_TEMPLATE_DOC_FRONT').'entrance.my-collection';
        return view($view)->with($return);
    }


    // 【发现】
    public function view_item_list_for_my_discovery($post_data)
    {
        if($this->auth_check)
        {
            $user = $this->me;
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
        if($this->auth_check)
        {
            $user = $this->me;
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
        if($this->auth_check)
        {
            $user = $this->me;
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




    // 【ITEM】【添加】【点赞 | 收藏 | +待办事 | +日程】
    public function operate_item_add_this($post_data,$type=0)
    {
        if($this->auth_check)
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
                $me = $this->me;
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
        if($this->auth_check)
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
                $me = $this->me;
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
        if($this->auth_check)
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
                $me = $this->me;
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








    /*
     * 用户管理
     */
    // 【用户】【组织】返回-添加-视图
    public function view_user_staff_create()
    {
        $view_template = env('LW_TEMPLATE_DOC_FRONT');
        $view_blade = $view_template.'entrance.user.staff-edit';

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return view($view_template.'errors.403');

        $item_type = 'user';
        $item_type_text = '员工';
        $title_text = '添加'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/user/staff-list';

        $return['me'] = $me;
        $return['operate'] = 'create';
        $return['operate_id'] = 0;
        $return['category'] = 'item';
//        $return['item_type'] = $item_type;
        $return['item_type_text'] = $item_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;
        $return['sidebar_menu_staff_create_active'] = 'active';

        return view($view_blade)->with($return);
    }
    // 【用户】【组织】返回-编辑-视图
    public function view_user_staff_edit()
    {
        $view_template = env('LW_TEMPLATE_DOC_FRONT');
        $view_blade = $view_template.'entrance.user.staff-edit';

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return view($view_template.'errors.403');

        $id = request("user-id",0);

        $item_type = 'item';
        $item_type_text = '员工';
        $title_text = '编辑'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/user/staff-list';

        $return['me'] = $me;
        $return['operate_id'] = $id;
        $return['category'] = 'item';
//        $return['item_type'] = $item_type;
        $return['item_type_text'] = $item_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_list'] = $list_link;
        $return['sidebar_menu_staff_create_active'] = 'active';

        if($id == 0)
        {
            $return['operate'] = 'create';
        }
        else
        {
            $mine = User::with(['parent'])->find($id);
            if($mine)
            {
//                if(!in_array($mine->user_type,[11,88])) return view($this->view_blade_404);
                $mine->custom = json_decode($mine->custom);
                $mine->custom2 = json_decode($mine->custom2);
                $mine->custom3 = json_decode($mine->custom3);

                $return['operate'] = 'edit';
                $return['data'] = $mine;
            }
            else return view($this->view_blade_404);
        }

        return view($view_blade)->with($return);
    }
    // 【用户】【组织】保存数据
    public function operate_user_staff_save($post_data)

    {
//        dd($post_data);
        $messages = [
            'operate.required' => '参数有误',
            'username.required' => '请输入用户名',
            'mobile.required' => '请输入电话',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'username' => 'required',
            'mobile' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }


        $me = Auth::guard('staff')->user();
//        if(!in_array($me->user_category,[0])) return response_error([],"你没有操作权限！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];

        if($operate == 'create') // 添加 ( $id==0，添加一个新用户 )
        {
            $mine = new User;
            $post_data["user_category"] = 1;
            $post_data["active"] = 1;
            $post_data["password"] = password_encode("abcd1234");
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
            unset($mine_data['operate']);
            unset($mine_data['operate_id']);
            $bool = $mine->fill($mine_data)->save();
            if($bool)
            {

                // 头像
                if(!empty($post_data["portrait"]))
                {
                    $mine_portrait_img = $mine->portrait_img;
                    if(!empty($mine_portrait_img) && file_exists(storage_path("resource/" . $mine_portrait_img)))
                    {
                        unlink(storage_path("resource/" . $mine_portrait_img));
                    }

//                    $result = upload_storage($post_data["portrait"]);
//                    $result = upload_storage($post_data["portrait"], null, null, 'assign');
                    $result = upload_img_storage($post_data["portrait"],'user_'.$mine->id,'staff/unique/portrait/','assign');
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

                        copy(storage_path("resource/unique/portrait/user0.jpeg"), storage_path("resource/staff/unique/portrait/user_".$mine->id.".jpeg"));
                        $mine->portrait_img = "staff/unique/portrait/user_".$mine->id.".jpeg";
                        $mine->save();
                    }
                }

                // 微信二维码
                if(!empty($post_data["wx_qr_code"]))
                {
                    // 删除原图片
                    $mine_wx_qr_code_img = $mine->wechat_qr_code_img;
                    if(!empty($mine_wx_qr_code_img) && file_exists(storage_path("resource/" . $mine_wx_qr_code_img)))
                    {
                        unlink(storage_path("resource/" . $mine_wx_qr_code_img));
                    }

                    $result = upload_storage($post_data["wx_qr_code"]);
                    if($result["result"])
                    {
                        $mine->wx_qr_code_img = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--wx_qr_code--fail");
                }

                // 联系人微信二维码
                if(!empty($post_data["linkman_wx_qr_code"]))
                {
                    // 删除原图片
                    $mine_linkman_wx_qr_code_img = $mine->linkman_wx_qr_code_img;
                    if(!empty($mine_linkman_wx_qr_code_img) && file_exists(storage_path("resource/" . $mine_linkman_wx_qr_code_img)))
                    {
                        unlink(storage_path("resource/" . $mine_linkman_wx_qr_code_img));
                    }

                    $result = upload_storage($post_data["linkman_wx_qr_code"]);
                    if($result["result"])
                    {
                        $mine->linkman_wx_qr_code_img = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--linkman_wx_qr_code--fail");
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


    // 【用户】【全部】返回-列表-视图
    public function view_user_staff_list($post_data)
    {
        $item_type = 'item-list';
        $item_type_text = '员工';
        $title_text = $item_type_text.'列表';
        $list_text = $item_type_text.'列表';
        $list_link = '/admin/user/user-list-for-all';
        $menu_active = 'sidebar_menu_staff_list_active';

        $user_list = User::withTrashed()->with([
//            'ad',
            ])->withCount([
//            'items as article_count' => function($query) { $query->where(['item_category'=>1,'item_type'=>1]); },
//            'items as activity_count' => function($query) { $query->where(['item_category'=>1,'item_type'=>11]); },
            ])
//            ->where('user_category',1)
            ->where('user_type','>',0)
//            ->where('user_status',1)
//            ->where('active',1)
            ->orderByDesc('id')
            ->paginate(20);

        $return['user_list'] = $user_list;
        $return['title_text'] = $title_text;
        return view(env('LW_TEMPLATE_DOC_FRONT').'entrance.user.staff-list')->with($return);
    }
    // 【用户】【全部】返回-列表-数据
    public function get_user_staff_list_datatable($post_data)
    {
        $me = Auth::guard("staff")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where('owner_id','>=',1)
            ->where(['owner_id'=>100,'item_category'=>100])
            ->where('item_type','!=',0);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");
        if(!empty($post_data['major'])) $query->where('major', 'like', "%{$post_data['major']}%");
        if(!empty($post_data['nation'])) $query->where('nation', 'like', "%{$post_data['nation']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【用户】获取详情
    public function operate_user_staff_get($post_data)
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
        if($operate != 'item-get') return response_error([],"参数operate有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");

        return response_success($item,"");

    }
    // 【用户】删除
    public function operate_user_staff_delete($post_data)
    {
        $messages = [
            'operate.required' => '参数有误！',
            'user_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'user_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'user-delete') return response_error([],"参数operate有误！");
        $id = $post_data["user_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $mine = User::withTrashed()->find($id);
        if(!$mine) return response_error([],"该用户不存在，刷新页面重试！");
        if(in_array($mine->user_type,[0,1,9,11])) return response_error([],"该用户不可删除！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return response_error([],"用户类型错误！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $mine->timestamps = false;
            $bool = $mine->delete();
            if(!$bool) throw new Exception("user--delete--fail");
            DB::commit();

            $user_html = $this->get_the_user_html($mine);
            return response_success(['user_html'=>$user_html]);
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
    // 【用户】恢复
    public function operate_user_staff_restore($post_data)
    {
        $messages = [
            'operate.required' => '参数有误！',
            'user_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'user_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'user-restore') return response_error([],"参数operate有误！");
        $id = $post_data["user_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $mine = User::withTrashed()->find($id);
        if(!$mine) return response_error([],"该用户不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return response_error([],"用户类型错误！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $mine->timestamps = false;
            $bool = $mine->restore();
            if(!$bool) throw new Exception("item--restore--fail");
            DB::commit();

            $user_html = $this->get_the_user_html($mine);
            return response_success(['user_html'=>$user_html]);
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
    // 【用户】彻底删除
    public function operate_user_staff_delete_permanently($post_data)
    {
        $messages = [
            'operate.required' => '参数有误！',
            'user_id.required' => '请输入ID！',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'user_id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'user-delete-permanently') return response_error([],"参数operate有误！");
        $id = $post_data["user_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $mine = User::withTrashed()->find($id);
        if(!$mine) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return response_error([],"用户类型错误！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $bool = $mine->forceDelete();
            if(!$bool) throw new Exception("item--delete--fail");
            DB::commit();

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




    /*
     * 用户系统
     */
    // 【用户】【修改密码】
    public function operate_user_change_password($post_data)
    {
        $messages = [
            'operate.required' => '参数有误',
            'id.required' => '请输入用户ID',
            'user-password.required' => '请输入密码',
            'user-password-confirm.required' => '请输入确认密码',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
            'id' => 'required',
            'user-password' => 'required',
            'user-password-confirm' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $operate = $post_data["operate"];
        if($operate != 'change-password') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $me = Auth::guard('atom')->user();
        if($me->user_type != 0) return response_error([],"你没有操作权限");

        $password = $post_data["user-password"];
        $confirm = $post_data["user-password-confirm"];
        if($password != $confirm) return response_error([],"两次密码不一致！");

//        if(!password_is_legal($password)) ;
        $pattern = '/^[a-zA-Z0-9]{1}[a-zA-Z0-9]{5,19}$/i';
        if(!preg_match($pattern,$password)) return response_error([],"密码格式不正确！");


        $user = User::find($id);
        if(!$user) return response_error([],"该用户不存在，刷新页面重试");


        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $user->password = password_encode($password);
            $user->save();

            $bool = $user->save();
            if(!$bool) throw new Exception("update--user--fail");

            DB::commit();
            return response_success(['id'=>$user->id]);
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


    // 【select2】
    public function operate_item_select2_people($post_data)
    {
        $query = YF_Item::select(['id','name as text'])->where(['item_category'=>100,'item_type'=>11]);
        if(!empty($post_data['keyword']))
        {
            $keyword = "%{$post_data['keyword']}%";
            $query->where('name','like',"%$keyword%");
        }
        $list = $query->get()->toArray();
        return $list;
    }








    /*
     * 任务管理
     */
    // 【任务】返回-添加-视图
    public function view_item_task_create()
    {
        $view_template = env('LW_TEMPLATE_DOC_FRONT');
        $view_blade = $view_template.'entrance.item.task-edit';

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return view($view_template.'errors.403');

        $item_type = 'item';
        $item_type_text = '任务';
        $title_text = '添加'.$item_type_text;
        $list_text = $item_type_text;
        $list_link = '/item/item-list-for-'.$item_type;

        $return['operate'] = 'create';
        $return['operate_id'] = 0;
        $return['category'] = 'item';
        $return['type'] = $item_type;
//        $return['item_type'] = $item_type;
        $return['item_type_text'] = $item_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;
        $return['sidebar_menu_task_create_active'] = 'active';

        return view($view_blade)->with($return);
    }
    // 【任务】返回-编辑-视图
    public function view_item_task_edit()
    {
        $view_template = env('LW_TEMPLATE_DOC_FRONT');
        $view_blade = $view_template.'entrance.item.task-edit';

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return view($view_template.'errors.403');

        $item_id = request("item-id",0);
        $mine = YF_Item::with([])->withTrashed()->find($item_id);
        if(!$mine) return view($this->view_blade_404);
        if($mine->creator_id != $me->id) return view($view_template.'errors.403');

        $item_type = 'item';
        $item_type_text = '任务';
        $title_text = '编辑'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/item/task-list';

        $return['operate_id'] = $item_id;
        $return['category'] = 'item';
        $return['type'] = $item_type;
//        $return['item_type'] = $item_type;
        $return['item_type_text'] = $item_type_text;
        $return['title_text'] = $title_text;
        $return['list_text'] = $list_text;
        $return['list_link'] = $list_link;
        $return['sidebar_menu_staff_create_active'] = 'active';

        if($item_id == 0)
        {
            $return['operate'] = 'create';
        }
        else
        {
            $mine->custom = json_decode($mine->custom);
            $mine->custom2 = json_decode($mine->custom2);
            $mine->custom3 = json_decode($mine->custom3);

            $return['operate'] = 'edit';
            $return['data'] = $mine;
        }

        return view($view_blade)->with($return);
    }
    // 【任务】保存-数据
    public function operate_item_task_save($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
        ];
        $v = Validator::make($post_data, [
            'operate' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];
        $type = $post_data["type"];

        if($operate == 'create') // 添加 ( $id==0，添加一个内容 )
        {
            $mine = new YF_Item;
            $post_data["item_active"]  = isset($post_data['item_active'])  ? $post_data['item_active']  : 0;
            $post_data["item_category"] = 11;
            $post_data["owner_id"] = 100;
            $post_data["creator_id"] = $me->id;
//            if($type == 'object') $post_data["item_type"] = 1;
//            else if($type == 'people') $post_data["item_type"] = 11;
//            else if($type == 'product') $post_data["item_type"] = 22;
//            else if($type == 'event') $post_data["item_type"] = 33;
//            else if($type == 'conception') $post_data["item_type"] = 91;
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = YF_Item::withTrashed()->find($operate_id);
            if(!$mine) return response_error([],"该内容不存在，刷新页面重试！");
            $post_data["updater_id"] = $me->id;
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
            unset($mine_data['category']);
            unset($mine_data['type']);

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
                    $mine_attachment_src = $mine->attachment;
                    if(!empty($mine_attachment_src) && file_exists(storage_path("resource/" . $mine_attachment_src)))
                    {
                        unlink(storage_path("resource/" . $mine_attachment_src));
                    }

                    $result = upload_file_storage($post_data["attachment"],'','staff/attachment');
                    if($result["result"])
                    {
                        $mine->attachment_name = $result["name"];
                        $mine->attachment_src = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--attachment_file--fail");
                }

                // 生成二维码
                $qr_code_path = "resource/staff/unique/qr_code/";  // 保存目录
                if(!file_exists(storage_path($qr_code_path)))
                    mkdir(storage_path($qr_code_path), 0777, true);
                // qr_code 图片文件
                $url = env('DOMAIN_STAFF').'/item/'.$mine->id;  // 目标 URL
                $filename = 'qr_code_staff_item_'.$mine->id.'.png';  // 目标 file
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

    // 【任务-备注】保存-数据
    public function operate_item_task_remark_save($post_data)
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
        if($operate != 'item-remark-save') return response_error([],"参数operate有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");
//        if($item->creator_id != $me->id) return response_error([],"你没有操作权限！");


        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->timestamps = false;
            $item->remark = $post_data['content'];

            $bool = $item->save();
            if(!$bool) throw new Exception("update--item-remark--fail");
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




    // 【ITEM】管理员封禁
    public function operate_item_admin_disable($post_data)
    {
        $messages = [
            'operate.required' => '参数有误',
            'id.required' => '请输入关键词ID',
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
        if($operate != 'item-admin-disable') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
        if($me->user_category != 0) return response_error([],"你没有操作权限！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->item_status = 9;
            $item->timestamps = false;
            $bool = $item->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
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
    // 【ITEM】管理员解禁
    public function operate_item_admin_enable($post_data)
    {
        $messages = [
            'operate.required' => '参数有误',
            'id.required' => '请输入关键词ID',
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
        if($operate != 'item-admin-enable') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
        if($me->user_category != 0) return response_error([],"你没有操作权限！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->item_status = 1;
            $item->timestamps = false;
            $bool = $item->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
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








    // 【内容】返回-内容-HTML
    public function get_the_user_html($item)
    {
        $item->custom = json_decode($item->custom);
        $user_array[0] = $item;
        $return['user_list'] = $user_array;

        // method A
        $item_html = view(env('LW_TEMPLATE_DOC_FRONT').'component.user-list')->with($return)->__toString();
//        // method B
//        $item_html = view(env('LW_TEMPLATE_DOC_FRONT').'component.item-list')->with($return)->render();
//        // method C
//        $view = view(env('LW_TEMPLATE_DOC_FRONT').'component.item-list')->with($return);
//        $item_html=response($view)->getContent();

        return $item_html;
    }

    // 【内容】返回-内容-HTML
    public function get_the_item_html($item)
    {
        $item->custom = json_decode($item->custom);
        $item_array[0] = $item;
        $return['item_list'] = $item_array;

        // method A
        $item_html = view(env('TEMPLATE_COMMON_FRONT').'component.item-list')->with($return)->__toString();
//        // method B
//        $item_html = view(env('LW_TEMPLATE_DOC_FRONT').'component.item-list')->with($return)->render();
//        // method C
//        $view = view(env('LW_TEMPLATE_DOC_FRONT').'component.item-list')->with($return);
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
            if (!empty($img) && file_exists(public_path($img)))
            {
                unlink(public_path($img));
            }
        }
    }




    // 【内容】返回-列表-视图
    public function view_item_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list')
            ->with([
                'sidebar_item_list_active'=>'active'
            ]);
    }
    // 【内容】返回-列表-数据
    public function get_item_list_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = YF_Item::select('*')
            ->with('owner')
            ->where('owner_id','>=',1);

        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("id", "desc");

        if($limit == -1) $list = $query->withTrashed()->get();
        else $list = $query->skip($skip)->take($limit)->withTrashed()->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【全部】返回-列表-视图
    public function view_item_list_for_all($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-all')
            ->with([
                'sidebar_item_list_active'=>'active',
                'sidebar_item_list_for_all_active'=>'active'
            ]);
    }
    // 【内容】【全部】返回-列表-数据
    public function get_item_list_for_all_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where('owner_id','>=',1)
            ->where(['owner_id'=>100,'item_category'=>100])
            ->where('item_type','!=',0);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");
        if(!empty($post_data['major'])) $query->where('major', 'like', "%{$post_data['major']}%");
        if(!empty($post_data['nation'])) $query->where('nation', 'like', "%{$post_data['nation']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【活动】返回-列表-视图
    public function view_item_list_for_object($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-object')
            ->with([
                'sidebar_item_list_active'=>'active',
                'sidebar_item_list_for_object_active'=>'active'
            ]);
    }
    // 【内容】【活动】返回-列表-数据
    public function get_item_list_for_object_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where(['owner_id'=>100,'item_category'=>100,'item_type'=>1]);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【人】返回-列表-视图
    public function view_item_list_for_people($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-people')
            ->with([
                'sidebar_item_list_people'=>'active',
                'sidebar_item_list_for_people_active'=>'active'
            ]);
    }
    // 【内容】【文章】返回-列表-数据
    public function get_item_list_for_people_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where(['owner_id'=>100,'item_category'=>100,'item_type'=>11]);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");
        if(!empty($post_data['major'])) $query->where('major', 'like', "%{$post_data['major']}%");
        if(!empty($post_data['nation'])) $query->where('nation', 'like', "%{$post_data['nation']}%");

        $query->addSelect(DB::raw('cast(birth_time as DECIMAL) as t'));
        $query->addSelect(DB::raw('cast(birth_time as DATE) as tt'));
        $query->addSelect(DB::raw('FROM_UNIXTIME(UNIX_TIMESTAMP(cast(birth_time as DATE))) as ttt'));

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            if($field == "birth_time") $query->orderByRaw(DB::raw('cast(birth_time as SIGNED) '.$order_dir));
            else if($field == "death_time") $query->orderByRaw(DB::raw('cast(death_time as SIGNED) '.$order_dir));
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【广告】返回-列表-视图
    public function view_item_list_for_product($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-product')
            ->with([
                'sidebar_item_list_active'=>'active',
                'sidebar_item_list_for_product_active'=>'active'
            ]);
    }
    // 【内容】【广告】返回-列表-数据
    public function get_item_list_for_product_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with([
                'owner',
                'creator',
                'pivot_product_people'=>function ($query) { $query->where('relation_type',1); }
            ])
            ->where(['owner_id'=>100,'item_category'=>100,'item_type'=>22]);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【广告】返回-列表-视图
    public function view_item_list_for_event($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-event')
            ->with([
                'sidebar_item_list_active'=>'active',
                'sidebar_item_list_for_event_active'=>'active'
            ]);
    }
    // 【内容】【广告】返回-列表-数据
    public function get_item_list_for_event_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where(['owner_id'=>100,'item_category'=>100,'item_type'=>33]);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【广告】返回-列表-视图
    public function view_item_list_for_conception($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-conception')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_list_for_conception_active'=>'active'
            ]);
    }
    // 【内容】【广告】返回-列表-数据
    public function get_item_list_for_conception_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = YF_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where(['owner_id'=>100,'item_category'=>100,'item_type'=>91]);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }




    // 顺序排列
    function get_recursion($result, $parent_id=0, $level=0)
    {
        /*记录排序后的类别数组*/
        static $list = array();

        foreach ($result as $k => $v)
        {
//            for($i=0; $i < $level; $i++)
//            {
//                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
//            }
//            echo "第{$level}层-开始 <br>";

            if($v->p_id == $parent_id)
            {
                $mine = $v;
                $v->level = $level;
                $v->oldest = 1;

                foreach($list as $key=>$val)
                {
                    if($val->id == $parent_id) $list[$key]->has_child = 1;
                    if($val->p_id == $parent_id)
                    {
                        $list[$key]->has_brother = 1;
                        $v->oldest = 0;
                    }
                }

                /*将该类别的数据放入list中*/
                $list[] = $v;
                unset($result[$k]);

//                for($i=0; $i < $level; $i++)
//                {
//                    echo "&nbsp;&nbsp;&nbsp;&nbsp;";
//                }
//                echo "v -- ";
//                var_dump(end($list)->toArray());
//                echo "<br>";

                $this->get_recursion($result, $mine->id, $level+1);

            }

//            for($i=0; $i < $level; $i++)
//            {
//                echo "&nbsp;&nbsp;&nbsp;&nbsp;";
//            }
//            echo "第{$level}层-结束 <br><br>";
        }

        return $list;
    }

    //
    function get_recursion_level($item_id)
    {
        /*记录排序后的类别数组*/
        static $level = 1;
        static $list = array();

        $item = $this->modelItem->find($item_id);
        if($item->p_id != 0)
        {
            $list[] = $item;
            $level += 1;
            $this->get_recursion_level($item->p_id);
        }

        return $level;
    }


}