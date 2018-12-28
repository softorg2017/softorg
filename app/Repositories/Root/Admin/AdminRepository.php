<?php
namespace App\Repositories\Root\Admin;

use App\Models\Root\RootModule;
use App\Models\Root\RootMenu;
use App\Models\Root\RootItem;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode;

class AdminRepository {

    private $model;
    public function __construct()
    {
//        $this->model = new Root;
    }

    // 返回（后台）主页视图
    public function view_admin_index()
    {
        return view('root.admin.index');
    }



}