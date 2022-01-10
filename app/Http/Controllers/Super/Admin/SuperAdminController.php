<?php
namespace App\Http\Controllers\Super\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Def\Def_User;
use App\Models\Def\Def_Item;

use App\Models\Doc\Doc_Item;

use App\Repositories\Super\Admin\SuperAdminRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class SuperAdminController extends Controller
{
    //
    private $evn;
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new SuperAdminRepository;

        if(explode('.',request()->route()->getAction()['domain'])[0] == 'test')
        {
            $this->env = 'test';
        }
        else
        {
            $this->env = 'production';
        }
    }



    // 返回主页视图
    public function index()
    {
        return $this->repo->view_admin_index();
    }


    /*
     * 用户基本信息
     */
    // 【基本信息】返回-视图
    public function view_info_index()
    {
        return $this->repo->view_info_index();
    }
    // 【基本信息】编辑
    public function operate_info_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_info_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_info_save(request()->all());
    }
    // 【基本信息】修改-密码
    public function operate_info_password_reset()
    {
        if(request()->isMethod('get')) return $this->repo->view_info_password_reset();
        else if (request()->isMethod('post')) return $this->repo->operate_info_password_reset_save(request()->all());
    }




    /*
     * 用户系统
     */
    // 【用户】SELECT2 District
    public function operate_user_select2_district()
    {
        return $this->repo->operate_user_select2_district(request()->all());
    }

    // 【用户】添加
    public function operate_user_user_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_user_create();
        else if (request()->isMethod('post')) return $this->repo->operate_user_user_save(request()->all());
    }
    // 【用户】编辑
    public function operate_user_user_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_user_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_user_user_save(request()->all());
    }


    // 【用户】修改-密码
    public function operate_user_change_password()
    {
        return $this->repo->operate_user_change_password(request()->all());
    }


    // 【用户】登录
    public function operate_user_user_login()
    {
        $user_id = request()->get('user_id');
        $user = User::where('id',$user_id)->first();
        if($user)
        {

            $type = request()->get('type','');
            if($type == "gps")
            {
                $admin_id = request()->get('admin_id');
                $admin = User::where('id',$admin_id)->first();

                Auth::guard('gps')->login($user,true);
                Auth::guard('gps_admin')->login($admin,true);

                if(request()->isMethod('get')) return redirect(env('DOMAIN_GPS').'/admin');
                else if(request()->isMethod('post')) return response_success();

            }
            else if($type == "atom")
            {
                $admin_id = request()->get('admin_id');
                $admin = User::where('id',$admin_id)->first();

                Auth::guard('atom')->login($user,true);
                Auth::guard('atom_admin')->login($admin,true);

                if(request()->isMethod('get')) return redirect(env('DOMAIN_ATOM').'/admin');
                else if(request()->isMethod('post')) return response_success();
            }
            else if($type == "doc")
            {
                $admin_id = request()->get('admin_id');
                $admin = User::where('id',$admin_id)->first();

                Auth::guard('doc')->login($user,true);
                Auth::guard('doc_admin')->login($admin,true);

                if(request()->isMethod('get')) return redirect(env('DOMAIN_DOC').'/home');
                else if(request()->isMethod('post')) return response_success();
            }
            else
            {
                $return['user'] = $user;
                $return['env'] = '';

                if($this->env == 'test')
                {
                    $return['env'] = 'test';
                    Auth::guard('test')->login($user,true);
                    if(request()->isMethod('get')) return redirect(env('DOMAIN_TEST_DEFAULT'));
                    else if(request()->isMethod('post')) return response_success($return);
                }
                else
                {
                    Auth::login($user,true);
                    if(request()->isMethod('get')) return redirect(env('DOMAIN_DEFAULT'));
                    else if(request()->isMethod('post')) return response_success($return);
                }

//                if(request()->isMethod('get')) return redirect(env('DOMAIN_DEFAULT'));
//                else if(request()->isMethod('post')) return response_success($return);
            }
        }
        else return response_error([]);

    }


    // 【用户】【全部用户】返回-列表-视图
    public function view_user_list_for_all()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_list_for_all(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_list_for_all_datatable(request()->all());
    }
    // 【用户】【个人用户】返回-列表-视图
    public function view_user_list_for_individual()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_list_for_individual(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_list_for_individual_datatable(request()->all());
    }
    // 【用户】【轻博】返回-列表-视图
    public function view_user_list_for_doc()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_list_for_doc(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_list_for_doc_datatable(request()->all());
    }
    // 【用户】【组织】返回-列表-视图
    public function view_user_list_for_org()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_list_for_org(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_list_for_org_datatable(request()->all());
    }








    /*
     * ITEM 内容
     */
    // 【内容】【全部】返回-列表-视图
    public function view_item_list_for_all()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_all(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_all_datatable(request()->all());
    }
    // 【内容】【原子】返回-列表-视图
    public function view_item_list_for_atom()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_atom(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_atom_datatable(request()->all());
    }
    // 【内容】【轻博】返回-列表-视图
    public function view_item_list_for_doc()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_doc(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_doc_datatable(request()->all());
    }








    /*
     * District 地域管理
     */
    // 【地域】添加
    public function operate_district_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_district_create();
        else if (request()->isMethod('post')) return $this->repo->operate_district_save(request()->all());
    }
    // 【地域】编辑
    public function operate_district_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_district_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_district_save(request()->all());
    }

    // 【地域】【全部】返回-列表-视图
    public function view_district_list_for_all()
    {
        if(request()->isMethod('get')) return $this->repo->view_district_list_for_all(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_district_list_for_all_datatable(request()->all());
    }

    // 【地域】SELECT2
    public function operate_district_select2_parent()
    {
        return $this->repo->operate_district_select2_parent(request()->all());
    }








    /*
     * Statistic 统计
     */
    // 【统计】概览
    public function view_statistic_index()
    {
        return $this->repo->view_statistic_index();
    }
    // 【统计】用户
    public function view_statistic_user()
    {
        return $this->repo->view_statistic_user(request()->all());
    }
    // 【统计】内容
    public function view_statistic_item()
    {
        return $this->repo->view_statistic_item(request()->all());
    }
    // 【K】【内容】返回-全部内容-列表-视图
    public function view_statistic_all_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_statistic_all_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_statistic_all_datatable(request()->all());
    }








    // 【机构】列表
    public function view_org_list()
    {
        if(request()->isMethod('get')) return view('super.admin.org.org-list');
        else if(request()->isMethod('post')) return $this->repo->get_org_list_datatable(request()->all());
    }


    public function createAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_org_create();
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_org_edit();
        else if (request()->isMethod('post')) return $this->repo->org_save(request()->all());
    }




    // 【目录】列表
    public function view_org_menu_list()
    {
        if(request()->isMethod('get')) return view('super.admin.org.menu-list');
        else if(request()->isMethod('post')) return $this->repo->get_org_menu_list_datatable(request()->all());
    }

    // 【内容】列表
    public function view_org_item_list()
    {
        if(request()->isMethod('get')) return view('super.admin.org.item-list');
        else if(request()->isMethod('post')) return $this->repo->get_org_item_list_datatable(request()->all());
    }




    // 产品列表
    public function view_product_list()
    {
        if(request()->isMethod('get')) return view('super.admin.list.product');
        else if(request()->isMethod('post')) return $this->repo->get_product_list_datatable(request()->all());
    }

    // 文章列表
    public function view_article_list()
    {
        if(request()->isMethod('get')) return view('super.admin.list.article');
        else if(request()->isMethod('post')) return $this->repo->get_article_list_datatable(request()->all());
    }

    // 活动列表
    public function view_activity_list()
    {
        if(request()->isMethod('get')) return view('super.admin.list.activity');
        else if(request()->isMethod('post')) return $this->repo->get_activity_list_datatable(request()->all());
    }

    // 问卷列表
    public function view_survey_list()
    {
        if(request()->isMethod('get')) return view('super.admin.list.survey');
        else if(request()->isMethod('post')) return $this->repo->get_survey_list_datatable(request()->all());
    }



}
