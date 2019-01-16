<?php

namespace App\Http\Controllers\Developing;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgOrganizationExt;
use App\Models\Org\OrgMenu;
use App\Models\Org\OrgItem;
use App\Models\Org\OrgRecord;

class IndexController extends Controller
{
    //
    private $repo;
    public function __construct()
    {
    }

    // 返回（前台）【根】视图
    public function index()
    {
        dd('index');
    }


}
