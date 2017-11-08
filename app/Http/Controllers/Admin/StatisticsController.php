<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Services\Admin\StatisticsService;
use App\Repositories\Admin\StatisticsRepository;

class StatisticsController extends Controller
{
    //
    private $service;
    private $repo;
    public function __construct()
    {
        $this->service = new StatisticsService;
        $this->repo = new StatisticsRepository;
    }



    public function index()
    {
        return view('admin.website.index');
    }

    public function statistics()
    {
        return $this->repo->view_statistics(request()->all());
    }

    public function page()
    {
        return $this->repo->view_page_statistics(request()->all());
    }





}
