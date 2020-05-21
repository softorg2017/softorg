<?php
namespace App\Repositories\Super;

use App\Models\User;

use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgOrganizationExt;
use App\Models\Org\OrgAdministrator;
use App\Models\Org\OrgMenu;
use App\Models\Org\OrgItem;
use App\Models\Org\OrgRecord;

use App\Models\Softorg;
use App\Models\Record;
use App\Models\Website;

use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use App\Models\Apply;
use App\Models\Sign;
use App\Models\Answer;
use App\Models\Choice;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class SuperRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Softorg;
    }

    // 返回（后台）主页视图
    public function view_admin_index()
    {
        return view('super.admin.index');
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