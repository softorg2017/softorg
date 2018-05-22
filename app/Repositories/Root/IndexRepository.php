<?php
namespace App\Repositories\Root;


use App\Models\Outside\OutsideModule;
use App\Models\Outside\OutsideMenu;
use App\Models\Outside\OutsideItem;
use App\Models\Outside\OutsideTemplate;
use App\Models\Outside\OutsidePivotMenuItem;


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

use Response, Auth, Validator, DB, Exception, Cache;
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

        $cache_key_root_is_refresh = config('outside.cache.key.root_is_refresh');
        $cache_key_root_html = config('outside.cache.key.root_html');

//        Cache::forget($cache_key_root_is_refresh);

        if( Cache::has($cache_key_root_is_refresh) && (Cache::get($cache_key_root_is_refresh) === 0) && Cache::has($cache_key_root_html) )
        {
            $root_html = Cache::get($cache_key_root_html);
        }
        else
        {
            $root_html = $this->create_root_html();
            Cache::put($cache_key_root_html, $root_html, 60*24*7);
            Cache::put($cache_key_root_is_refresh, 0, 60*24*7);
        }

        return $root_html;

    }

    public function create_root_html()
    {
//        $org = OrgOrganization::with([
//            'administrators',
//            'ext',
//            'modules' => function ($query) {
//                $query->with([
//                    'menus'=>function ($query1) { $query1->with([
//                        'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
//                    ])->where('active', 1)->orderBy('order', 'asc'); },
//                    'menu'=>function ($query1) { $query1->with([
//                        'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
//                    ])->where('active', 1); }
//                ])->where('active', 1)->orderBy('order', 'asc');
//            },
//        ])->find(1);

//        if($org)
//        {
//            foreach($org->menus as $key=>$menu)
//            {
//                $menu->items = $menu->items->slice(0, 4);
//            }
//            return view('outside.frontend.vipp.entrance.index')->with(['org'=>$org,'modules'=>$modules,'menus'=>$menus]);
//
//
//        }
//        else dd("企业不存在");



        $info = json_decode(json_encode(config('outside.company.info')));
        $org = $info;

        $modules = OutsideModule::with([
            'menus'=>function ($query1) { $query1
                ->with([
                    'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
                ])
                ->where('active', 1)->orderBy('order', 'asc'); },
            'menu'=>function ($query1) { $query1
                ->with([
                    'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
                ])
                ->where('active', 1); }
        ])->where('active', 1)->orderBy('order', 'asc')->get();



//        foreach($modules as $module)
//        {
//            foreach($module->menus as $menu)
//            {
//                $menu_items = OutsideMenu::with([
//                    'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc')->limit(8); }
//                ])->find($menu->id);
//                $menu->items = $menu_items->items;
//            }
//        }
//        dd($modules->toArray());


        $templates = OutsideTemplate::where(['active'=>1])->orderby('updated_at','desc')->limit(8)->get();

        $menus = OutsideMenu::with([
//            'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
        ])->where('active', 1)->orderBy('order', 'asc')->get();
//
//        foreach($menus as $key=>$menu)
//        {
//            $menu->items = $menu->items->slice(0, 4);
//        }



        $html = view('outside.frontend.vipp.entrance.index')
            ->with(['org'=>$org,'info'=>$info,'menus'=>$menus,'modules'=>$modules,'templates'=>$templates])->__toString();

        return $html;



//        $menu_s1 = DB::select('SELECT * FROM softorg_outside_item AS a WHERE 2 > ( SELECT COUNT(*) FROM softorg_outside_item WHERE type=a.type AND id>a.id ) ORDER BY a.id DESC');
//        dd($menu_ss);

//        $menu_s2 = DB::select('SELECT a.type FROM softorg_outside_item AS a LEFT JOIN softorg_outside_item AS b ON a.type = b.type AND a.id < b.id GROUP BY a.type HAVING COUNT (b.id) < 5 ORDER BY a.id DESC');
//        dd($menu_s2);

//        $menu_s3 = DB::select('select a1.* from softorg_outside_item a1 inner join ( select a.type,a.id from softorg_outside_item a left join softorg_outside_item b on a.type=b.type and a.id<=b.id group by a.type,a.id having count(b.id)<=3 )b1 on a1.type=b1.type and a1.id=b1.id order by a1.id desc');
//        dd($menu_s3);

//        $grouped = collect($menu_s3)->groupBy('type');
//        dd($grouped);


//        $menus = OutsideMenu::where('active', 1)->get();
//
//        $menuIds = $menus->pluck('id')->all();
//
//        //找出符合条件的 items ，同时定义 @post, @rank 变量，这里没有用 all,get 等函数，此时并不会执行 SQL 语句。
//        $sub = OutsidePivotMenuItem::whereIn('menu_id',$menuIds)->select(DB::raw('*,@menu := NULL ,@rank := 0'))->orderBy('id');
//
//        //把上面构造的 sql 查询作为子表进行查询，根据 menu_id 进行分区的同时 @rank 变量不断+1
//        $sub2 = DB::table( DB::raw("({$sub->toSql()}) as b") )
//            ->mergeBindings($sub->getQuery())
//            ->select(DB::raw('b.*,IF ( @menu = b.menu_id ,@rank :=@rank + 1 ,@rank := 1 ) AS rank, @menu := b.menu_id'));
//
//        //取出符合条件的前10条item
//        $itemIds = DB::table( DB::raw("({$sub2->toSql()}) as c") )
//            ->mergeBindings($sub2)
//            ->where('rank','<=',3)->select('c.item_id')->pluck('item_id')->toArray();
//
//        $items = OutsidePivotMenuItem::whereIn('item_id',$itemIds)->with('item')->get();
//
//        $menus = $menus->each(function ($item, $key) use ($items) {
//            $item->items = $items->where('menu_id',$item->id)->toArray();
//        });



    }


    //
    public function website_templates()
    {
        $info = json_decode(json_encode(config('outside.company.info')));
        $org = $info;

        $templates = OutsideTemplate::where(['active'=>1])->orderby('updated_at','desc')->paginate(16);

        $menus = OutsideMenu::with([
//            'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
        ])->where('active', 1)->orderBy('order', 'asc')->get();


        $html = view('outside.frontend.vipp.entrance.website.templates')
            ->with(['org'=>$org,'info'=>$info,'menus'=>$menus,'templates'=>$templates])->__toString();

        return $html;
    }

    //
    public function website_template($id)
    {
        $info = json_decode(json_encode(config('outside.company.info')));
        $org = $info;

        $decode_id = decode($id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $template = OutsideTemplate::where(['active'=>1])->orderby('updated_at','desc')->find($decode_id);

        $menus = OutsideMenu::with([
//            'items'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); }
        ])->where('active', 1)->orderBy('order', 'asc')->get();


        $html = view('outside.frontend.vipp.entrance.website.template')
            ->with(['org'=>$org,'info'=>$info,'menus'=>$menus,'template'=>$template])->__toString();

        return $html;
    }




}