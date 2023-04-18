<?php
namespace App\Http\Controllers\LW\Doc\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Doc\Doc_Item;
use App\Models\Doc\Doc_Pivot_Item_Relation;

use App\Repositories\LW\Doc\Front\DocIndexRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class DocIndexController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new DocIndexRepository;
    }

    public function dataTableI18n()
    {
        return trans('pagination.i18n');
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
        Auth::guard('doc')->logout();
        Auth::guard('doc_admin')->logout();
        return redirect('/');
    }




    /*
     * 首页
     */
	public function view_root()
	{
        return $this->repo->view_root(request()->all());
	}




    // 【基本信息】返回
    public function view_my_info_index()
    {
        return $this->repo->view_my_info_index();
    }
    // 【基本信息】编辑
    public function operate_my_info_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_info_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_my_info_save(request()->all());
    }

    // 【基本信息】修改密码
    public function operate_my_info_password_reset()
    {
        if(request()->isMethod('get')) return $this->repo->view_my_info_password_reset();
        else if (request()->isMethod('post')) return $this->repo->operate_my_info_password_reset_save(request()->all());
    }



	/*
	 *
	 */
    // 【ITEM】添加
    public function operate_item_item_create()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_create(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_item_item_save(request()->all());
    }
    // 【ITEM】编辑
    public function operate_item_item_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_edit(request()->all());
        else if (request()->isMethod('post')) return $this->repo->operate_item_item_save(request()->all());
    }

    // 【ITEM】获取-详情
    public function operate_item_item_get()
    {
        return $this->repo->operate_item_item_get(request()->all());
    }
    // 【ITEM】删除
    public function operate_item_item_delete()
    {
        return $this->repo->operate_item_item_delete(request()->all());
    }
    // 【ITEM】恢复
    public function operate_item_item_restore()
    {
        return $this->repo->operate_item_item_restore(request()->all());
    }
    // 【ITEM】永久删除
    public function operate_item_item_delete_permanently()
    {
        return $this->repo->operate_item_item_delete_permanently(request()->all());
    }
    // 【ITEM】发布
    public function operate_item_item_publish()
    {
        return $this->repo->operate_item_item_publish(request()->all());
    }
    // 【ITEM】完成
    public function operate_item_item_complete()
    {
        return $this->repo->operate_item_item_complete(request()->all());
    }
    // 【ITEM】禁用
    public function operate_item_item_disable()
    {
        return $this->repo->operate_item_admin_disable(request()->all());
    }
    // 【ITEM】启用
    public function operate_item_item_enable()
    {
        return $this->repo->operate_item_admin_enable(request()->all());
    }




    // 【ITEM-Content】内容管理
    public function view_item_content_management()
    {
        return $this->repo->view_item_content_management(request()->all());
    }

    // 【ITEM-Content】编辑
    public function operate_item_content_edit()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post'))
        {
            $item_type  = request('item_type',0);
            $item_type_name  = request('item-type','');
            if($item_type == 11 && $item_type_name == 'menu_type')
            {
                return $this->repo->operate_item_content_save_for_menu_type(request()->all());
            }
            else if($item_type == 18 && $item_type_name == 'time_line')
            {
                return $this->repo->operate_item_content_save_for_time_line(request()->all());
            }
            else
            {
                return $this->repo->operate_item_content_save(request()->all());
            }
        }
    }

    // 【ITEM-Content】目录类型
    public function operate_item_content_edit_menu_type()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_content_save_for_menu_type(request()->all());
    }
    // 【ITEM-Content】时间线
    public function operate_item_content_edit_time_line()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_content_save_for_time_line(request()->all());
    }


    // 【ITEM-content】移动位置
    public function operate_item_content_move_menu_type()
    {
        return $this->repo->operate_item_content_move_menu_type(request()->all());
    }
    // 【ITEM-content】移动位置
    public function operate_item_content_move_time_line()
    {
        return $this->repo->operate_item_content_move_time_line(request()->all());
    }


    // 【ITEM-Content】获取
    public function operate_item_content_get()
    {
        return $this->repo->operate_item_content_get(request()->all());
    }
    // 【ITEM-Content】删除
    public function operate_item_content_delete()
    {
        return $this->repo->operate_item_content_delete(request()->all());
    }
    // 【ITEM-Content】发布
    public function operate_item_content_publish()
    {
        return $this->repo->operate_item_content_publish(request()->all());
    }
    // 【ITEM-Content】启用
    public function operate_item_content_enable()
    {
        return $this->repo->operate_item_content_enable(request()->all());
    }
    // 【ITEM-Content】禁用
    public function operate_item_content_disable()
    {
        return $this->repo->operate_item_content_disable(request()->all());
    }








    /*
     * 列表
     */
    // 【我的】
    public function view_item_list_for_mine()
    {
        return $this->repo->view_item_list_for_mine(request()->all());
    }
    // 【我的原创】
    public function view_home_mine_original()
    {
        return $this->repo->view_item_list_for_my_original(request()->all());
    }

    // 【我的待办事】
    public function view_item_list_for_my_todo_list()
    {
        return $this->repo->view_item_list_for_my_todo_list(request()->all());
    }
    // 【我的日程】
    public function view_item_list_for_my_schedule()
    {
        return $this->repo->view_item_list_for_my_schedule(request()->all());
    }
    // 【点赞内容】
    public function view_item_list_for_my_favor()
    {
        return $this->repo->view_item_list_for_my_favor(request()->all());
    }
    // 【收藏内容】
    public function view_item_list_for_my_collection()
    {
        return $this->repo->view_item_list_for_my_collection(request()->all());
    }
    // 【发现】
    public function view_home_mine_discovery()
    {
        return $this->repo->view_item_list_for_my_discovery(request()->all());
    }
    // 【我的关注】
    public function view_home_mine_follow()
    {
        return $this->repo->view_item_list_for_my_follow(request()->all());
    }
    // 【我的好友圈】
    public function view_home_mine_circle()
    {
        return $this->repo->view_item_list_for_my_circle(request()->all());
    }




    // 【内容详情】
    public function view_item($id=0)
    {
        return $this->repo->view_item(request()->all(),$id);
    }
    // 【内容详情】
//    public function view_item()
//    {
//        return $this->repo->view_item(request()->all());
//    }






    // 【点赞】
    public function operate_item_add_favor()
    {
        return $this->repo->operate_item_add_this(request()->all(),11);
    }
    public function operate_item_remove_favor()
    {
        return $this->repo->operate_item_remove_this(request()->all(),11);
    }
    // 【收藏】
    public function operate_item_add_collection()
    {
        return $this->repo->operate_item_add_this(request()->all(),21);
    }
    public function operate_item_remove_collection()
    {
        return $this->repo->operate_item_remove_this(request()->all(),21);
    }
    // 【待办事】
    public function operate_item_add_todo_list()
    {
        return $this->repo->operate_item_add_this(request()->all(),41);
    }
    public function operate_item_remove_todo_list()
    {
        return $this->repo->operate_item_remove_this(request()->all(),41);
    }
    // 【日程】
    public function operate_item_add_schedule()
    {
        return $this->repo->operate_item_add_this(request()->all(),51);
    }
    public function operate_item_remove_schedule()
    {
        return $this->repo->operate_item_remove_this(request()->all(),51);
    }
    // 【转发】
    public function operate_item_forward()
    {
        return $this->repo->operate_item_forward(request()->all());
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

