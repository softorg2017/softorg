<?php
namespace App\Repositories\Atom\Front;

use App\User;
use App\Models\Doc\Doc_Item;
use App\Models\Doc\Doc_Pivot_Item_Relation;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class AtomIndexRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->model = new User;
        $this->view_template_front = env('TEMPLATE_ATOM_FRONT');
    }


    // 返回（后台）主页视图
    public function view_root($post_data)
    {
        $me = Auth::guard("admin")->user();
        $item_query = Doc_Item::select('*')->withTrashed()
            ->with(['owner','creator'])
            ->where('owner_id','>=',1)
            ->where(['owner_id'=>100,'item_category'=>100])
            ->where('item_type','!=',0);

        $menu_active = 'sidebar_menu_root_active';

        $type = !empty($post_data['type']) ? $post_data['type'] : 'root';
        if($type == 'root')
        {
            $head_title_prefix = "首页";
            $sidebar_active = 'sidebar_menu_for_root_active';
            $page["module"] = 1;
        }
        else if($type == 'object')
        {
            $item_query->where('item_type',1);

            $head_title_prefix = "物";
            $sidebar_active = 'sidebar_menu_for_object_active';
            $page["module"] = 9;
        }
        else if($type == 'people')
        {
            $item_query->where('item_type',11);

            $head_title_prefix = "人";
            $sidebar_active = 'sidebar_menu_for_people_active';
            $page["module"] = 11;
        }
        else if($type == 'product')
        {
            $item_query->where('item_type',22);

            $head_title_prefix = "作品";
            $sidebar_active = 'sidebar_menu_for_product_active';
            $page["module"] = 11;
        }
        else if($type == 'event')
        {
            $item_query->where('item_type',33);

            $head_title_prefix = "事件";
            $sidebar_active = 'sidebar_menu_for_event_active';
            $page["module"] = 11;
        }
        else if($type == 'conception')
        {
            $item_query->where('item_type',91);

            $head_title_prefix = "概念";
            $sidebar_active = 'sidebar_menu_for_conception_active';
            $page["module"] = 11;
        }
        else
        {
            $head_title_prefix = "首页";
            $sidebar_active = 'sidebar_menu_for_root_active';
            $page["module"] = 1;
        }

        $item_list = $item_query->orderByDesc('published_at')->orderByDesc('updated_at')->paginate(20);
        foreach ($item_list as $item)
        {
            $item->custom = json_decode($item->custom);
        }

        $head_title_postfix = ' - 原子系统';
        $return['head_title'] = $head_title_prefix.$head_title_postfix;
        $return[$sidebar_active] = 'active';
        $return[$menu_active] = 'active';
        $return['item_list'] = $item_list;
        return view(env('TEMPLATE_ATOM_FRONT').'entrance.root')
            ->with($return);
    }




    /*
     * 用户基本信息
     */
    // 【基本信息】返回视图
    public function view_my_info_index()
    {
        $me = Auth::guard('staff')->user();
        $view_template = env('TEMPLATE_ATOM_FRONT');
        $view_blade = $view_template.'entrance.my-info.my-info-index';
        return view($view_blade)->with(['info'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_my_info_edit()
    {
        $me = Auth::guard('staff')->user();
        $view_template = env('TEMPLATE_ATOM_FRONT');
        $view_blade = $view_template.'entrance.my-info.my-info-edit';
        return view($view_blade)->with(['info'=>$me]);
    }
    // 【基本信息】保存数据
    public function operate_my_info_save($post_data)
    {
        $me = Auth::guard('staff')->user();

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

                    $result = upload_img_storage($post_data["portrait"],'user_'.$me->id,'staff/unique/portrait/','assign');
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
    public function view_my_info_password_reset()
    {
        $me = Auth::guard('staff')->user();
        $view_template = env('TEMPLATE_ATOM_FRONT');
        $view_blade = $view_template.'entrance.my-info.my-info-password-reset';
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
     * 用户管理
     */
    // 【用户】【组织】返回-添加-视图
    public function view_user_staff_create()
    {
        $view_template = env('TEMPLATE_ATOM_FRONT');
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
        $view_template = env('TEMPLATE_ATOM_FRONT');
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
//                if(!in_array($mine->user_type,[11,88])) return view(env('TEMPLATE_ATOM_FRONT').'errors.404');
                $mine->custom = json_decode($mine->custom);
                $mine->custom2 = json_decode($mine->custom2);
                $mine->custom3 = json_decode($mine->custom3);

                $return['operate'] = 'edit';
                $return['data'] = $mine;
            }
            else return view($view_template.'errors.404');
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
        return view(env('TEMPLATE_ATOM_FRONT').'entrance.user.staff-list')->with($return);
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
        $view_template = env('TEMPLATE_ATOM_FRONT');
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
        $view_template = env('TEMPLATE_ATOM_FRONT');
        $view_blade = $view_template.'entrance.item.task-edit';

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return view($view_template.'errors.403');

        $item_id = request("item-id",0);
        $mine = YF_Item::with([])->withTrashed()->find($item_id);
        if(!$mine) return view($view_template.'errors.404');
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


    // 【任务】获取详情
    public function operate_item_task_get($post_data)
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
    // 【任务】删除
    public function operate_item_task_delete($post_data)
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
        if($operate != 'item-delete') return response_error([],"参数operate有误！");
        $item_id = $post_data["item_id"];
        if(intval($item_id) !== 0 && !$item_id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($item_id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");
        if($me->user_type == 19 && ($item->item_active != 0 || $item->creator_id != $me->id)) return response_error([],"你没有操作权限！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->timestamps = false;
            if($me->user_type == 19 && $item->item_active == 0 && $item->creator_id != $me->id)
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
    public function operate_item_task_restore($post_data)
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
        if($operate != 'item-restore') return response_error([],"参数operate有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11])) return response_error([],"用户类型错误！");
//        if($item->creator_id != $me->id) return response_error([],"你没有操作权限！");

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
    public function operate_item_task_delete_permanently($post_data)
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
        if($operate != 'item-delete-permanently') return response_error([],"参数operate有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19])) return response_error([],"用户类型错误！");
        if($me->user_type == 19 && ($item->item_active != 0 || $item->creator_id != $me->id)) return response_error([],"你没有操作权限！");

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
    public function operate_item_task_publish($post_data)
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
        if($operate != 'item-publish') return response_error([],"参数operate有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if($item->creator_id != $me->id) return response_error([],"你没有操作权限！");

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
    public function operate_item_task_complete($post_data)
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
        if($operate != 'item-complete') return response_error([],"参数operate有误！");
        $id = $post_data["item_id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = YF_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('staff')->user();
        if(!in_array($me->user_type,[0,1,9,11,19,41])) return response_error([],"用户类型错误！");

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
            $item_html = view(env('TEMPLATE_ATOM_FRONT').'component.item-list')->with($return)->__toString();
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
        $item_html = view(env('TEMPLATE_ATOM_FRONT').'component.user-list')->with($return)->__toString();
//        // method B
//        $item_html = view(env('TEMPLATE_ATOM_FRONT').'component.item-list')->with($return)->render();
//        // method C
//        $view = view(env('TEMPLATE_ATOM_FRONT').'component.item-list')->with($return);
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
        $item_html = view(env('TEMPLATE_ATOM_FRONT').'component.item-list')->with($return)->__toString();
//        // method B
//        $item_html = view(env('TEMPLATE_ATOM_FRONT').'component.item-list')->with($return)->render();
//        // method C
//        $view = view(env('TEMPLATE_ATOM_FRONT').'component.item-list')->with($return);
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





}