<?php
namespace App\Repositories\Root;

use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgOrganizationExt;
use App\Models\Org\OrgMenu;
use App\Models\Org\OrgItem;
use App\Models\Org\OrgRecord;

use App\Models\Softorg;
use App\Models\SoftorgExt;
use App\Models\Record;
use App\Models\Website;

use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use App\Models\Apply;
use App\Models\Sign;
use App\Models\Answer;
use App\Models\Choice;

use App\Repositories\Common\CommonRepository;
use App\Repositories\Admin\MailRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class IndexRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgOrganization;
    }

    //
    public function index()
    {
        $org = OrgOrganization::with([
            'administrators',
            'ext',
            'modules' => function ($query) {
                $query->with([
                    'menus'=>function ($query1) { $query1->with([
                        'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
                    ])->where('active', 1)->orderBy('order', 'asc'); },
                    'menu'=>function ($query1) { $query1->with([
                        'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
                    ])->where('active', 1); }
                ])->where('active', 1)->orderBy('order', 'asc');
            },
        ])->find(1);

        if($org)
        {
            foreach($org->menus as $key=>$menu)
            {
                $menu->items = $menu->items->slice(0, 4);
            }
            return view('org.frontend.vipp.entrance.index')->with(['org'=>$org,'menus'=>$org->menus]);

        }
        else dd("企业不存在");
    }














}