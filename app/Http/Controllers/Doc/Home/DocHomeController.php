<?php
namespace App\Http\Controllers\Doc\Home;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Models\Def\Def_User;
use App\Models\Def\Def_Item;

use App\Models\Doc\Doc_Item;

use App\Repositories\Doc\Home\DocHomeRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;

class DocHomeController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new DocHomeRepository;
    }


    public function index()
    {
        return $this->repo->view_home_index();
    }


    /*
     * item
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


    // 【ITEM】【删除】
    public function operate_item_item_delete()
    {
        return $this->repo->operate_item_item_delete(request()->all());
    }




    // 【ITEM】内容管理
    public function view_item_content_management()
    {
        return $this->repo->view_item_content_management(request()->all());
    }

    // 编辑
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

    // 编辑
    public function operate_item_content_edit_menu_type()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_content_save_for_menu_type(request()->all());
    }
    public function operate_item_content_edit_time_line()
    {
        if(request()->isMethod('get')) return $this->repo->view_item_content_edit();
        else if (request()->isMethod('post')) return $this->repo->operate_item_content_save_for_time_line(request()->all());
    }

    // 【获取】
    public function operate_item_content_get()
    {
        return $this->repo->operate_item_content_get(request()->all());
    }
    // 【删除】
    public function operate_item_content_delete()
    {
        return $this->repo->operate_item_content_delete(request()->all());
    }
    // 【启用】
    public function operate_item_content_enable()
    {
        return $this->repo->operate_item_content_enable(request()->all());
    }
    // 【禁用】
    public function operate_item_content_disable()
    {
        return $this->repo->operate_item_content_disable(request()->all());
    }




    // 【内容】返回-全部内容-列表-视图
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








    // 【用户】【赞助商】返回-列表
    public function view_user_my_administrator_list()
    {
        if(request()->isMethod('get')) return $this->repo->view_user_my_administrator_list(request()->all());
        else if(request()->isMethod('post')) return $this->repo->get_user_my_administrator_list_datatable(request()->all());
    }


}
