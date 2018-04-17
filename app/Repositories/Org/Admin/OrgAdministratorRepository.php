<?php
namespace App\Repositories\Org\Admin;

use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgOrganizationExt;
use App\Models\Org\OrgAdministrator;
use App\Models\Org\OrgMenu;
use App\Models\Org\OrgItem;

use App\Models\Softorg;
use App\Models\SoftorgExt;
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
use App\Repositories\Admin\MailRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class OrgAdministratorRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgOrganization;
    }

    // 返回（后台）主页视图
    public function view_index()
    {
        $admin = Auth::guard('org_admin')->user();
        $me = $admin;

        return view('org.admin.administrator.index')->with(['me'=>$me]);
    }

    // 返回（后台）企业信息编辑视图
    public function view_edit()
    {
        $admin = Auth::guard('org_admin')->user();
        $me = $admin;

        return view('org.admin.administrator.edit')->with(['me'=>$me]);
    }
    // 保存企业信息
    public function save($post_data)
    {
        $admin = Auth::guard('org_admin')->user();

        if(!empty($post_data["portrait_img"]))
        {
            $upload = new CommonRepository();
            $result = $upload->create($post_data["portrait_img"], 'org-'. $admin->id . '-common-admin_'. $admin->id);
            if($result["status"]) $post_data["portrait_img"] = $result["data"];
            else return response_fail();
        }
        else unset($post_data["portrait_img"]);

        $bool = $admin->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }



    // 显示 编辑自定义首页
    public function view_edit_home()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.home')->with('data', $ext);
    }
    // 显示 编辑自定义信息
    public function view_edit_information()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.information')->with('data', $ext);
    }
    // 显示 编辑简介
    public function view_edit_introduction()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.introduction')->with('data', $ext);
    }
    // 显示 编辑联系我们
    public function view_edit_contactus()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.contactus')->with('data', $ext);
    }
    // 显示 编辑企业文化
    public function view_edit_culture()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.culture')->with('data', $ext);
    }

    // 编辑ext
    public function save_ext($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $website = SoftorgExt::where('org_id', $org_id)->first();
        if($website)
        {
            $type = $post_data['type'];
            $content = $post_data['content'];
            $editor[$type] = $content;
            $bool = $website->fill($editor)->save();
            if($bool) return response_success([], '修改成功');
            else return response_fail([], '修改失败，刷新页面重试');
        }
        else return response_error();
    }






}