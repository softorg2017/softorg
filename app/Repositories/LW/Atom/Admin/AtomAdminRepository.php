<?php
namespace App\Repositories\LW\Atom\Admin;

use App\User;
use App\Models\Atom\Atom_Item;
use App\Models\Atom\Atom_Pivot_Item_Relation;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache, Blade, Carbon;
use QrCode, Excel;

class AtomAdminRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->modelUser = new YH_User;
        $this->modelItem = new Atom_Item;

        $this->view_blade_404 = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.errors.404';

        Blade::setEchoFormat('%s');
        Blade::setEchoFormat('e(%s)');
        Blade::setEchoFormat('nl2br(e(%s))');
    }


    // 登录情况
    public function get_me()
    {
        if(Auth::guard("atom")->check())
        {
            $this->auth_check = 1;
            $this->me = Auth::guard("atom")->user();
            view()->share('me',$this->me);
        }
        else $this->auth_check = 0;

        view()->share('auth_check',$this->auth_check);
    }


    // 返回（后台）主页视图
    public function view_admin_index()
    {
        $me = Auth::guard("atom")->user();
        $me_admin = Auth::guard("atom_admin")->user();

        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'index';
        $view_return['menu_active_of_index'] = 'active menu-open';
        $view_return['page_type'] = 'index';
        return view($view_blade)->with($view_return);
    }




    /*
     * 用户基本信息
     */
    // 【基本信息】返回视图
    public function view_info_index()
    {
        $me = Auth::guard('atom')->user();
        return view(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.info.index')->with(['data'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_info_edit()
    {
        $me = Auth::guard('atom')->user();
        return view(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.info.edit')->with(['data'=>$me]);
    }
    // 【基本信息】保存数据
    public function operate_info_save($post_data)
    {
        $me = Auth::guard('atom')->user();

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

                    $result = upload_img_storage($post_data["portrait"],'user_'.$me->id,'doc/unique/portrait/');
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
        $me = Auth::guard('atom')->user();
        return view(env('LW_TEMPLATE_ATOM_ADMIN').'entrance.info.password-reset')->with(['data'=>$me]);
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
            $me = Auth::guard('atom')->user();
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

        $me = Auth::guard('atom')->user();
        if($me->user_type != 0) return response_error([],"你没有操作权限");

        $password = $post_data["user-password"];
        $confirm = $post_data["user-password-confirm"];
        if($password != $confirm) return response_error([],"两次密码不一致！");

//        if(!password_is_legal($password)) ;
        $pattern = '/^[a-zA-Z0-9]{1}[a-zA-Z0-9]{5,19}$/i';
        if(!preg_match($pattern,$password)) return response_error([],"密码格式不正确！");


        $user = Doc_User::find($id);
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
        $query = Atom_Item::select(['id','name as text'])->where(['item_category'=>100,'item_type'=>11]);
        if(!empty($post_data['keyword']))
        {
            $keyword = "%{$post_data['keyword']}%";
            $query->where('name','like',"%$keyword%");
        }
        $list = $query->get()->toArray();
        return $list;
    }



    /*
     * Item
     */
    // 【ITEM】返回-添加-视图
    public function view_item_item_create($post_data)
    {
        $type = request('type','');
        if(!in_array($type,["people","object","product","event","conception"])) return view(env('LW_TEMPLATE_ATOM_ADMIN').'errors.404');

        $me = Auth::guard('atom')->user();
//        if(!in_array($me->user_type,[0,1])) return view(env('LW_TEMPLATE_ATOM_ADMIN').'errors.404');

        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';
        $item_type = 'item';
        $item_type = $type;

        if($type == "all")
        {
            $item_type_text = '内容';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-all';
        }
        else if($type == "object")
        {
            $item_type_text = '物';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-object';
        }
        else if($type == "people")
        {
            $item_type_text = '人';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-people';
        }
        else if($type == "product")
        {
            $item_type_text = '作品';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-product';
        }
        else if($type == "event")
        {
            $item_type_text = '事件';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-event';
        }
        else if($type == "conception")
        {
            $item_type_text = '概念';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-conception';
        }
        else
        {
            $item_type_text = '内容';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';
        }
        $title_text = '添加'.$item_type_text;
        $list_text = $item_type_text;
        $list_link = '/atom/item/item-list-for-'.$item_type;

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
        $me = Auth::guard('atom')->user();
//        if(!in_array($me->user_type,[0,1])) return view(env('LW_TEMPLATE_ATOM_ADMIN').'errors.404');

        $id = $post_data["id"];
        $mine = Atom_Item::with([
                'owner',
                'pivot_product_people'=>function ($query) { $query->where('relation_type',1); }
            ])->find($id);
        if(!$mine) return view(env('LW_TEMPLATE_ATOM_ADMIN').'errors.404');
//        dd($mine->toArray());


        $item_type = 'item';
        $item_type_text = '内容';
        $title_text = '编辑'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/admin/item/item-list';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';

        if($mine->item_type == 0)
        {
            $item_type = 'item';
            $item_type_text = '内容';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-all-list';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';
        }
        else if($mine->item_type == 1)
        {
            $item_type = 'object';
            $item_type_text = '物';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-list-for-object';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-object';
        }
        else if($mine->item_type == 11)
        {
            $item_type = 'people';
            $item_type_text = '人';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-list-for-people';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-people';
        }
        else if($mine->item_type == 22)
        {
            $item_type = 'product';
            $item_type_text = '作品';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-list-for-product';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-product';
        }
        else if($mine->item_type == 33)
        {
            $item_type = 'event';
            $item_type_text = '事件';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-list-for-event';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-event';
        }
        else if($mine->item_type == 91)
        {
            $item_type = 'conception';
            $item_type_text = '概念';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-list-for-conception';
            $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit-for-conception';
        }


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

        $me = Auth::guard('atom')->user();
        $me_admin = Auth::guard('atom_admin')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return response_error([],"用户类型错误！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];
        $type = $post_data["type"];

        if($operate == 'create') // 添加 ( $id==0，添加一个内容 )
        {
            $mine = new Atom_Item;
            $post_data["item_category"] = 100;
            $post_data["owner_id"] = 100;
            $post_data["creator_id"] = $me_admin->id;
            if($type == 'object') $post_data["item_type"] = 1;
            else if($type == 'people') $post_data["item_type"] = 11;
            else if($type == 'product') $post_data["item_type"] = 22;
            else if($type == 'event') $post_data["item_type"] = 33;
            else if($type == 'conception') $post_data["item_type"] = 91;
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = Atom_Item::find($operate_id);
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
                // 插入中间表
//                if(!empty($post_data["people_id"]))
//                {
//                    $mine->pivot_product_people()->attach($post_data["people_id"]);
//                }
                if(!empty($post_data["peoples"]))
                {
//                    $product->peoples()->attach($post_data["peoples"]);
                    $current_time = time();
                    $peoples = $post_data["peoples"];
                    foreach($peoples as $p)
                    {
//                        $people_insert[$p] = ['relation_type'=>1];
                        $people_insert[$p] = ['relation_type'=>1,'created_at'=>$current_time,'updated_at'=>$current_time];
                    }
                    $mine->pivot_product_people()->sync($people_insert);
//                    $mine->pivot_product_people()->syncWithoutDetaching($people_insert);
                }
                else
                {
                    $mine->pivot_product_people()->detach();
                }

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
                $qr_code_path = "resource/atom/unique/qr_code/";  // 保存目录
                if(!file_exists(storage_path($qr_code_path)))
                    mkdir(storage_path($qr_code_path), 0777, true);
                // qr_code 图片文件
                $url = env('DOMAIN_WWW').'/item/'.$mine->id;  // 目标 URL
                $filename = 'qr_code_atom_item_'.$mine->id.'.png';  // 目标 file
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




    // 【ITEM】获取详情
    public function operate_item_item_get($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
            'id.required' => 'id.required.',
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
        if($operate != 'item-get') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Atom_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");
        else
        {
            if(@getimagesize(env('LW_DOMAIN_CDN').'/'.$item->cover_pic))
            {
                $cover_url = url(env('LW_DOMAIN_CDN').'/'.$item->cover_pic);
                $item->cover_img = '<img src="'.$cover_url.'" alt="" />"';
            }
            else $item->cover_img = '';
        }

        $me = Auth::guard('atom')->user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");

        return response_success($item,"");

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

        $item = Atom_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");
        $me_admin = Auth::guard('atom_admin')->user();
        if($me->id != $me_admin->id)
        {
            if($item->creator_id != $me_admin->id) return response_error([],"你没有操作权限！");
        }

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
    // 【ITEM】恢复
    public function operate_item_item_restore($post_data)
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
        if($operate != 'item-restore') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Atom_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $bool = $item->restore();
            if(!$bool) throw new Exception("delete--restore--fail");

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
    // 【ITEM】彻底删除
    public function operate_item_item_delete_permanently($post_data)
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
        if($operate != 'item-delete-permanently') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Atom_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
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


            $bool = $item->forceDelete();
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
            if(file_exists(storage_path("resource/unique/qr_code/".'qr_code_item_'.$id.'.png')))
            {
                unlink(storage_path("resource/unique/qr_code/".'qr_code_item_'.$id.'.png'));
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
    // 【ITEM】推送
    public function operate_item_item_publish($post_data)
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
        if($operate != 'item-publish') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Atom_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->is_published = 1;
            $item->published_at = time();
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




    // 【ITEM】禁用
    public function operate_item_item_disable($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
            'id.required' => 'id.required.',
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
        if($operate != 'item-disable') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Atom_Item::find($id);
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
    // 【ITEM】启用
    public function operate_item_item_enable($post_data)
    {
        $messages = [
            'operate.required' => 'operate.required.',
            'id.required' => 'id.required.',
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
        if($operate != 'item-enable') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Atom_Item::find($id);
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




    // 【内容】返回-列表-视图
    public function view_item_list($post_data)
    {
        $return['menu_active_of_item_list'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list';
        return view($view_blade)->with($return);
    }
    // 【内容】返回-列表-数据
    public function get_item_list_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = Atom_Item::select('*')
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
        $return['page_type'] = 'list';
        $return['menu_active_of_item_list_for_all'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-all';
        return view($view_blade)->with($return);
    }
    // 【内容】【全部】返回-列表-数据
    public function get_item_list_for_all_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = Atom_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where('owner_id','>=',1)
            ->where(['owner_id'=>100,'item_category'=>100])
            ->where('item_type','!=',0);


        $atom_type  = isset($post_data['atom-type'])  ? $post_data['atom-type']  : "all";
        if($atom_type == 'object') $query->where('item_type',1);
        else if($atom_type == 'people')
        {
            $query->where('item_type',11);

            $query->addSelect(DB::raw('cast(birth_time as DECIMAL) as t'));
            $query->addSelect(DB::raw('cast(birth_time as DATE) as tt'));
            $query->addSelect(DB::raw('FROM_UNIXTIME(UNIX_TIMESTAMP(cast(birth_time as DATE))) as ttt'));
        }
        else if($atom_type == 'product')
        {
            $query->where('item_type',22);
            $query ->with([
                    'pivot_product_people'=>function ($query) { $query->where('relation_type',1); }
                ]);
        }
        else if($atom_type == 'event') $query->where('item_type',33);
        else if($atom_type == 'conception') $query->where('item_type',91);



        // 类型
        if(isset($post_data['type']))
        {
            if(!in_array($post_data['type'],[0,-1]))
            {
                $query->where('item_type', $post_data['type']);
            }
        }


        if(!empty($post_data['name'])) $query->where('name', 'like', "%{$post_data['name']}%");
        if(!empty($post_data['title'])) $query->where('title', 'like', "%{$post_data['title']}%");
        if(!empty($post_data['tag'])) $query->where('tag', 'like', "%{$post_data['tag']}%");
        if(!empty($post_data['major'])) $query->where('major', 'like', "%{$post_data['major']}%");
        if(!empty($post_data['nation'])) $query->where('nation', 'like', "%{$post_data['nation']}%");

        if(!empty($post_data['select_classified']))
        {
            $select_classified = $post_data['select_classified'];
            if(!in_array($select_classified,['-1','0']))
            {
                $query->where(function ($query) use ($select_classified) {
                    $query->where('tag', 'like', "%{$select_classified}%")
                        ->orWhere('major', 'like', "%{$select_classified}%");
                });
            }
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
            if($field == "birth_time") $query->orderByRaw(DB::raw('cast(birth_time as SIGNED) '.$order_dir));
            else if($field == "death_time") $query->orderByRaw(DB::raw('cast(death_time as SIGNED) '.$order_dir));
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("id", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
//            $list[$k]->description = replace_blank($v->description);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【内容】【物】返回-列表-视图
    public function view_item_list_for_object($post_data)
    {
        $return['page_type'] = 'list';
        $return['menu_active_of_item_list_for_object'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-object';
        return view($view_blade)->with($return);
    }
    // 【内容】【人】返回-列表-视图
    public function view_item_list_for_people($post_data)
    {
        $return['page_type'] = 'list';
        $return['menu_active_of_item_list_for_people'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-people';
        return view($view_blade)->with($return);
    }
    // 【内容】【作品】返回-列表-视图
    public function view_item_list_for_product($post_data)
    {
        $return['page_type'] = 'list';
        $return['menu_active_of_item_list_for_product'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-product';
        return view($view_blade)->with($return);
    }
    // 【内容】【事件】返回-列表-视图
    public function view_item_list_for_event($post_data)
    {
        $return['page_type'] = 'list';
        $return['menu_active_of_item_list_for_event'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-event';
        return view($view_blade)->with($return);
    }
    // 【内容】【概念】返回-列表-视图
    public function view_item_list_for_conception($post_data)
    {
        $return['page_type'] = 'list';
        $return['menu_active_of_item_list_for_conception'] = 'active';
        $view_blade = env('LW_TEMPLATE_ATOM_ADMIN').'entrance.item.item-list-for-conception';
        return view($view_blade)->with($return);
    }




    // 【内容管理】【文本】修改-文本-类型
    public function operate_item_text_set($post_data)
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
        if($operate != 'item-text-set') return response_error([],"参数[operate]有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数[ID]有误！");

        $item = Atom_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该【内容】不存在，刷新页面重试！");

        $this->get_me();
        $me = $this->me;
//        if($item->owner_id != $me->id) return response_error([],"该内容不是你的，你不能操作！");

        $operate_type = $post_data["operate_type"];
        $column_key = $post_data["column_key"];
        $column_value = $post_data["column_value"];

        $before = $item->$column_key;


        if(!in_array($me->user_type,[0,1,11,81,82,88])) return response_error([],"你没有操作权限！");


        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->$column_key = $column_value;
            $bool = $item->save();
            if(!$bool) throw new Exception("item--update--fail");
            else
            {
                // 需要记录(本人修改已发布 || 他人修改)
                if($me->id == $item->creator_id && $item->is_published == 0 && false)
                {
                }
                else
                {
//                    $record = new YH_Record;
//
//                    $record_data["record_object"] = 21;
//                    $record_data["record_category"] = 11;
//                    $record_data["record_type"] = 1;
//                    $record_data["creator_id"] = $me->id;
//                    $record_data["order_id"] = $id;
//                    $record_data["operate_object"] = 71;
//                    $record_data["operate_category"] = 1;
//
//                    if($operate_type == "add") $record_data["operate_type"] = 1;
//                    else if($operate_type == "edit") $record_data["operate_type"] = 11;
//
//                    $record_data["column_name"] = $column_key;
//                    $record_data["before"] = $before;
//                    $record_data["after"] = $column_value;
//
//                    $bool_1 = $record->fill($record_data)->save();
//                    if($bool_1)
//                    {
//                    }
//                    else throw new Exception("insert--record--fail");
                }
            }

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


}