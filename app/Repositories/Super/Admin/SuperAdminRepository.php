<?php
namespace App\Repositories\Super\Admin;

use App\User;

use App\Models\Def\Def_Item;
use App\Models\Org\Org_Item;
use App\Models\Doc\Doc_Item;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode, Excel;

class SuperAdminRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->model = new User;
    }

    // 返回（后台）主页视图
    public function view_admin_index()
    {
        return view('super.admin.index');
    }




    /*
     * 用户基本信息
     */
    // 【基本信息】返回视图
    public function view_info_index()
    {
        $me = Auth::guard('admin')->user();
        return view(env('TEMPLATE_ADMIN').'admin.entrance.info.index')->with(['data'=>$me]);
    }

    // 【基本信息】返回-编辑-视图
    public function view_info_edit()
    {
        $me = Auth::guard('admin')->user();
        return view(env('TEMPLATE_ADMIN').'admin.entrance.info.edit')->with(['data'=>$me]);
    }
    // 【基本信息】保存数据
    public function operate_info_save($post_data)
    {
        $me = Auth::guard('admin')->user();

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
        $me = Auth::guard('admin')->user();
        return view(env('TEMPLATE_ADMIN').'admin.entrance.info.password-reset')->with(['data'=>$me]);
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








    // 【K】【用户】【全部机构】返回-列表-视图
    public function view_user_all_list($post_data)
    {
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.user.user-all-list')
            ->with(['sidebar_user_all_list_active'=>'active menu-open']);
    }
    // 【K】【用户】【全部机构】返回-列表-数据
    public function get_user_all_list_datatable($post_data)
    {
        $me = Auth::guard("user")->user();
        $query = User::select('*')->where(['user_category'=>1]);
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
        else $list = $query->skip($skip)->take($limit)->withTrashed()->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【K】【用户】【组织】返回-列表-视图
    public function view_user_org_list($post_data)
    {
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.user.user-org-list')
            ->with(['sidebar_user_org_list_active'=>'active menu-open']);
    }
    // 【K】【用户】【组织】返回-列表-数据
    public function get_user_org_list_datatable($post_data)
    {
        $me = Auth::guard("user")->user();
        $query = User::select('*')->where(['active'=>1,'user_category'=>1,'user_type'=>11]);

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
        else $list = $query->skip($skip)->take($limit)->withTrashed()->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【K】【用户】【赞助商】返回-列表-视图
    public function view_user_sponsor_list($post_data)
    {
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.user.user-sponsor-list')
            ->with(['sidebar_user_sponsor_list_active'=>'active menu-open']);
    }
    // 【用户】【赞助商】返回-列表-数据
    public function get_user_sponsor_list_datatable($post_data)
    {
        $me = Auth::guard("user")->user();
        $query = User::select('*')->where(['active'=>1,'user_category'=>1,'user_type'=>88]);

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
        else $list = $query->skip($skip)->take($limit)->withTrashed()->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
//        dd($list->toArray());
        return datatable_response($list, $draw, $total);
    }


    // 【K】【用户】【个人用户】返回-列表-视图
    public function view_user_individual_list($post_data)
    {
        return view(env('TEMPLATE_SUPER_ADMIN').'entrance.user.user-individual-list')
            ->with(['sidebar_user_individual_list_active'=>'active menu-open']);
    }
    // 【K】【用户】【个人用户】返回-列表-数据
    public function get_user_individual_list_datatable($post_data)
    {
        $me = Auth::guard("user")->user();
        $query = User::select('*')
            ->where(['active'=>1,'user_category'=>1,'user_type'=>1]);

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




    // 返回【编辑】视图
    public function org_login()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0)
        {
            return response("参数有误！", 404);
        }
        else
        {
            $org = OrgOrganization::with(['admin'])->find($decode_id);
            if($org)
            {
                $admin_id = $org->admin_id;
                $admin = OrgAdministrator::find($admin_id);
                Auth::guard('org_admin')->login($admin,true);
                return redirect('/org-admin/');
            }
            else return response("该机构不存在！", 404);
        }
    }




    // 返回【创建】视图
    public function view_org_create()
    {
        $admin = Auth::guard('super_admin')->user();
        return view('super.admin.org.edit')->with(['operate'=>'create', 'encode_id'=>encode(0)]);
    }

    // 返回【编辑】视图
    public function view_org_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0)
        {
            $org = OrgOrganization::with(['admin'])->find($decode_id);
            return view('super.admin.org.edit')->with(['operate'=>'create', 'encode_id'=>$id, 'org'=>$org]);
        }
        else
        {
            $org = OrgOrganization::with(['admin'])->find($decode_id);
            if($org)
            {
                unset($org->id);
                return view('super.admin.org.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$org]);
            }
            else return response("该机构不存在！", 404);
        }
    }

    // 创建
    public function org_save($post_data)
    {
        $super_admin = Auth::guard('super_admin')->user();

//        $messages = [
//            'type.required' => '请选择机构类型',
//            'type.numeric' => '请选择机构代码',
//            'captcha.required' => '请输入验证码',
//            'captcha.captcha' => '验证码有误',
//            'website_name.unique' => '企业域名已经存在，请更换一个名字',
//            'website_name.alpha' => '企业域名必须是英文字符',
//            'email.unique' => '管理员邮箱已存在，请更换邮箱',
//        ];
//        $v = Validator::make($post_data, [
//            'captcha' => 'required|captcha',
//            'type' => 'required|numeric',
//            'website_name' => 'required|alpha|unique:softorg',
//            'email' => 'required|email|unique:administrator',
//            'password' => 'required',
//            'password_confirm' => 'required'
//        ], $messages);
//        if ($v->fails())
//        {
//            $messages = $v->errors();
//            return response_error([],$messages->first());
//        }

        // 判断操作类型
        $operate = $post_data["operate"];
        $id = $post_data["id"];
        if($operate == 'create') // 添加 ( $id==0，添加一个新的机构 )
        {
            $organization = new OrgOrganization;
            $user = new User;
            $org_admin = new OrgAdministrator;
        }
        else if($operate == 'edit') // 编辑
        {
            $organization = OrgOrganization::find($id);
            if(!$organization) return response_error([],"该机构不存在，刷新页面重试");

            $user_id = $organization->user_id;
            $user = OrgOrganization::find($user_id);

            $admin_id = $organization->admin_id;
            $org_admin = OrgAdministrator::find($admin_id);
        }
        else return response_error([],"参数有误");

        DB::beginTransaction();
        try
        {

            $organization_data['name'] = $post_data["name"];
            $organization_data['short_name'] = $post_data["short_name"];
            $organization_data['slogan'] = $post_data["slogan"];
            $organization_data['description'] = $post_data["description"];
            $organization_data['address'] = $post_data["address"];
            $organization_data['telephone'] = $post_data["telephone"];
            $organization_data['mobile'] = $post_data["mobile"];
            $organization_data['email'] = $post_data["email"];
            $organization_data['qq'] = $post_data["qq"];
            $organization_data['wechat_id'] = $post_data["wechat_id"];
            $organization_data['weibo_name'] = $post_data["weibo_name"];
            $organization_data['weibo_address'] = $post_data["weibo_address"];

            $bool = $organization->fill($organization_data)->save();
            if($bool)
            {
                $organization_id = $organization->id;
                $organization_encode_id = encode($organization_id);
                // 【上传企业logo】
                if(!empty($post_data["logo"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["logo"], 'org-common' , 'org_'.$organization_encode_id.'_logo');
                    if($result["status"])
                    {
                        $organization->logo = $result["data"];
                        $organization->save();
                    }
                    else throw new Exception("upload--logo--FAIL");
                }
                else unset($post_data["logo"]);

                // 【上传微信二维码】
                if(!empty($post_data["wechat_qrcode"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["wechat_qrcode"], 'org-common' , 'org_'.$organization_encode_id.'_wechat_qrcode');
                    if($result["status"])
                    {
                        $organization->wechat_qrcode = $result["data"];
                        $organization->save();
                    }
                    else throw new Exception("upload--wechat_qrcode--FAIL");
                }
                else unset($post_data["wechat_qrcode"]);

                // 【保存】
                $url = 'http://softorg.cn/org/'.$organization_id;
                $qrcode_path = 'resource/org/common';
                if(!file_exists(storage_path($qrcode_path)))
                    mkdir(storage_path($qrcode_path), 0777, true);
                // 二维码图片文件
                $qrcode = $qrcode_path.'/org_'.$organization_encode_id.'_qrcode.png';
                QrCode::errorCorrection('H')->format('png')->size(480)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));



                // 【插入或更新用户表】
                if($operate == 'create')
                {
                    $user_data['name'] = $post_data["name"];
                    $user_data['org_id'] = $organization_id;

                    $bool_1 = $user->fill($user_data)->save();
                    if($bool_1)
                    {
                        $organization->user_id = $user->id;
                        $organization->save();
                    }
                    else throw new Exception("insert--user--FAIL");

                    $org_admin_data['nickname'] = $post_data["admin_nickname"];
                    $org_admin_data['mobile'] = $post_data["admin_mobile"];
                    $org_admin_data['password'] = password_encode('12345678');
                    $org_admin_data['org_id'] = $organization_id;

                    $bool_2 = $org_admin->fill($org_admin_data)->save();
                    if($bool_2)
                    {
                        $organization->admin_id = $org_admin->id;
                        $organization->save();
                    }
                    else throw new Exception("insert--org_admin--FAIL");
                }
                else if($operate == 'edit')
                {
                    $user->name = $post_data["name"];
                    $user->save();

                    $org_admin->nickname = $post_data["admin_nickname"];
                    $org_admin->mobile = $post_data["admin_mobile"];
                    $org_admin->save();
                }

            }
            else throw new Exception("insert--organization--FAIL");

            DB::commit();
            return response_success();

        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '注册失败！';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([], $msg);
        }

    }




    // 返回【产品】列表数据
    public function get_product_list_datatable($post_data)
    {
        $query = Product::with(['org'])->where('active', 1);
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

    // 返回【文章】列表数据
    public function get_article_list_datatable($post_data)
    {
        $query = Article::with(['org'])->where('active', 1);
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

    // 返回【活动】列表数据
    public function get_activity_list_datatable($post_data)
    {
        $query = Activity::with(['org'])->where('active', 1);
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

    // 返回【问卷】列表数据
    public function get_survey_list_datatable($post_data)
    {
        $query = Survey::with(['org'])->where('active', 1);
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









}