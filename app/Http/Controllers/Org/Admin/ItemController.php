<?php
namespace App\Http\Controllers\Org\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Org\Admin\OrgItemRepository;

class ItemController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
        $this->repo = new OrgItemRepository;
    }



    public function index()
    {
        return view('org.admin.company.item.index');
    }

    public function viewList()
    {
        if(request()->isMethod('get')) return view('org.admin.item.list');
        else if(request()->isMethod('post')) return $this->repo->get_list_datatable(request()->all());
    }

    public function createAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_create();
        else if (request()->isMethod('post')) $this->repo->save(request()->all());
    }

    public function editAction()
    {
        if(request()->isMethod('get')) return $this->repo->view_edit();
        else if (request()->isMethod('post')) return $this->repo->save(request()->all());
    }

    // 【删除】
    public function deleteAction()
    {
        return $this->repo->delete(request()->all());
    }

    // 【启用】
    public function enableAction()
    {
        return $this->repo->enable(request()->all());
    }

    // 【禁用】
    public function disableAction()
    {
        return $this->repo->disable(request()->all());
    }

    public function getAction()
    {
        return $this->repo->get(request()->all());
    }


    // 【select2】
    public function select2_menus()
    {
        return $this->repo->select2_menus(request()->all());
    }




}
