<?php
namespace App\Http\Controllers\LW\Atom\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\LW\Atom\Admin\AtomAdminRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class AtomAdminController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new AtomAdminRepository;
    }


	public function view_admin_index()
	{
        return $this->repo->view_admin_index();
	}

    public function dataTableI18n()
    {
    	return trans('pagination.i18n');
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




    // 【内容】获取-详情
    public function operate_item_item_get()
    {
        return $this->repo->operate_item_item_get(request()->all());
    }
    // 【内容】删除
    public function operate_item_item_delete()
    {
        return $this->repo->operate_item_item_delete(request()->all());
    }
    // 【内容】删除
    public function operate_item_item_restore()
    {
        return $this->repo->operate_item_item_restore(request()->all());
    }
    // 【内容】删除
    public function operate_item_item_delete_permanently()
    {
        return $this->repo->operate_item_item_delete_permanently(request()->all());
    }
    // 【内容】发布
    public function operate_item_item_publish()
    {
        return $this->repo->operate_item_item_publish(request()->all());
    }




    // 【内容】禁用
    public function operate_item_item_disable()
    {
        return $this->repo->operate_item_item_disable(request()->all());
    }
    // 【内容】解禁
    public function operate_item_item_enable()
    {
        return $this->repo->operate_item_item_enable(request()->all());
    }




    // 【内容管理】修改-文本-信息
    public function operate_item_text_set()
    {
        return $this->repo->operate_item_text_set(request()->all());
    }
    // 【内容管理】修改-时间-信息
    public function operate_item_time_set()
    {
        return $this->repo->operate_item_time_set(request()->all());
    }
    // 【内容管理】修改-option-信息
    public function operate_item_order_info_option_set()
    {
        return $this->repo->operate_item_option_set(request()->all());
    }


}

