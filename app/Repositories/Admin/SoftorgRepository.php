<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Models\SoftorgExt;
use App\Models\Record;
use App\Models\Website;
use App\Models\Menu;
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

class SoftorgRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Softorg;
    }

    // 返回（后台）主页视图
    public function view_admin_index()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::whereId($org_id)->first();

        return view('admin.softorg.index')->with(['org'=>$org]);
    }

    // 返回（后台）企业信息编辑视图
    public function view_edit()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::whereId($org_id)->first();

        return view('admin.softorg.edit')->with(['org'=>$org]);
    }
    // 保存企业信息
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::find($org_id);

        if(!empty($post_data["logo"]))
        {
            $upload = new CommonRepository();
            $result = $upload->create($post_data["logo"], 'org-'. $admin->id . '-common-logo');
            if($result["status"]) $post_data["logo"] = $result["data"];
            else return response_fail();
        }
        else unset($post_data["logo"]);

        // 目标URL
        $url = 'http://softorg.cn/org/'.$admin->website_name;
        // 保存位置
        $qrcode_path = 'resource/org/'.$admin->id.'/unique/common';
        if(!file_exists(storage_path($qrcode_path)))
            mkdir(storage_path($qrcode_path), 0777, true);
        // qrcode图片文件
        $qrcode = $qrcode_path.'/qrcode.png';
        QrCode::errorCorrection('H')->format('png')->size(320)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));

        $bool = $org->fill($post_data)->save();
        if($bool)
        {
            $name = $qrcode_path.'/qrcode_img.png';
            $common = new CommonRepository();
            $logo = 'resource/'.$org->logo;
            $common->create_root_qrcode($name, $org->name, $qrcode, $logo);

            return response_success();
        }
        else return response_fail();
    }



    // 显示 编辑自定义首页
    public function view_edit_home()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.home')->with('data', $ext);
    }
    // 显示 编辑自定义信息
    public function view_edit_information()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.information')->with('data', $ext);
    }
    // 显示 编辑简介
    public function view_edit_introduction()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.introduction')->with('data', $ext);
    }
    // 显示 编辑联系我们
    public function view_edit_contactus()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.contactus')->with('data', $ext);
    }
    // 显示 编辑企业文化
    public function view_edit_culture()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $ext = SoftorgExt::where('org_id', $org_id)->first();
        return view('admin.softorg.culture')->with('data', $ext);
    }

    // 编辑ext
    public function save_ext($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $website = SoftorgExt::where('org_id', $org_id)->first();
        if($website)
        {
            $type = $post_data['type'];
            $content = $post_data['content'];
            $editor[$type] = $content;
            $bool = $website->fill($editor)->save();
            if($bool) return response_success([], '修改成功');
            else return response_fail([], '修改失败，刷新页面重试');
        }
        else return response_error();
    }



    // 返回（前台）【根】视图
    public function view_root($org)
    {
//        $query = Softorg::with(['administrators','ext','menus','products','activities','slides','surveys','articles']);
        $query = Softorg::with([
            'administrators','ext',
            'menus' => function ($query) {
                $query->with(['items'=>function ($query1) {
                        $query1->with('itemable')->where('active', 1)->orderBy('updated_at', 'desc'); } ])
                    ->where('active', 1)->orderBy('order', 'asc');
//                $query->with([
//                    'products' => function ($queryX) { $queryX->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
//                    'articles' => function ($queryX) { $queryX->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
//                    'activities' => function ($queryX) { $queryX->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
//                    'surveys' => function ($queryX) { $queryX->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
//                    'slides' => function ($queryX) { $queryX->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); }
//                ])->where('active', 1)->orderBy('order', 'asc');
            },
//            'products' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(7); },
//            'articles' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
//            'activities' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(7); },
//            'surveys' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
//            'slides' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 0; // module=0 default root
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            foreach($org->menus as $key=>$menu)
            {
                $items = $menu->items->slice(0, 3);
                $org->menus[$key]->items = $items;
            }
//            foreach($org->menus as $key=>$menu)
//            {
//                $item = [];
//                $i = 0;
//
//                foreach($menu->products as $k=>$v)
//                {
//                    $menu->products[$k]->item_type = 'product';
//                    $item[$i] = $menu->products[$k];
//                    $i = $i + 1;
//                }
//
//                foreach($menu->articles as $k=>$v)
//                {
//                    $menu->articles[$k]->item_type = 'article';
//                    $item[$i] = $menu->articles[$k];
//                    $i = $i + 1;
//                }
//
//                foreach($menu->activities as $k=>$v)
//                {
//                    $menu->activities[$k]->item_type = 'activity';
//                    $item[$i] = $menu->activities[$k];
//                    $i = $i + 1;
//                }
//
//                foreach($menu->surveys as $k=>$v)
//                {
//                    $menu->surveys[$k]->item_type = 'survey';
//                    $item[$i] = $menu->surveys[$k];
//                    $i = $i + 1;
//                }
//
//                foreach($menu->slides as $k=>$v)
//                {
//                    $menu->slides[$k]->item_type = 'slide';
//                    $item[$i] = $menu->slides[$k];
//                    $i = $i + 1;
//                }
//
//                $org->menus[$key]->items = $item;
//            }

//            dd($org);
//            dd($org->toArray());

            return view('front.'.config('common.view.front.index').'.index')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【主页】视图
    public function view_index($org)
    {
//        $query = Softorg::with(['administrators','ext','menus','products','activities','slides','surveys','articles']);
        $query = Softorg::with([
            'administrators','ext','menus',
            'products' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(7); },
            'activities' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(7); },
            'slides' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
            'surveys' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); },
            'articles' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc')->limit(3); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 1; // module=1 index
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.index')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【自定义首页】视图
    public function view_home($org)
    {
        $query = Softorg::with([
            'administrators','ext'
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 2; // module=2 home
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.home')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【企业信息】视图
    public function view_information($org)
    {
        $query = Softorg::with([
            'administrators','ext'
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 3; // module=3 information
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.information')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【简介】视图
    public function view_introduction($org)
    {
        $query = Softorg::with([
            'administrators','ext'
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 3; // module=3 introduction
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.introduction')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【联系我们】视图
    public function view_contactus($org)
    {
        $query = Softorg::with([
            'administrators','ext'
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 4; // module=4 contactus
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.contactus')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【企业文化】视图
    public function view_culture($org)
    {
        $query = Softorg::with([
            'administrators','ext'
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->timestamps = false;
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 1; // sort=1 system
            $record["module"] = 5; // module=5 culture
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.culture')->with('org',$org);
        }
        else dd("企业不存在");
    }



    // 返回（前台）【目录】列表页视图
    public function view_menu($org)
    {
        $query = Softorg::with(['administrators','ext','website',
            'menus'=>function ($query) { $query->where('active', 1)->orderBy('order', 'asc'); },
            'products' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=2 list
            $record["module"] = 1; // module=1 product
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.product.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【目录】【详情页】视图
    public function view_menu_contents()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $menu = Menu::with([
                'org'=>function ($query) {
                        $query->with(['menus'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); } ]);
                    },
                'admin',
                'items'=>function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
            ])->whereId($decode_id)->first();
        if($menu)
        {
            // 访问数量+1
            $menu->timestamps = false;
            $menu->increment('visit_num');
//            DB::table('menu')->where('id', $decode_id)->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=3 list
            $record["module"] = 0; // module=0 customer menu
            $record["org_id"] = $menu->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.menu.contents')
                ->with(['data'=>$menu,'org'=>$menu->org,'encode_id'=>$encode_id]);
        }
        else dd("产品不存在");
    }



    // 返回（前台）【产品】列表页视图
    public function view_product($org)
    {
        $query = Softorg::with(['administrators','ext','website',
            'menus'=>function ($query) { $query->where('active', 1)->orderBy('order', 'asc'); },
            'products' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=2 list
            $record["module"] = 1; // module=1 product
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.product.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【产品】【详情页】视图
    public function view_product_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $product = Product::with([
                'org'=>function ($query) {
                    $query->with(['menus'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); } ]);
                },
                'admin'
            ])->whereId($decode_id)->first();
        if($product)
        {
            // 访问数量+1
            $product->timestamps = false;
            $product->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 3; // sort=3 detail
            $record["module"] = 1; // module=1 product
            $record["org_id"] = $product->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.product.detail')
                ->with(['data'=>$product,'encode_id'=>$encode_id]);
        }
        else dd("产品不存在");
    }



    // 返回（前台）【文章】【列表页】视图
    public function view_article($org)
    {
//        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        $query = Softorg::with(['administrators','ext','website',
            'menus'=>function ($query) { $query->where('active', 1)->orderBy('order', 'asc'); },
            'articles' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=2 list
            $record["module"] = 2; // module=2 article
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.article.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【文章】【详情页】视图
    public function view_article_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $article = Article::with([
            'org'=>function ($query) {
                $query->with(['menus'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); } ]);
            },
            'admin'])->whereId($decode_id)->first();
        if($article)
        {
            // 访问数量+1
            $article->timestamps = false;
            $article->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 3; // sort=3 detail
            $record["module"] = 2; // module=2 article
            $record["org_id"] = $article->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.article.detail')
                ->with(['data'=>$article,'encode_id'=>$encode_id]);
        }
        else dd("文章不存在");
    }



    // 返回（前台）【活动】【列表页】视图
    public function view_activity($org)
    {
        $query = Softorg::with(['administrators','ext','website',
            'menus'=>function ($query) { $query->where('active', 1)->orderBy('order', 'asc'); },
            'activities' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=2 list
            $record["module"] = 3; // module=3 activity
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.activity.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【活动】【详情页】视图
    public function view_activity_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with([
            'org'=>function ($query) {
                $query->with(['menus'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); } ]);
            },
            'admin'])->whereId($decode_id)->first();
        if($activity)
        {
            // 访问数量+1
            $activity->timestamps = false;
            $activity->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 3; // sort=3 detail
            $record["module"] = 3; // module=3 activity
            $record["org_id"] = $activity->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.activity.detail')
                ->with(['data'=>$activity,'encode_id'=>$encode_id]);
        }
        else dd("活动不存在");
    }
    // 返回（前台）【活动报名】【详情页】视图
    public function view_activity_apply()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with(['org','admin'])->whereId($decode_id)->first();
        if($activity)
        {
            // 访问数量+1
            $activity->timestamps = false;
            $activity->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 3; // sort=3 detail
            $record["module"] = 3; // module=3 activity
            $record["org_id"] = $activity->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.activity.apply')->with('data',$activity);
        }
        else dd("活动不存在");
    }



    // 返回（前台）【调研问卷】【列表页】视图
    public function view_survey($org)
    {
        $query = Softorg::with(['administrators','ext','website',
            'menus'=>function ($query) { $query->where('active', 1)->orderBy('order', 'asc'); },
            'surveys' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=2 list
            $record["module"] = 4; // module=4 survey
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.survey.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【调研问卷】【详情页】视图
    public function view_survey_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $survey = Survey::with([
            'org'=>function ($query) {
                $query->with(['menus'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); } ]);
            },
            'admin',
            'questions' => function ($query) { $query->orderBy('order', 'asc'); }
        ])->whereId($decode_id)->first();
        if($survey)
        {
            // 访问数量+1
            $survey->timestamps = false;
            $survey->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 3; // sort=3 detail
            $record["module"] = 4; // module=4 survey
            $record["org_id"] = $survey->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.survey.detail')
                ->with(['data'=>$survey,'encode_id'=>$encode_id]);
        }
        else dd("调研不存在");
    }



    // 返回（前台）【幻灯片】【列表页】视图
    public function view_slide($org)
    {
        $query = Softorg::with(['administrators','ext','website',
            'menus'=>function ($query) { $query->where('active', 1)->orderBy('order', 'asc'); },
            'slides' => function ($query) { $query->where('active', 1)->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 2; // sort=2 list
            $record["module"] = 5; // module=5 slide
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.slide.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【幻灯片】【详情页】视图
    public function view_slide_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $slide = Slide::with([
            'org'=>function ($query) {
                $query->with(['menus'=>function ($query1) { $query1->where('active', 1)->orderBy('updated_at', 'desc'); } ]);
            },
            'admin',
            'pages' => function ($query) { $query->orderBy('order', 'asc'); }
        ])->whereId($decode_id)->first();
        if($slide)
        {
            // 访问数量+1
            $slide->timestamps = false;
            $slide->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1; // type=1 browse
            $record["sort"] = 3; // sort=3 detail
            $record["module"] = 5; // module=5 slide
            $record["org_id"] = $slide->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.slide.detail')
                ->with(['data'=>$slide,'encode_id'=>$encode_id]);
        }
        else dd("幻灯片不存在");
    }



    // 活动报名
    public function apply($post_data)
    {
        $v = Validator::make($post_data, [
            'type' => 'required|in:1,2',
            'id' => 'required'
        ]);
        if ($v->fails()) return response_error([],"参数错误");

        $encode_id = $post_data["id"];
        $id = decode($encode_id);
        if(intval($id) !== 0 && !$id) return response_error([],"参数错误");

        $type = $post_data['type'];
        $password = rand(1000,9999);
        $apply = new Apply();
        $insert['activity_id'] = $id;
        $insert['type'] = $type;

        if($type == 1)
        {
            $v2 = Validator::make($post_data, [
                'name' => 'required',
                'mobile' => 'required|numeric',
                'email' => 'required|email',
            ]);
            if ($v2->fails()) return response_error([],"参数错误");

            $email = $post_data['email'];
            $applied = Apply::where('activity_id',$id)->where('email',$email)->first();
            if($applied) return response_error([],"该邮箱已报过名了！");

            $insert['name'] = $post_data['name'];
            $insert['mobile'] = $post_data['mobile'];
            $insert['email'] = $post_data['email'];
            $insert['password'] = $password;
        }
        else if($type == 2)
        {
            if(Auth::check()) $insert['user_id'] = Auth::id();
            return response_error([],"请先登录！");
        }

        DB::beginTransaction();
        try
        {
            $bool = $apply->fill($insert)->save();
            if($bool)
            {
                if($type == 1)
                {
                    $activity = Activity::find($id);

                    $variate['host'] = config('common.host');
                    $variate['sort'] = 'activity_apply';
                    $variate['target'] = $post_data['email'];
                    $variate['email'] = $post_data['email'];
                    $variate['activity_id'] = $encode_id;
                    $variate['apply_id'] = encode($apply->id);
                    $variate['password'] = $password;
                    $variate['title'] = $activity->title;
                    $variate['is_sign'] = $activity->is_sign;

//                    $mail = new MailRepository();
//                    $mail->send_activity_apply_email($variate);

//                    $url = 'http://qingorg.cn:8088/email/send';
                    $url = config('common.MailService').'/softorg/activity/apply/activation';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $variate);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    if(empty($response)) throw new Exception('curl get request failed');
                    else
                    {
                        $response = json_decode($response,true);
                        if(!$response['success']) throw new Exception("send-email-failed");
                    }
                }
            }
            else throw new Exception("insert-apply-failed");

            DB::commit();
            return response_success([],'注册成功,请前往邮箱激活管理员');
        }
        catch (Exception $e)
        {
            DB::rollback();
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],'注册失败！');
        }
    }

    // 活动报名验证
    public function apply_activation($post_data)
    {
        $email = $post_data['email'];
        $activity_encode = $post_data['activity'];
        $apply_encode = $post_data['apply'];

        $activity_id = decode($activity_encode);
        if(intval($activity_id) !== 0 && !$activity_id) return dd("活动有误");

        $apply_id = decode($apply_encode);
        if(intval($apply_id) !== 0 && !$apply_id) return dd("报名有误");

        $apply = Apply::find($apply_id);
        if($apply)
        {
            if( ($apply->activity_id == $activity_id) && ($apply->email == $email) )
            {
                if($apply->confirm == 0)
                {
                    $apply->confirm = 1;
                    $apply->save();
                    dd("报名确认成功");
                }
                else dd("已经确认过了");
            }
            else dd("参数有误");
        }
        else dd("报名不存在");
    }

    // 活动签到
    public function sign($post_data)
    {
        $v = Validator::make($post_data, [
            'type' => 'required|in:1,2',
            'id' => 'required'
        ]);
        if ($v->fails()) return response_error([],"参数错误");

        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"参数错误");

        $type = $post_data['type'];
        $sign = new Sign();
        $insert['activity_id'] = $id;
        $insert['type'] = $type;
        if($type == 1)
        {
            $v2 = Validator::make($post_data, [
//                'name' => 'required',
//                'mobile' => 'required|numeric',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($v2->fails()) return response_error([],"参数错误");

//            $name = $post_data['name'];
//            $mobile = $post_data['mobile'];
            $email = $post_data['email'];
            $password = $post_data['password'];

            $applied = Apply::where('type',$type)->where('activity_id',$id)->where('email',$email)->where('password',$password)->first();
            if($applied)
            {
                $signed = Sign::where('type',$type)->where('activity_id',$id)->where('email',$email)->first();
                if($signed) return response_notice([],"已经签过到了");
                else
                {
                    $insert['name'] = $applied->name;
                    $insert['mobile'] = $applied->mobile;
                    $insert['email'] = $email;
                }
            }
            else return response_error([],"邮箱或密码有误，请前去邮箱查看密码");


        }
        else if($type == 2)
        {
            if(Auth::check()) $insert['user_id'] = Auth::id();
            return response_error([],"请先登录！");
        }
        $bool = $sign->fill($insert)->save();
        if($bool) return response_success([]);
        return response_fail([]);
    }



    // 问卷回答
    public function answer($post_data)
    {
        $allow = false;
        foreach($post_data["questions"] as $k => $v)
        {
            if(empty($v["value"]))
            {
                $allow = false;
                return response_error([],"有问题没有回答");
            }
            else $allow = true;
        }

        if($allow)
        {
            $id = decode($post_data["id"]);
            if(intval($id) !== 0 && !$id) return response_error([],"参数错误");
//
            $type = $post_data["type"];
            if($type == "survey")
            {
                $survey = Survey::find($id);
                if(!$survey) return response_error([],"该调研不存在，刷新页面试试");
                $answer_param["type"] = 1;
                $answer_param["survey_id"] = $id;
            }
            else if($type == "slide")
            {
                $page = Page::find($id);
                if(!$page) return response_error([],"该页面不存在，刷新页面试试");
                $answer_param["type"] = 2;
                $answer_param["page_id"] = $id;
            }

            $answer = new Answer;
            $answer_param["user_id"] = Auth::check() ? Auth::user()->id : 0;
            $bool = $answer->fill($answer_param)->save();
            if(!$bool) return response_fail();

            foreach($post_data["questions"] as $k => $v)
            {
                $question_id = decode($k);
                if(intval($question_id) !== 0 && !$question_id) return response_error([],"问题有误，请刷新重试");

//                unset($choice_param);

//                if($v["type"] == "text")
//                {
//                    $choice_param["answer_id"] = $answer->id;
//                    $choice_param["question_id"] = $question_id;
//                    $choice_param["text"] = $v["value"];
//                    $choice = new Choice;
//                    $bool = $choice->fill($choice_param)->save();
//                }
//                else if($v["type"] == "radio")
//                {
//                    $choice_param["answer_id"] = $answer->id;
//                    $choice_param["question_id"] = $question_id;
//                    $choice_param["option_id"] = $v["value"];
//                    $choice = new Choice;
//                    $bool = $choice->fill($choice_param)->save();
//                }
//                else if($v["type"] == "checkbox")
//                {
//                    $choice_param["answer_id"] = $answer->id;
//                    $choice_param["question_id"] = $question_id;
//                    foreach($v["value"] as $ks => $vs)
//                    {
//                        $choice_param["option_id"] = $vs;
//                        $choice = new Choice;
//                        $bool = $choice->fill($choice_param)->save();
//                    }
//                }

                if($v["type"] == "text")
                {
                    $choice_param[$k]["question_id"] = $question_id;
                    $choice_param[$k]["text"] = $v["value"];
                }
                else if($v["type"] == "radio")
                {
                    $choice_param[$k]["question_id"] = $question_id;
                    $choice_param[$k]["option_id"] = $v["value"];
                }
                else if($v["type"] == "checkbox")
                {
                    foreach($v["value"] as $ks => $vs)
                    {
                        $choice_param[$k.$ks]["question_id"] = $question_id;
                        $choice_param[$k.$ks]["option_id"] = $vs;
                    }
                }

            }
            $choices = $answer->choices()->createMany($choice_param); //
            if(!$choices) return response_fail();
            else
            {
                if($type == "survey")
                {
                    $survey->timestamps = false;
                    $survey->increment('answer_num', 1);
                }
                else if($type == "slide")
                {
                    //$page->increment('answer_num', 1);
                }
                return response_success([]);
            }
        }

    }


    // 分享
    public function share($post_data)
    {
        $v = Validator::make($post_data, [
                'sort' => 'required|numeric',
                'module' => 'required|numeric',
                'share' => 'required|numeric'
            ]);
        if($v->fails()) return response_error([],"参数错误");

        $sort = $post_data["sort"];
        $module = $post_data["module"];
        $share = $post_data["share"];
        if(!in_array($share, [1,2,3,4,5])) return response_error([],"参数share错误");

        // system
        if($sort == 1)
        {
            if(!in_array($module, [0,1,2,3,4])) return response_error([],"参数module错误");

            $v = Validator::make($post_data, [
                'website' => 'required'
            ]);
            if($v->fails()) return response_error([],"参数website错误");

            $website = $post_data["website"];
            if(is_numeric($website)) $org = Softorg::whereId($website)->first();
            else $org = Softorg::where('website_name',$website)->first();
            if($org)
            {
                $record["org_id"] = $org->id;
                if($module == 0)
                {
                    $encode_id = request('id');
                    $decode_id = decode($encode_id);
                    $record["page_id"] = $decode_id;
                }
            }
            else return response_error([],"机构org不存在");

        }
        // 分享列表
        else if($sort == 2)
        {
            if(!in_array($module, [0,1,2,3,4,5])) return response_error([],"参数module错误");

            $v = Validator::make($post_data, [
                'website' => 'required'
            ]);
            if($v->fails()) return response_error([],"参数website错误");

            $website = $post_data["website"];
            if(is_numeric($website)) $org = Softorg::whereId($website)->first();
            else $org = Softorg::where('website_name',$website)->first();
            if($org)
            {
                $record["org_id"] = $org->id;
            }
            else return response_error([],"机构org不存在");
        }
        // detail
        else if($sort == 3)
        {
            $v = Validator::make($post_data, [
                'id' => 'required'
            ]);
            if($v->fails()) return response_error([],"参数id错误");

            $encode_id = request('id');
            $decode_id = decode($encode_id);
            if(intval($decode_id) !== 0 && !$decode_id) return response_error([],"参数id错误");

            if(in_array($module, [1,2,3,4,5]))
            {
                if($module == 1) $item = Product::whereId($decode_id)->first();
                else if($module == 2) $item = Article::whereId($decode_id)->first();
                else if($module == 3) $item = Activity::whereId($decode_id)->first();
                else if($module == 4) $item = Survey::whereId($decode_id)->first();
                else if($module == 5) $item = Slide::whereId($decode_id)->first();

                if($item)
                {
                    $record["page_id"] = $decode_id;
                    $record["org_id"] = $item->org_id;

                    // 访问数量+1
                    $item->timestamps = false;
                    $item->increment('share_num');
                    $org = Softorg::where('id',$item->org_id)->first();
                }
                else return response_error([],"条目item不存在");
            }
            else return response_error([],"参数module错误");
        }
        else return response_error([],"参数sort错误");

        // 插入记录表
        if(Auth::check()) $record["user_id"] = Auth::id();
        $record["type"] = 2; // type=2 share
        $record["sort"] = $sort; // sort system | list | detail
        $record["module"] = $module; // module
        $record["shared_location"] = $share;
        $record["from"] = request('from',NULL);
        $bool = $this->record($record);
        if($bool)
        {
            $org->timestamps = false;
            $org->increment('share_num');
        }
        return response_success([],'分享成功');
    }

    // 记录访问
    public function record($post_data)
    {
        $record = new Record();

        $browseInfo = getBrowserInfo();
        $type = $browseInfo['type'];
        if($type == "PC") $post_data["open_type"] = 0;
        else if($type == "Mobile") $post_data["open_type"] = 1;

        $post_data["referer"] = $browseInfo['referer'];
        $post_data["open_system"] = $browseInfo['system'];
        $post_data["open_browser"] = $browseInfo['browser'];
        $post_data["open_app"] = $browseInfo['app'];

        $post_data["ip"] = Get_IP();
        $bool = $record->fill($post_data)->save();
        if($bool) return true;
        else return false;
    }



    // 下载根二维码
    public function download_root_qrcode($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $qrcode = "resource/org/".$org_id."/unique/common/qrcode_img.png";

        if(file_exists(storage_path($qrcode)))
        {
            return response()->download(storage_path($qrcode), 'qrcode.png');
        }
        else echo "二维码不存在，编辑机构资料生成二维码";
    }

    // 下载二维码
    public function download_qrcode($post_data)
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("参数有误");

        $org_id = Auth::guard("org_admin")->user()->org_id;
        $qrcode_path = "resource/org/items/";

        $sort = $post_data['sort'];
        if($sort == "item")
        {
            $qrcode = $qrcode_path."qrcode_item_".$encode_id.".png";
        }
        else if($sort == "org-item")
        {
            $qrcode = $qrcode_path."qrcode_org_item_".$encode_id.".png";
        }
        else if($sort == "product")
        {
            $qrcode = $qrcode_path."products/qrcode__product_".$encode_id.".png";
        }
        else if($sort == "activity")
        {
            $qrcode = $qrcode_path."activities/qrcode__activity_".$encode_id.".png";
        }
        else if($sort == "slide")
        {
            $qrcode = $qrcode_path."slides/qrcode__slide_".$encode_id.".png";
        }
        else if($sort == "survey")
        {
            $qrcode = $qrcode_path."surveys/qrcode__survey_".$encode_id.".png";
        }
        else if($sort == "article")
        {
            $qrcode = $qrcode_path."articles/qrcode__article_".$encode_id.".png";
        }

        if(file_exists(storage_path($qrcode)))
        {
            return response()->download(storage_path($qrcode), 'qrcode.png');
        }
        else echo "二维码不存在，重新编辑生成二维码";
    }




}