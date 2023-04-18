<?php
namespace App\Http\Controllers\LW\Atom\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Doc\Doc_Item;
use App\Models\Doc\Doc_Pivot_Item_Relation;

use App\Repositories\Atom\Front\AtomIndexRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class AtomIndexController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new AtomIndexRepository;
    }

    /*
     * 登录 & 退出
     */
    // 登陆
    public function login()
    {
        if(request()->isMethod('get'))
        {
            return view(env('TEMPLATE_STAFF_FRONT').'entrance.login');
        }
        else if(request()->isMethod('post'))
        {
            $where['email'] = request()->get('email');
            $where['mobile'] = request()->get('mobile');
            $where['password'] = request()->get('password');

//            $email = request()->get('email');
//            $admin = OrgAdministrator::whereEmail($email)->first();

            $mobile = request()->get('mobile');
            $user = User::withTrashed()->whereMobile($mobile)->first();

            if($user)
            {
                if($user->deleted_at == null)
                {
                    if($user->active == 1)
                    {
                        $password = request()->get('password');
                        if(password_check($password,$user->password))
                        {
                            $remember = request()->get('remember');
                            if($remember) Auth::guard('staff')->login($user,true);
                            else Auth::guard('staff')->login($user,true);
                            return response_success();
                        }
                        else return response_error([],'账户or密码不正确！');
                    }
                    else return response_error([],'账户尚未激活，请先去邮箱激活！');
                }
                else return response_error([],'账户已删除！');
            }
            else return response_error([],'账户不存在！');
        }
    }

    // 退出
    public function logout()
    {
        Auth::guard('staff')->logout();
        return redirect('/login');
    }




    /*
     * 首页
     */
	public function view_root()
	{
        return $this->repo->view_root(request()->all());
	}

    public function dataTableI18n()
    {
    	return trans('pagination.i18n');
    }





    // 【K】【基本信息】返回
    public function view_my_info_index()
    {
        return $this->repo->view_my_info_index();
    }
    // 【K】【基本信息】编辑
    public function operate_my_info_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_info_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_my_info_save(request()->all());
    }

    // 【K】【基本信息】编辑
    public function operate_my_info_password_reset()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_info_password_reset();
        else if (request()->isMethod('post')) return $this->repo->operate_my_info_password_reset_save(request()->all());
    }



    /*
     * 员工管理
     */
    // 【员工】添加
    public function operate_user_staff_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_staff_create();
        else if (request()->isMethod('post')) return $this->repo->operate_user_staff_save(request()->all());
    }
    // 【员工】编辑
    public function operate_user_staff_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_staff_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_user_staff_save(request()->all());
    }


    // 【员工】返回-列表-视图
    public function view_user_staff_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_staff_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_staff_list_datatable(request()->all());
    }

    // 【员工】获取-详情
    public function operate_user_staff_get()
    {
        return $this->repo->operate_user_staff_get(request()->all());
    }
    // 【员工】删除
    public function operate_user_staff_delete()
    {
        return $this->repo->operate_user_staff_delete(request()->all());
    }
    // 【员工】恢复
    public function operate_user_staff_restore()
    {
        return $this->repo->operate_user_staff_restore(request()->all());
    }
    // 【员工】永久删除
    public function operate_user_staff_delete_permanently()
    {
        return $this->repo->operate_user_staff_delete_permanently(request()->all());
    }




    /*
     * 任务管理
     */
    // 【任务】添加
    public function operate_item_task_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_task_create();
        else if (request()->isMethod('post')) return $this->repo->operate_item_task_save(request()->all());
    }
    // 【任务】编辑
    public function operate_item_task_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_task_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_task_save(request()->all());
    }

    // 【任务】获取-详情
    public function operate_item_task_get()
    {
        return $this->repo->operate_item_task_get(request()->all());
    }
    // 【任务】删除
    public function operate_item_task_delete()
    {
        return $this->repo->operate_item_task_delete(request()->all());
    }
    // 【任务】恢复
    public function operate_item_task_restore()
    {
        return $this->repo->operate_item_task_restore(request()->all());
    }
    // 【任务】永久删除
    public function operate_item_task_delete_permanently()
    {
        return $this->repo->operate_item_task_delete_permanently(request()->all());
    }
    // 【任务】发布
    public function operate_item_task_publish()
    {
        return $this->repo->operate_item_task_publish(request()->all());
    }
    // 【任务】完成
    public function operate_item_task_complete()
    {
        return $this->repo->operate_item_task_complete(request()->all());
    }
    // 【任务】禁用
    public function operate_item_task_disable()
    {
        return $this->repo->operate_item_admin_disable(request()->all());
    }
    // 【任务】启用
    public function operate_item_task_enable()
    {
        return $this->repo->operate_item_admin_enable(request()->all());
    }

    // 【任务】备注编辑
    public function operate_item_task_remark_edit()
    {
        return $this->repo->operate_item_task_remark_save(request()->all());
    }











    // 返回【主页】视图
    public function operate_item_select2_people()
    {
        return $this->repo->operate_item_select2_people(request()->all());
    }


    // 【内容】返回-列表-视图
    public function view_item_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_datatable(request()->all());
    }
    // 【内容】返回-全部内容-列表-视图
    public function view_item_list_for_all()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_all(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_all_datatable(request()->all());
    }
    // 【内容】返回-列表-视图
    public function view_item_list_for_people()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_people(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_people_datatable(request()->all());
    }
    // 【内容】返回-列表-视图
    public function view_item_list_for_object()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_object(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_object_datatable(request()->all());
    }
    // 【内容】返回-列表-视图
    public function view_item_list_for_product()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_product(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_product_datatable(request()->all());
    }

    // 【内容】返回-全部内容-列表-视图
    public function view_item_list_for_event()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_event(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_event_datatable(request()->all());
    }

    // 【内容】返回-全部内容-列表-视图
    public function view_item_list_for_conception()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_list_for_conception(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_list_for_conception_datatable(request()->all());
    }






}

