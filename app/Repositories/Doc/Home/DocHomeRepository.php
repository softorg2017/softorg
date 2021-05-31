<?php
namespace App\Repositories\Doc\Home;

use App\User;

use App\Models\Def\Def_Item;
use App\Models\Def\Def_Record;
use App\Models\Org\Org_Item;
use App\Models\Doc\Doc_Item;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode, Excel;

class DocHomeRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->model = new User;
    }


    // 返回（后台）主页视图
    public function view_home_index()
    {
        return view('doc.home.index');
    }









    /*
     * 用户基本信息
     */
    // 【基本信息】返回视图
    public function view_info_index()
    {
        $me = Auth::guard('admin')->user();
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.info.index')->with(['data'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_info_edit()
    {
        $me = Auth::guard('admin')->user();
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.info.edit')->with(['data'=>$me]);
    }
    // 【基本信息】保存数据
    public function operate_info_save($post_data)
    {
        $me = Auth::guard('doc')->user();

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
                    if(!empty($mine_portrait_img) && file_exists(storage_path("resource/" . $mine_portrait_img)))
                    {
                        unlink(storage_path("resource/" . $mine_portrait_img));
                    }

//                    $result = upload_img_storage($post_data["portrait"]);
                    $result = upload_img_storage($post_data["portrait"],'doc_user_'.$me->id,'doc/unique/portrait','assign');
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

    // 【密码】返回修改视图
    public function view_info_password_reset()
    {
        $me = Auth::guard('admin')->user();
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.info.password-reset')->with(['data'=>$me]);
    }
    // 【密码】保存数据
    public function operate_info_password_reset_save($post_data)
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
            $me = Auth::guard('admin')->user();
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
     * 用户系统
     */
    // 【代理商&用户】【修改密码】
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

        $me = Auth::guard('admin')->user();
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
    public function operate_business_select2_user($post_data)
    {
        $me = Auth::guard('admin')->user();
        if(empty($post_data['keyword']))
        {
            $list =User::select(['id','username as text'])
                ->where(['userstatus'=>'正常','status'=>1])
                ->whereIn('usergroup',['Agent','Agent2'])
                ->orderBy('id','desc')
                ->get()
                ->toArray();
        }
        else
        {
            $keyword = "%{$post_data['keyword']}%";
            $list =User::select(['id','username as text'])
                ->where(['userstatus'=>'正常','status'=>1])
                ->whereIn('usergroup',['Agent','Agent2'])
                ->where('sitename','like',"%$keyword%")
                ->orderBy('id','desc')
                ->get()
                ->toArray();
        }
        array_unshift($list, ['id'=>0,'text'=>'【全部代理】']);
        return $list;
    }






    // 【ITEM】返回-添加-视图
    public function view_item_item_create($post_data)
    {
        $me = Auth::user();
//        if(!in_array($me->user_type,[0,1])) return view(env('TEMPLATE_DOC_HOME').'errors.404');

        $item_type = 'item';
        $item_type_text = '内容';
        $title_text = '添加'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/home/item/item-list';

        $view_blade = env('TEMPLATE_DOC_HOME').'entrance.item.item-edit';
        return view($view_blade)->with([
            'operate'=>'create',
            'operate_id'=>0,
            'category'=>'item',
            'type'=>$item_type,
            'item_type_text'=>$item_type_text,
            'title_text'=>$title_text,
            'list_text'=>$list_text,
            'list_link'=>$list_link,
        ]);
    }
    // 【ITEM】返回-编辑-视图
    public function view_item_item_edit($post_data)
    {
        $me = Auth::user();
        if(!in_array($me->user_type,[0,1])) return view(env('TEMPLATE_DOC_HOME').'errors.404');

        $id = $post_data["id"];
        $mine = Doc_Item::with(['owner'])->find($id);
        if(!$mine) return view(env('TEMPLATE_DOC_HOME').'errors.404');


        $item_type = 'item';
        $item_type_text = '内容';
        $title_text = '编辑'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/admin/item/item-list';

        if($mine->item_type == 0)
        {
            $item_type = 'item';
            $item_type_text = '内容';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/home/item/item-list-for-all';
        }
        else if($mine->item_type == 1)
        {
            $item_type = 'article';
            $item_type_text = '文章';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/home/item/item-article-list';
        }
        else if($mine->item_type == 9)
        {
            $item_type = 'activity';
            $item_type_text = '活动';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/home/item/item-list-for-activity';
        }
        else if($mine->item_type == 11)
        {
            $item_type = 'menu_type';
            $item_type_text = '书目';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/home/item/item-list-for-menu_type';
        }
        else if($mine->item_type == 18)
        {
            $item_type = 'time_line';
            $item_type_text = '时间线';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/home/item/item-list-for-time_line';
        }
        else if($mine->item_type == 88)
        {
            $item_type = 'advertising';
            $item_type_text = '广告';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/home/item/item-list-for-advertising';
        }

        $view_blade = env('TEMPLATE_DOC_HOME').'entrance.item.item-edit';

        if($id == 0)
        {
            return view($view_blade)->with([
                'operate'=>'create',
                'operate_id'=>$id,
                'category'=>'item',
                'type'=>$item_type,
                'item_type_text'=>$item_type_text,
                'title_text'=>$title_text,
                'list_text'=>$list_text,
                'list_link'=>$list_link,
            ]);
        }
        else
        {
            $mine = Doc_Item::with(['user'])->find($id);
            if($mine)
            {
                $mine->custom = json_decode($mine->custom);
                $mine->custom2 = json_decode($mine->custom2);
                $mine->custom3 = json_decode($mine->custom3);

                return view($view_blade)->with([
                    'operate'=>'edit',
                    'operate_id'=>$id,
                    'category'=>'item',
                    'type'=>$item_type,
                    'item_type_text'=>$item_type_text,
                    'title_text'=>$title_text,
                    'list_text'=>$list_text,
                    'list_link'=>$list_link,
                    'data'=>$mine
                ]);
            }
            else return response("该内容不存在！", 404);
        }
    }
    // 【ITEM】保存-数据
    public function operate_item_item_save($post_data)
    {
//        dd('edit');
        $messages = [
            'operate.required' => '参数有误',
            'title.required' => '请输入标题',
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
        if(!in_array($me->user_type,[0,1])) return response_error([],"你没有操作权限！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];
        $type = $post_data["type"];

        if($operate == 'create') // 添加 ( $id==0，添加一个内容 )
        {
            $mine = new Doc_Item;
            $post_data["owner_id"] = $me->id;
            $post_data["item_category"] = 1;

//            if($type == 'item') $post_data["item_type"] = 0;
//            else if($type == 'article') $post_data["item_type"] = 1;
//            else if($type == 'activity') $post_data["item_type"] = 9;
//            else if($type == 'menu_type') $post_data["item_type"] = 11;
//            else if($type == 'time_line') $post_data["item_type"] = 18
//            else if($type == 'advertising') $post_data["item_type"] = 88;
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = Doc_Item::find($operate_id);
            if(!$mine) return response_error([],"该内容不存在，刷新页面重试！");

            if($mine->owner_id != $me->id) $mine->timestamps = false;
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
    public function operate_item_item_delete($post_data)
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
        if($operate != 'item-delete') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Doc_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");

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

            $mine_cover_pic = $item->cover_pic;
            $mine_attachment_src = $item->attachment_src;
            $mine_content = $item->content;


            $bool = $item->delete();
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







    // 【内容】【全部】返回-列表-视图
    public function view_item_list($post_data)
    {
        $item_type = isset($post_data['item-type']) ? $post_data['item-type'] : '';
        if($item_type == "article") $sidebar_active = 'sidebar_item_list_for_article_active';
        else if($item_type == "menu_type") $sidebar_active = 'sidebar_item_list_for_menu_type_active';
        else if($item_type == "time_line") $sidebar_active = 'sidebar_item_list_for_time_line_active';
        else if($item_type == "debase") $sidebar_active = 'sidebar_item_list_for_debase_active';
        else if($item_type == "vote") $sidebar_active = 'sidebar_item_list_for_vote_active';
        else if($item_type == "ask") $sidebar_active = 'sidebar_item_list_for_ask_active';

        return view(env('TEMPLATE_DOC_HOME').'entrance.item.item-list')
            ->with([
                'sidebar_item_list_active'=>'active',
                $sidebar_active=>'active'
            ]);
    }
    // 【内容】【全部】返回-列表-数据
    public function get_item_list_datatable($post_data)
    {
        $me = Auth::user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where('owner_id', $me->id)
            ->where('item_category', '!=',0)
            ->where('item_type', '!=',0);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");

        $item_type = isset($post_data['item-type']) ? $post_data['item-type'] : '';
        if($item_type == "article") $query->where('item_type', 1);
        else if($item_type == "menu_type") $query->where('item_type', 11);
        else if($item_type == "time_line") $query->where('item_type', 18);
        else if($item_type == "debase") $query->where('item_type', 22);
        else if($item_type == "vote") $query->where('item_type', 29);
        else if($item_type == "ask") $query->where('item_type', 31);

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

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
//            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }

    // 【内容】【全部】返回-列表-视图
    public function view_item_list_for_all($post_data)
    {
        return view(env('TEMPLATE_DOC_HOME').'entrance.item.item-list-for-all')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_list_for_all_active'=>'active'
            ]);
    }
    // 【内容】【全部】返回-列表-数据
    public function get_item_list_for_all_datatable($post_data)
    {
        $me = Auth::user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where('owner_id', $me->id)
            ->where('item_category', '!=',0)
            ->where('item_type', '!=',0);

        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");

        $item_type = isset($post_data['item_type']) ? $post_data['item_type'] : '';
        if($item_type == "article") $query->where('item_type', 1);
        else if($item_type == "menu_type") $query->where('item_type', 11);
        else if($item_type == "time_line") $query->where('item_type', 18);
        else if($item_type == "debase") $query->where('item_type', 22);
        else if($item_type == "vote") $query->where('item_type', 29);
        else if($item_type == "ask") $query->where('item_type', 31);

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

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
//            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }





    /*
     *
     */
    public function view_item_content_management($post_data)
    {
        $item_id = $post_data['item_id'];
        if(!$item_id) return view('home.404')->with(['error'=>'参数有误']);

        $mine = Doc_Item::find($item_id);
        if($mine)
        {
            if($mine->item_type == 11)
            {
                $item = Doc_Item::with([
                    'contents'=>function($query) { $query->orderBy('rank','asc'); }
                ])->find($item_id);
                $item->contents_recursion = $this->get_recursion($item->contents,0);
                return view(env('TEMPLATE_DOC_HOME').'entrance.item.item-edit-for-menu_type')->with(['data'=>$item]);
            }
            else if($mine->item_type == 18)
            {
                $item = Doc_Item::with([
                    'contents'=>function($query) {
                        $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as SIGNED) asc'));
                        $query->orderByRaw(DB::raw('cast(replace(trim(time_point)," ","") as DECIMAL) asc'));
                        $query->orderByRaw(DB::raw('replace(trim(time_point)," ","") asc'));
                        $query->orderBy('time_point','asc');
                    }
                ])->find($item_id);
                return view(env('TEMPLATE_DOC_HOME').'entrance.item.item-edit-for-time_line')->with(['data'=>$item]);
            }
        }
        else return view(env('TEMPLATE_DOC_HOME').'errors.404');
    }

    /*
     * 目录类型
     */
    // 返回列表数据
    public function view_item_content_menu_type($post_data)
    {
        $item_id = $post_data['id'];
        if(!$item_id) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = Doc_Item::with([
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

    // 返回列表数据
    public function view_item_content_time_line($post_data)
    {
        $item_id = $post_data['id'];
        if(!$item_id) return view('home.404')->with(['error'=>'参数有误']);
        // abort(404);

        $item = Doc_Item::with([
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




    // 返回添加视图
    public function view_item_content_create()
    {
        return view('home.content.menu');
    }
    // 返回编辑视图
    public function view_item_content_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id && intval($id) !== 0) return view('home.404')->with(['error'=>'参数有误']);

        if($decode_id == 0)
        {
            return view('home.content.menu')->with(['operate'=>'create', 'encode_id'=>$id]);
        }
        else
        {
            $data = Content::find($decode_id);
            if($data)
            {
                unset($data->id);
                return view('home.item.menu')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$data]);
            }
            else return view('home.404')->with(['error'=>'该内容不存在']);
        }
    }


    // 保存【目录类型】
    public function operate_item_content_save_for_menu_type($post_data)
    {
//        dd($post_data);
        $messages = [
            'content_id.required' => 'content_id.required',
            'title.required' => '请输入标题',
            'p_id.required' => '请选择目录',
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

//        $post_data["category"] = 11;
        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error();
        $item = Doc_Item::find($item_id);
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
                        $content = new Doc_Item;
                        $post_data["owner_id"] = $me->id;
                        $post_data["item_category"] = 1;
                        $post_data["item_type"] = 11;
                    }
                    elseif('edit') // 编辑
                    {
                        if($content_id == $post_data["p_id"]) return response_error([],"不能选择自己为父节点");

                        $content = Doc_Item::find($content_id);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试");
                        if($content->owner_id != $me->id) return response_error([],"你没有操作权限");
//                        if($content->type == 1) unset($post_data["type"]);

                        if($post_data["p_id"] != 0)
                        {
                            $is_child = true;
                            $p_id = $post_data["p_id"];
                            while($is_child)
                            {
                                $p = Doc_Item::find($p_id);
                                if(!$p) return response_error([],"参数有误，刷新页面重试");
                                if($p->p_id == 0) $is_child = false;
                                if($p->p_id == $content_id)
                                {
                                    $content_children = Doc_Item::where('p_id',$content_id)->get();
                                    $children_count = count($content_children);
                                    if($children_count)
                                    {
                                        $num = Doc_Item::where('p_id',$content_id)->update(['p_id'=>$content->p_id]);
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
                        $parent = Doc_Item::find($post_data["p_id"]);
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
            else response_error([],"该内容不是您的，您不能操作！");

        }
        else return response_error([],"该内容不存在");
    }
    // 保存【时间点】
    public function operate_item_content_save_for_time_line($post_data)
    {
        $messages = [
            'content_id.required' => 'content_id.required',
            'title.required' => '请输入标题',
            'time_point.required' => '请输入时间点',
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

//        $post_data["category"] = 18;
        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error();
        $item = Doc_Item::find($item_id);
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
                        $content = new Doc_Item;
                        $post_data["owner_id"] = $me->id;
                        $post_data["item_category"] = 1;
                        $post_data["item_type"] = 18;
                    }
                    elseif('edit') // 编辑
                    {
                        $content = Doc_Item::find($content_id);
                        if(!$content) return response_error([],"该内容不存在，刷新页面重试");
                        if($content->owner_id != $me->id) return response_error([],"你没有操作权限");
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
            else response_error([],"该内容不是您的，您不能操作！");

        }
        else return response_error([],"该内容不存在");
    }


    // 内容获取
    public function operate_item_content_get($post_data)
    {
        $user = Auth::user();
        $item_id = $post_data["item_id"];
        if(!$item_id) return response_error([],"该内容不存在，刷新页面试试");

        $content = Doc_Item::find($item_id);
        if($content->owner_id != $user->id) return response_error([],"你没有操作权限");
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
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(!$id) return response_error([],"该内容不存在，刷新页面试试");

        $content = Doc_Item::find($id);
        if($content->owner_id != $me->id) return response_error([],"你没有操作权限");

        DB::beginTransaction();
        try
        {
            $content_children = Doc_Item::where('p_id',$id)->get();
            $children_count = count($content_children);
            if($children_count)
            {
                $num = Doc_Item::where('p_id',$id)->update(['p_id'=>$content->p_id]);
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
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = Doc_Item::find($id);
        if($mine->owner_id != $me->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        DB::beginTransaction();
        try
        {
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
        $id = $post_data["id"];
//        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该文章不存在，刷新页面试试");

        $mine = Doc_Item::find($id);
        if($mine->owner_id != $me->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        DB::beginTransaction();
        try
        {
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








    // 【】流量统计
    public function view_statistic_index()
    {
        $me = Auth::guard('super')->user();
        $me_id = $me->id;

        $this_month = date('Y-m');
        $this_month_year = date('Y');
        $this_month_month = date('m');
        $last_month = date('Y-m',strtotime('last month'));
        $last_month_year = date('Y',strtotime('last month'));
        $last_month_month = date('m',strtotime('last month'));


        // 总访问量【统计】
        $all = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1])
            ->get();
        $all = $all->keyBy('day');

        // 首页访问量【统计】
        $rooted = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1,'page_type'=>1,'page_module'=>1])
            ->get();
        $rooted = $rooted->keyBy('day');

        // 介绍页访问量【统计】
        $introduction = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1,'page_type'=>1,'page_module'=>2])
            ->get();
        $introduction = $introduction->keyBy('day');




        // 打开设备类型【占比】
        $open_device_type = Def_Record::select('open_device_type',DB::raw('count(*) as count'))
            ->groupBy('open_device_type')
            ->where(['record_category'=>1,'record_type'=>1])
            ->get();
        foreach($open_device_type as $k => $v)
        {
            if($v->open_device_type == 0) $open_device_type[$k]->name = "默认";
            else if($v->open_device_type == 1) $open_device_type[$k]->name = "移动端";
            else if($v->open_device_type == 2)  $open_device_type[$k]->name = "PC端";
        }

        // 打开系统类型【占比】
        $open_system = Def_Record::select('open_system',DB::raw('count(*) as count'))
            ->groupBy('open_system')
            ->where(['record_category'=>1,'record_type'=>1])
            ->get();

        // 打开APP类型【占比】
        $open_app = Def_Record::select('open_app',DB::raw('count(*) as count'))
            ->groupBy('open_app')
            ->where(['record_category'=>1,'record_type'=>1])
            ->get();



        // 总分享【统计】
        $shared_all = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>2])
            ->get();
        $shared_all = $shared_all->keyBy('day');

        // 首页分享【统计】
        $shared_root = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>2])
            ->where(['page_type'=>1,'page_module'=>1])
            ->get();
        $shared_root = $shared_root->keyBy('day');




        // 总分享【占比】
        $shared_all_scale = Def_Record::select('record_module',DB::raw('count(*) as count'))
//            ->groupBy('shared_location')
            ->groupBy('record_module')
            ->where(['record_category'=>1,'record_type'=>2])
            ->get();
        foreach($shared_all_scale as $k => $v)
        {
//            if($v->shared_location == 1) $shared_all_scale[$k]->name = "微信好友";
//            else if($v->shared_location == 2) $shared_all_scale[$k]->name = "微信朋友圈";
//            else if($v->shared_location == 3) $shared_all_scale[$k]->name = "QQ好友";
//            else if($v->shared_location == 4) $shared_all_scale[$k]->name = "QQ空间";
//            else if($v->shared_location == 5) $shared_all_scale[$k]->name = "腾讯微博";
//            else $shared_all_scale[$k]->name = "其他";

            if($v->record_module == 1) $shared_all_scale[$k]->name = "微信好友|QQ好友";
            else if($v->record_module == 2) $shared_all_scale[$k]->name = "朋友圈|QQ空间";
            else $shared_all_scale[$k]->name = "其他";
        }

        // 首页分享【占比】
        $shared_root_scale = Def_Record::select('record_module',DB::raw('count(*) as count'))
//            ->groupBy('shared_location')
            ->groupBy('record_module')
            ->where(['record_category'=>1,'record_type'=>2])
            ->where(['page_type'=>1,'page_module'=>1])
            ->get();
        foreach($shared_root_scale as $k => $v)
        {
//            if($v->shared_location == 1) $shared_root_scale[$k]->name = "微信好友";
//            else if($v->shared_location == 2) $shared_root_scale[$k]->name = "微信朋友圈";
//            else if($v->shared_location == 3) $shared_root_scale[$k]->name = "QQ好友";
//            else if($v->shared_location == 4) $shared_root_scale[$k]->name = "QQ空间";
//            else if($v->shared_location == 5) $shared_root_scale[$k]->name = "腾讯微博";
//            else $shared_root_scale[$k]->name = "其他";

            if($v->record_module == 1) $shared_root_scale[$k]->name = "微信好友|QQ好友";
            else if($v->record_module == 2) $shared_root_scale[$k]->name = "朋友圈|QQ空间";
            else $shared_root_scale[$k]->name = "其他";
        }


        $view_data["all"] = $all;
        $view_data["rooted"] = $rooted;
        $view_data["introduction"] = $introduction;
        $view_data["open_device_type"] = $open_device_type;
        $view_data["open_app"] = $open_app;
        $view_data["open_system"] = $open_system;
        $view_data["shared_all"] = $shared_all;
        $view_data["shared_all_scale"] = $shared_all_scale;
        $view_data["shared_root"] = $shared_root;
        $view_data["shared_root_scale"] = $shared_root_scale;
        $view_data["sidebar_statistic_active"] = 'active';

        $view_blade = env('TEMPLATE_SUPER_ADMIN').'entrance.statistic.statistic-index';
        return view($view_blade)->with($view_data);
    }
    // 【】流量统计
    public function view_statistic_user($post_data)
    {
        $messages = [
            'id.required' => 'id required',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $user_id = $post_data["id"];
        $user = User::find($user_id);

        $this_month = date('Y-m');
        $this_month_year = date('Y');
        $this_month_month = date('m');
        $last_month = date('Y-m',strtotime('last month'));
        $last_month_year = date('Y',strtotime('last month'));
        $last_month_month = date('m',strtotime('last month'));


        // 总访问量【统计】
        $all = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('object_id',$user_id)
            ->get();
        $all = $all->keyBy('day');

        // 首页访问量【统计】
        $rooted = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1,'page_type'=>2,'page_module'=>1])
            ->where('object_id',$user_id)
            ->get();
        $rooted = $rooted->keyBy('day');

        // 介绍页访问量【统计】
        $introduction = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1,'page_type'=>2,'page_module'=>2])
            ->where('object_id',$user_id)
            ->get();
        $introduction = $introduction->keyBy('day');




        // 打开设备类型【占比】
        $open_device_type = Def_Record::select('open_device_type',DB::raw('count(*) as count'))
            ->groupBy('open_device_type')
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('object_id',$user_id)
            ->get();
        foreach($open_device_type as $k => $v)
        {
            if($v->open_device_type == 0) $open_device_type[$k]->name = "默认";
            else if($v->open_device_type == 1) $open_device_type[$k]->name = "移动端";
            else if($v->open_device_type == 2)  $open_device_type[$k]->name = "PC端";
        }

        // 打开系统类型【占比】
        $open_system = Def_Record::select('open_system',DB::raw('count(*) as count'))
            ->groupBy('open_system')
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('object_id',$user_id)
            ->get();

        // 打开APP类型【占比】
        $open_app = Def_Record::select('open_app',DB::raw('count(*) as count'))
            ->groupBy('open_app')
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('object_id',$user_id)
            ->get();




        // 总分享【统计】
        $shared_all = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>2])
            ->where('object_id',$user_id)
            ->get();
        $shared_all = $shared_all->keyBy('day');

        // 首页分享【统计】
        $shared_root = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>2,'page_type'=>2,'page_module'=>1])
            ->where('object_id',$user_id)
            ->get();
        $shared_root = $shared_root->keyBy('day');




        // 总分享【占比】
        $shared_all_scale = Def_Record::select('record_module',DB::raw('count(*) as count'))
            ->groupBy('record_module')
            ->where(['record_category'=>1,'record_type'=>2])
            ->where('object_id',$user_id)
            ->get();
        foreach($shared_all_scale as $k => $v)
        {
            if($v->record_module == 1) $shared_all_scale[$k]->name = "微信好友|QQ好友";
            else if($v->record_module == 2) $shared_all_scale[$k]->name = "朋友圈|QQ空间";
            else $shared_all_scale[$k]->name = "其他";
        }

        // 首页分享【占比】
        $shared_root_scale = Def_Record::select('record_module',DB::raw('count(*) as count'))
            ->groupBy('record_module')
            ->where(['record_category'=>1,'record_type'=>2])
            ->where(['page_type'=>1,'page_module'=>1])
            ->where('object_id',$user_id)
            ->get();
        foreach($shared_root_scale as $k => $v)
        {
            if($v->record_module == 1) $shared_all_scale[$k]->name = "微信好友|QQ好友";
            else if($v->record_module == 2) $shared_all_scale[$k]->name = "朋友圈|QQ空间";
            else $shared_all_scale[$k]->name = "其他";
        }


        $view_data["user"] = $user;
        $view_data["all"] = $all;
        $view_data["rooted"] = $rooted;
        $view_data["introduction"] = $introduction;
        $view_data["open_device_type"] = $open_device_type;
        $view_data["open_app"] = $open_app;
        $view_data["open_system"] = $open_system;
        $view_data["shared_all"] = $shared_all;
        $view_data["shared_root"] = $shared_root;
        $view_data["shared_all_scale"] = $shared_all_scale;
        $view_data["shared_root_scale"] = $shared_root_scale;

        $view_blade = env('TEMPLATE_SUPER_ADMIN').'entrance.statistic.statistic-user';
        return view($view_blade)->with($view_data);
    }
    // 【】流量统计
    public function view_statistic_item($post_data)
    {
        $messages = [
            'id.required' => 'id required',
        ];
        $v = Validator::make($post_data, [
            'id' => 'required',
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $item_id = $post_data["id"];
        $item = Def_Item::find($item_id);

        $this_month = date('Y-m');
        $this_month_year = date('Y');
        $this_month_month = date('m');
        $last_month = date('Y-m',strtotime('last month'));
        $last_month_year = date('Y',strtotime('last month'));
        $last_month_month = date('m',strtotime('last month'));


        // 访问量【统计】
        $data = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('item_id',$item_id)
            ->get();
        $data = $data->keyBy('day');




        // 打开设备类型【占比】
        $open_device_type = Def_Record::select('open_device_type',DB::raw('count(*) as count'))
            ->groupBy('open_device_type')
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('item_id',$item_id)
            ->get();
        foreach($open_device_type as $k => $v)
        {
            if($v->open_device_type == 0) $open_device_type[$k]->name = "默认";
            else if($v->open_device_type == 1) $open_device_type[$k]->name = "移动端";
            else if($v->open_device_type == 2)  $open_device_type[$k]->name = "PC端";
        }

        // 打开系统类型【占比】
        $open_system = Def_Record::select('open_system',DB::raw('count(*) as count'))
            ->groupBy('open_system')
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('item_id',$item_id)
            ->get();

        // 打开APP类型【占比】
        $open_app = Def_Record::select('open_app',DB::raw('count(*) as count'))
            ->groupBy('open_app')
            ->where(['record_category'=>1,'record_type'=>1])
            ->where('item_id',$item_id)
            ->get();




        // 分享【统计】
        $shared_data = Def_Record::select(
            DB::raw("DATE(FROM_UNIXTIME(created_at)) as date"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%Y-%m') as month"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%c') as month_0"),
            DB::raw("DATE_FORMAT(FROM_UNIXTIME(created_at),'%e') as day"),
            DB::raw('count(*) as count')
        )
            ->groupBy(DB::raw("DATE(FROM_UNIXTIME(created_at))"))
            ->whereYear(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_year)
            ->whereMonth(DB::raw("DATE(FROM_UNIXTIME(created_at))"),$this_month_month)
            ->where(['record_category'=>1,'record_type'=>2])
            ->where('item_id',$item_id)
            ->get();
        $shared_data = $shared_data->keyBy('day');


        // 分享【占比】
        $shared_data_scale = Def_Record::select('record_module',DB::raw('count(*) as count'))
            ->groupBy('record_module')
            ->where(['record_category'=>1,'record_type'=>2])
            ->where('item_id',$item_id)
            ->get();
        foreach($shared_data_scale as $k => $v)
        {
            if($v->record_module == 1) $shared_data_scale[$k]->name = "微信好友|QQ好友";
            else if($v->record_module == 2) $shared_data_scale[$k]->name = "朋友圈|QQ空间";
            else $shared_data_scale[$k]->name = "其他";
        }


        $view_data["item"] = $item;
        $view_data["data"] = $data;
        $view_data["open_device_type"] = $open_device_type;
        $view_data["open_app"] = $open_app;
        $view_data["open_system"] = $open_system;
        $view_data["shared_data"] = $shared_data;
        $view_data["shared_data_scale"] = $shared_data_scale;

        $view_blade = env('TEMPLATE_SUPER_ADMIN').'entrance.statistic.statistic-item';
        return view($view_blade)->with($view_data);
    }


    // 【K】【内容】【全部】返回-列表-视图
    public function view_statistic_all_list($post_data)
    {
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.statistic.statistic-all-list')
            ->with([
                'sidebar_statistic_all_list_active'=>'active'
            ]);
    }
    // 【K】【内容】【全部】返回-列表-数据
    public function get_statistic_all_datatable($post_data)
    {
        $me = Auth::guard("super")->user();
        $query = Def_Record::select('*')
            ->with(['creator','object','item']);

        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");

        if(!empty($post_data['open_device_type']))
        {
            if($post_data['open_device_type'] == "0")
            {
            }
            else if(in_array($post_data['open_system'],[1,2]))
            {
                $query->where('open_device_type',$post_data['open_device_type']);
            }
            else if($post_data['open_device_type'] == "Unknown")
            {
                $query->where('open_device_type',"Unknown");
            }
            else if($post_data['open_device_type'] == "Others")
            {
                $query->whereNotIn('open_device_type',[1,2]);
            }
            else
            {
                $query->where('open_device_type',$post_data['open_device_type']);
            }
        }
        else
        {
//            $query->whereIn('open_system',['Android','iPhone','iPad','Mac','Windows']);
        }

        if(!empty($post_data['open_system']))
        {
            if($post_data['open_system'] == "0")
            {
            }
            else if($post_data['open_system'] == "1")
            {
                $query->whereIn('open_system',['Android','iPhone','iPad','Mac','Windows']);
            }
            else if(in_array($post_data['open_system'],['Android','iPhone','iPad','Mac','Windows']))
            {
                $query->where('open_system',$post_data['open_system']);
            }
            else if($post_data['open_system'] == "Unknown")
            {
                $query->where('open_system',"Unknown");
            }
            else if($post_data['open_system'] == "Others")
            {
                $query->whereNotIn('open_system',['Android','iPhone','iPad','Mac','Windows']);
            }
            else
            {
                $query->where('open_system',$post_data['open_system']);
            }
        }
        else
        {
//            $query->whereIn('open_system',['Android','iPhone','iPad','Mac','Windows']);
        }

        if(!empty($post_data['open_browser']))
        {
            if($post_data['open_browser'] == "0")
            {
            }
            else if($post_data['open_browser'] == "1")
            {
                $query->whereIn('open_browser',['Chrome','Firefox','Safari']);
            }
            else if(in_array($post_data['open_browser'],['Chrome','Firefox','Safari']))
            {
                $query->where('open_browser',$post_data['open_browser']);
            }
            else if($post_data['open_browser'] == "Unknown")
            {
                $query->where('open_browser',"Unknown");
            }
            else if($post_data['open_browser'] == "Others")
            {
                $query->whereNotIn('open_browser',['Chrome','Firefox','Safari']);
            }
            else
            {
                $query->where('open_browser',$post_data['open_browser']);
            }
        }
        else
        {
//            $query->whereIn('open_browser',['Chrome','Firefox','Safari']);
        }

        if(!empty($post_data['open_app']))
        {
            if($post_data['open_app'] == "0")
            {
            }
            else if($post_data['open_app'] == "1")
            {
                $query->whereIn('open_app',['WeChat','QQ','Alipay']);
            }
            else if(in_array($post_data['open_app'],['WeChat','QQ','Alipay']))
            {
                $query->where('open_app',$post_data['open_app']);
            }
            else if($post_data['open_app'] == "Unknown")
            {
                $query->where('open_app',"Unknown");
            }
            else if($post_data['open_app'] == "Others")
            {
                $query->whereNotIn('open_app',['WeChat','QQ','Alipay']);
            }
            else
            {
                $query->where('open_app',$post_data['open_app']);
            }
        }
        else
        {
//            $query->whereIn('open_app',['WeChat','QQ']);
        }

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

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            $list[$k]->description = replace_blank($v->description);

            if($v->owner_id == $me->id) $list[$k]->is_me = 1;
            else $list[$k]->is_me = 0;
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }








    // 返回【机构】列表数据
    public function get_org_list_datatable($post_data)
    {
//        $query = Softorg::with(['administrators'])->withCount(['products', 'articles', 'activities', 'surveys']);
        $query = Softorg::with(['administrators']);
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
        else $query->orderBy("id", "asc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }

        return datatable_response($list, $draw, $total);
    }

    // 返回【目录】列表数据
    public function get_org_menu_list_datatable($post_data)
    {
//        $query = OrgMenu::with(['org'])->where('active', 1);
        $query = OrgMenu::with(['org']);
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

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回【产品】列表数据
    public function get_org_item_list_datatable($post_data)
    {
        $query = OrgItem::with(['org']);
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

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }












    //
    public function select2_menus($post_data)
    {
        $course_encode = $post_data['course_id'];
        $course_decode = decode($course_encode);
        if(!$course_decode) return view('home.404')->with(['error'=>'参数有误']);

        if(empty($post_data['keyword']))
        {
            $list =Content::select(['id','title as text'])->where('course_id', $course_decode)->get()->toArray();
        }
        else
        {
            $keyword = "%{$post_data['keyword']}%";
            $list =Content::select(['id','title as text'])->where('course_id', $course_decode)->where('name','like',"%$keyword%")->get()->toArray();
        }
        return $list;
    }




    // 层叠排列
    function get_tree($a,$pid=0)
    {
        $tree = array();
        //每次都声明一个新数组用来放子元素
        foreach($a as $v)
        {
            if($v->p_id == $pid)
            {
                //匹配子记录
                $v->children = $this->get_tree($a, $v->id); //递归获取子记录

                if($v->children == null)
                {
                    unset($v->children); //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                }
                $tree[] = $v; //将记录存入新数组
            }
        }
        return $tree; //返回新数组
    }
    // 层叠排列
    function get_tree_array($a,$pid=0)
    {
        $tree = array();
        //每次都声明一个新数组用来放子元素
        foreach($a as $v)
        {
            if($v['p_id'] == $pid)
            {
                //匹配子记录
                $v['children'] = $this->get_tree_array($a, $v['id']); //递归获取子记录

                if($v['children'] == null)
                {
                    unset($v['children']); //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                }
                $tree[] = $v; //将记录存入新数组
            }
        }
        return $tree; //返回新数组
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
    // 顺序排列
    function get_recursion_array($result, $parent_id=0, $level=0)
    {
        /*记录排序后的类别数组*/
        static $list = array();

        foreach ($result as $k => $v)
        {
            if($v['p_id'] == $parent_id)
            {
                $v['level'] = $level;

                foreach($list as $key=>$val)
                {
                    if($val['id'] == $parent_id) $list[$key]['has_child'] = 1;
                }

                /*将该类别的数据放入list中*/
                $list[] = $v;

                $this->get_recursion_array($result, $v['id'], $level+1);
            }
        }

        return $list;
    }



}