<?php
namespace App\Repositories\Super;

use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgOrganizationExt;
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
        $query = Softorg::with(['administrators'])->withCount(['products', 'articles', 'activities', 'surveys']);
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




    // 返回【添加】视图
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

    // 保存企业信息
    public function org_save($post_data)
    {
        $admin = Auth::guard('super_admin')->user();
        $org_id = $admin->org_id;
        $org = OrgOrganization::find($org_id);

        if(!empty($post_data["logo"]))
        {
            $upload = new CommonRepository();
            $result = $upload->create($post_data["logo"], 'org-'. $admin->id . '-common-logo');
            if($result["status"]) $post_data["logo"] = $result["data"];
            else return response_fail();
        }
        else unset($post_data["logo"]);

        if(!empty($post_data["wechat_qrcode"]))
        {
            $upload = new CommonRepository();
            $result = $upload->create($post_data["wechat_qrcode"], 'org-'. $admin->id . '-common-wechat_qrcode');
            if($result["status"]) $post_data["wechat_qrcode"] = $result["data"];
            else return response_fail();
        }
        else unset($post_data["wechat_qrcode"]);

        // 目标URL
        $url = 'http://softorg.cn/org/'.$admin->website_name;
        // 保存位置
        $qrcode_path = 'resource/org/'.$admin->id.'/unique/common';
        if(!file_exists(storage_path($qrcode_path)))
            mkdir(storage_path($qrcode_path), 0777, true);
        // qrcode图片文件
        $qrcode = $qrcode_path.'/qrcode.png';
        QrCode::errorCorrection('H')->format('png')->size(320)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));

        $bool = $org->fill($post_data)->save();
        if($bool)
        {
            $name = $qrcode_path.'/qrcode_img.png';
            $common = new CommonRepository();
            $logo = 'resource/'.$org->logo;
//            $common->create_root_qrcode($name, $org->name, $qrcode, $logo);

            return response_success();
        }
        else return response_fail();
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