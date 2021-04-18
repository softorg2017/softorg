<?php
namespace App\Repositories\Atom\Admin;

use App\User;
use App\Models\Doc\Doc_Item;
use App\Models\Doc\Doc_Pivot_Item_Relation;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class AtomAdminRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->model = new User;
    }

    // 返回（后台）主页视图
    public function view_atom_index()
    {
        $me = Auth::guard("atom")->user();

        return view(env('TEMPLATE_ATOM_ADMIN').'index')
            ->with([
                'index_data'=>[],
                'consumption_data'=>[],
                'insufficient_clients'=>[]
            ]);
    }




    /*
     * 用户基本信息
     */
    // 【基本信息】返回视图
    public function view_info_index()
    {
        $me = Auth::guard('atom')->user();
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.info.index')->with(['data'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_info_edit()
    {
        $me = Auth::guard('atom')->user();
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.info.edit')->with(['data'=>$me]);
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
                if(!empty($post_data["portrait_img"]))
                {
                    // 删除原文件
                    $mine_original_file = $me->portrait_img;
                    if(!empty($mine_original_file) && file_exists(storage_path("resource/" . $mine_original_file)))
                    {
                        unlink(storage_path("resource/" . $mine_original_file));
                    }

                    $result = upload_file_storage($post_data["attachment"]);
                    if($result["result"])
                    {
                        $me->portrait_img = $result["local"];
                        $me->save();
                    }
                    else throw new Exception("upload-portrait-img-file-fail");
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
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.info.password-reset')->with(['data'=>$me]);
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
    public function operate_business_select2_user($post_data)
    {
        $me = Auth::guard('atom')->user();
        if(empty($post_data['keyword']))
        {
            $list =Doc_User::select(['id','username as text'])
                ->where(['userstatus'=>'正常','status'=>1])
                ->whereIn('usergroup',['Agent','Agent2'])
                ->orderBy('id','desc')
                ->get()
                ->toArray();
        }
        else
        {
            $keyword = "%{$post_data['keyword']}%";
            $list =Doc_User::select(['id','username as text'])
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








    // 【用户】【全部机构】返回-列表-视图
    public function view_user_all_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.user.user-all-list')
            ->with(['sidebar_user_all_list_active'=>'active menu-open']);
    }
    // 【用户】【全部机构】返回-列表-数据
    public function get_user_all_list_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = Doc_User::select('*')->where(['user_category'=>1]);
//            ->whereHas('fund', function ($query1) { $query1->where('totalfunds', '>=', 1000); } )
//            ->with('ep','parent','fund')
//            ->withCount([
//                'members'=>function ($query) { $query->where('usergroup','Agent2'); },
//                'fans'=>function ($query) { $query->where('usergroup','Service'); }
//            ]);
//            ->where(['userstatus'=>'正常','status'=>1])
//            ->whereIn('usergroup',['Agent','Agent2']);

        if(!empty($post_data['username'])) $query->where('username', 'like', "%{$post_data['username']}%");

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 40;

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
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }



    //
    public function operate_item_select2_people($post_data)
    {
        $query = Doc_Item::select(['id','name as text'])->where(['item_category'=>0,'item_type'=>11]);
        if(!empty($post_data['keyword']))
        {
            $keyword = "%{$post_data['keyword']}%";
            $query->where('name','like',"%$keyword%");
        }
        $list = $query->get()->toArray();
        return $list;
    }


    // 【内容】返回-列表-视图
    public function view_item_item_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-list')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_item_list_active'=>'active'
            ]);
    }
    // 【内容】返回-列表-数据
    public function get_item_item_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = Doc_Item::select('*')
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
    public function view_item_all_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-all-list')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_all_list_active'=>'active'
            ]);
    }
    // 【内容】【全部】返回-列表-数据
    public function get_item_all_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where('owner_id','>=',1)
            ->where('item_category',0)
            ->where('item_type','!=',0);

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
        else $query->orderBy("id", "desc");

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
    public function view_item_object_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-object-list')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_object_list_active'=>'active'
            ]);
    }
    // 【内容】【活动】返回-列表-数据
    public function get_item_object_datatable($post_data)
    {
        $me = Auth::guard("admin")->user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where(['item_category'=>0,'item_type'=>1]);

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
        else $query->orderBy("id", "desc");

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
    public function view_item_people_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-people-list')
            ->with([
                'sidebar_item_people'=>'active',
                'sidebar_item_people_list_active'=>'active'
            ]);
    }
    // 【内容】【文章】返回-列表-数据
    public function get_item_people_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where(['item_category'=>0,'item_type'=>11]);

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
        else $query->orderBy("id", "desc");

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
    public function view_item_product_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-product-list')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_product_list_active'=>'active'
            ]);
    }
    // 【内容】【广告】返回-列表-数据
    public function get_item_product_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with([
                'owner',
                'pivot_product_people'=>function ($query) { $query->where('relation_type',1); }
            ])
            ->where(['item_category'=>0,'item_type'=>22]);

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
        else $query->orderBy("id", "desc");

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
    public function view_item_event_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-event-list')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_event_list_active'=>'active'
            ]);
    }
    // 【内容】【广告】返回-列表-数据
    public function get_item_event_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where(['item_category'=>0,'item_type'=>33]);

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
        else $query->orderBy("id", "desc");

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
    public function view_item_conception_list($post_data)
    {
        return view(env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-conception-list')
            ->with([
                'sidebar_item_active'=>'active',
                'sidebar_item_conception_list_active'=>'active'
            ]);
    }
    // 【内容】【广告】返回-列表-数据
    public function get_item_conception_datatable($post_data)
    {
        $me = Auth::guard("atom")->user();
        $query = Doc_Item::select('*')->withTrashed()
            ->with('owner')
            ->where(['item_category'=>0,'item_type'=>9]);

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
        else $query->orderBy("id", "desc");

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




    // 【ITEM】返回-添加-视图
    public function view_item_item_create($post_data)
    {
        $type = request('type','');
        if(!in_array($type,["people","object","product","event","conception"])) return view(env('TEMPLATE_ATOM_ADMIN').'errors.404');

        $me = Auth::guard('atom')->user();
//        if(!in_array($me->user_type,[0,1])) return view(env('TEMPLATE_ATOM_ADMIN').'errors.404');

        $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';
        $item_type = 'item';
        $item_type = $type;

        if($type == "object")
        {
            $item_type_text = '物';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-object-edit';
        }
        else if($type == "people")
        {
            $item_type_text = '人';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-people-edit';
        }
        else if($type == "product")
        {
            $item_type_text = '作品';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-product-edit';
        }
        else if($type == "event")
        {
            $item_type_text = '事件';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-event-edit';
        }
        else if($type == "conception")
        {
            $item_type_text = '概念';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-conception-edit';
        }
        else
        {
            $item_type_text = '内容';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';
        }
        $title_text = '添加'.$item_type_text;
        $list_text = $item_type_text;
        $list_link = '/atom/item/item-'.$item_type.'-list';

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
//        if(!in_array($me->user_type,[0,1])) return view(env('TEMPLATE_ATOM_ADMIN').'errors.404');

        $id = $post_data["id"];
        $mine = Doc_Item::with([
                'owner',
                'pivot_product_people'=>function ($query) { $query->where('relation_type',1); }
            ])->find($id);
        if(!$mine) return view(env('TEMPLATE_ATOM_ADMIN').'errors.404');
//        dd($mine->toArray());


        $item_type = 'item';
        $item_type_text = '内容';
        $title_text = '编辑'.$item_type_text;
        $list_text = $item_type_text.'列表';
        $list_link = '/admin/item/item-list';
        $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';

        if($mine->item_type == 0)
        {
            $item_type = 'item';
            $item_type_text = '内容';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-all-list';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-edit';
        }
        else if($mine->item_type == 1)
        {
            $item_type = 'object';
            $item_type_text = '物';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-article-list';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-object-edit';
        }
        else if($mine->item_type == 11)
        {
            $item_type = 'people';
            $item_type_text = '人';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-people-list';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-people-edit';
        }
        else if($mine->item_type == 22)
        {
            $item_type = 'product';
            $item_type_text = '作品';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-product-list';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-product-edit';
        }
        else if($mine->item_type == 33)
        {
            $item_type = 'event';
            $item_type_text = '事件';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-event-list';
            $view_blade = env('TEMPLATE_ATOM_ADMIN').'entrance.item.item-event-edit';
        }
        else if($mine->item_type == 9)
        {
            $item_type = 'conception';
            $item_type_text = '概念';
            $title_text = '编辑'.$item_type_text;
            $list_text = $item_type_text.'列表';
            $list_link = '/admin/item/item-conception-list';
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
//        dd(0);
        $messages = [
            'operate.required' => '参数有误',
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
        if(!in_array($me->user_type,[0,1])) return response_error([],"你没有操作权限！");


        $operate = $post_data["operate"];
        $operate_id = $post_data["operate_id"];
        $type = $post_data["type"];

        if($operate == 'create') // 添加 ( $id==0，添加一个内容 )
        {
            $mine = new Doc_Item;
            $post_data["owner_id"] = $me->id;
            $post_data["item_category"] = 0;
            $post_data["owner_id"] = 100;
            $post_data["creator_id"] = $me->id;
            if($type == 'object') $post_data["item_type"] = 1;
            else if($type == 'people') $post_data["item_type"] = 11;
            else if($type == 'product') $post_data["item_type"] = 22;
            else if($type == 'event') $post_data["item_type"] = 33;
            else if($type == 'conception') $post_data["item_type"] = 9;
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = Doc_Item::find($operate_id);
            if(!$mine) return response_error([],"该内容不存在，刷新页面重试！");
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

                    $result = upload_storage($post_data["cover"]);
                    if($result["result"])
                    {
                        $mine->cover_pic = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--cover--fail");

//                    $upload = new CommonRepository();
//                    $result = $upload->upload($post_data["cover"], 'outside-unique-items' , 'cover_item_'.$encode_id);
//                    if($result["status"])
//                    {
//                        $mine->cover_pic = $result["data"];
//                        $mine->save();
//                    }
//                    else throw new Exception("upload-cover-fail");
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

                    $result = upload_file_storage($post_data["attachment"]);
                    if($result["result"])
                    {
                        $mine->attachment_name = $result["name"];
                        $mine->attachment_src = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload--attachment--fail");
                }

                // 生成二维码
                $qr_code_path = "resource/unique/qr_code/";  // 保存目录
                if(!file_exists(storage_path($qr_code_path)))
                    mkdir(storage_path($qr_code_path), 0777, true);
                // qr_code 图片文件
                $url = env('DOMAIN_WWW').'/item/'.$mine->id;  // 目标 URL
                $filename = 'qr_code_item_'.$mine->id.'.png';  // 目标 file
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
        if($operate != 'item-get') return response_error([],"参数有误！");
        $id = $post_data["id"];
        if(intval($id) !== 0 && !$id) return response_error([],"参数ID有误！");

        $item = Doc_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

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

        $item = Doc_Item::withTrashed()->find($id);
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


            $bool = $item->delete();
            if(!$bool) throw new Exception("delete--item--fail");

            DB::commit();


            // 删除原封面图片
//            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
//            {
//                unlink(storage_path("resource/" . $mine_cover_pic));
//            }
//
//            // 删除原附件
//            if(!empty($mine_attachment_src) && file_exists(storage_path("resource/" . $mine_attachment_src)))
//            {
//                unlink(storage_path("resource/" . $mine_attachment_src));
//            }
//
//            // 删除二维码
//            if(file_exists(storage_path("resource/unique/qr_code/".'qr_code_item_'.$id.'.png')))
//            {
//                unlink(storage_path("resource/unique/qr_code/".'qr_code_item_'.$id.'.png'));
//            }
//
//            // 删除UEditor图片
//            $img_tags = get_html_img($mine_content);
//            foreach ($img_tags[2] as $img)
//            {
//                if (!empty($img) && file_exists(public_path($img)))
//                {
//                    unlink(public_path($img));
//                }
//            }


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

        $item = Doc_Item::withTrashed()->find($id);
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

        $item = Doc_Item::withTrashed()->find($id);
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

        $item = Doc_Item::withTrashed()->find($id);
        if(!$item) return response_error([],"该内容不存在，刷新页面重试！");

        $me = Auth::guard('atom')->user();
        if($item->owner_id != $me->id) return response_error([],"你没有操作权限！");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $item->active = 1;
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

        $item = Doc_Item::find($id);
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

        $item = Doc_Item::find($id);
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





}