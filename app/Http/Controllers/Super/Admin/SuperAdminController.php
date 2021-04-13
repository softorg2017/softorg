<?php
namespace App\Http\Controllers\Super\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Doc\Doc_Item;

use App\Repositories\Super\Admin\SuperAdminRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class SuperAdminController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new SuperAdminRepository;
    }



    // 返回主页视图
    public function index()
    {
        return $this->repo->view_admin_index();
    }


    // 【用户】登录
    public function operate_user_user_login()
    {
        $user_id = request()->get('id');
        $user = User::where('id',$user_id)->first();
        if($user)
        {
            Auth::login($user,true);

            $type = request()->get('type','');
            if($type == "atom")
            {
                Auth::guard('atom')->login($user,true);
                return redirect(env('DOMAIN_ATOM').'/admin');
            }
            else
            {
//                if($user->user_type == 8)
//                {
//                    Auth::guard('atom')->login($user,true);
//
//                }
//                else if($user->user_type == 11)
//                {
//                    Auth::guard('org')->login($user,true);
//                }
//                else if($user->user_type == 88)
//                {
//                    Auth::guard('sponsor')->login($user,true);
//                }
//
//                $return['user'] = $user;
//                return response_success($return);
            }
        }
        else return response_error([]);

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
