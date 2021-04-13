<?php
namespace App\Http\Controllers\Atom\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Atom\Admin\AtomAdminRepository;

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

	public function index()
	{
        return view('admin.index.index');
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
    public function view_item_item_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_item_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_item_datatable(request()->all());
    }
    // 【内容】返回-全部内容-列表-视图
    public function view_item_all_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_all_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_all_datatable(request()->all());
    }
    // 【内容】返回-列表-视图
    public function view_item_people_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_people_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_people_datatable(request()->all());
    }
    // 【内容】返回-列表-视图
    public function view_item_object_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_object_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_object_datatable(request()->all());
    }
    // 【内容】返回-列表-视图
    public function view_item_product_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_product_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_product_datatable(request()->all());
    }

    // 【内容】返回-全部内容-列表-视图
    public function view_item_event_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_event_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_event_datatable(request()->all());
    }

    // 【内容】返回-全部内容-列表-视图
    public function view_item_conception_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_conception_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_item_conception_datatable(request()->all());
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
    // 【内容】发布
    public function operate_item_item_publish()
    {
        return $this->repo->operate_item_item_publish(request()->all());
    }




    // 【内容】禁用
    public function operate_item_admin_disable()
    {
        return $this->repo->operate_item_admin_disable(request()->all());
    }
    // 【内容】解禁
    public function operate_item_admin_enable()
    {
        return $this->repo->operate_item_admin_enable(request()->all());
    }


}

