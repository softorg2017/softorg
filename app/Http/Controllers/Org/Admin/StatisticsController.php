<?php
namespace App\Http\Controllers\Org\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\Org\Admin\OrgStatisticsRepository;

class StatisticsController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->repo = new OrgStatisticsRepository;
    }



    public function index()
    {
        return view('org.admin.statistics.index');
    }

    public function website()
    {
        return $this->repo->view_website_statistics();
    }

    public function page()
    {
        return $this->repo->view_page_statistics(request()->all());
    }

    public function menu()
    {
        return $this->repo->view_menu_statistics(request()->all());
    }

    public function item()
    {
        return $this->repo->view_item_statistics(request()->all());
    }





}
