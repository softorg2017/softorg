<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
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

use Response, Auth, Validator, DB, Excepiton;

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

        $bool = $org->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }



    // 返回（前台）【主页】视图
    public function view_index($org)
    {
        $query = Softorg::with([
            'administrators','websites','menus',
            'products' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(3); },
            'activities' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(3); },
            'slides' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(3); },
            'surveys' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(3); },
            'articles' => function ($query) { $query->orderBy('updated_at', 'desc')->limit(3); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 访问数量+1
            $org->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 1;
            $record["sort"] = "index";
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.index').'.index')->with('org',$org);
        }
        else dd("企业不存在");
    }


    // 返回（前台）【产品】列表页视图
    public function view_product($org)
    {
//        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        $query = Softorg::with(['administrators','websites',
            'products' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 2;
            $record["sort"] = "product";
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

        $product = Product::with(['org','admin'])->whereId($decode_id)->first();
        if($product)
        {
            // 访问数量+1
            $product->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 3;
            $record["sort"] = "product";
            $record["org_id"] = $product->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            $string = "jsapi_ticket=HoagFKDcsGMVCIY2vOjf9nzhkKortt07_TqfuxtJ_AUc8rukR4TLzJVXm8EwEi43gyiVaYBvVJzHZSKiAMvGIg&noncestr=Softorg20171010Softorg20171207&timestamp=1512624767&url=".url()->full();
            request()->url();
            $signature = sha1($string);
            var_dump($signature);die();
            return view('front.'.config('common.view.front.detail').'.product.detail')->with(['data'=>$product,'signature'=>$signature]);
        }
        else dd("产品不存在");
    }


    // 返回（前台）【活动】列表页视图
    public function view_activity($org)
    {
        $query = Softorg::with(['administrators','websites',
            'activities' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 2;
            $record["sort"] = "activity";
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.activity.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【活动】【详情】页视图
    public function view_activity_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with(['org','admin'])->whereId($decode_id)->first();
        if($activity)
        {
            // 访问数量+1
            $activity->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 3;
            $record["sort"] = "activity";
            $record["org_id"] = $activity->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.activity.detail')
                ->with(['data'=>$activity,'encode_id'=>$encode_id]);
        }
        else dd("活动不存在");
    }
    // 返回（前台）【活动】【详情】页视图
    public function view_activity_apply()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with(['org','admin'])->whereId($decode_id)->first();
        if($activity)
        {
            // 访问数量+1
            $activity->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 3;
            $record["sort"] = "activity";
            $record["org_id"] = $activity->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.activity.apply')->with('data',$activity);
        }
        else dd("活动不存在");
    }


    // 返回（前台）【幻灯片】列表页视图
    public function view_slide($org)
    {
        $query = Softorg::with(['administrators','websites',
            'slides' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 2;
            $record["sort"] = "slide";
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.slide.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【幻灯片】【详情】页视图
    public function view_slide_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $slide = Slide::with(['org','admin',
            'pages' => function ($query) { $query->orderBy('order', 'asc'); }
        ])->whereId($decode_id)->first();
        if($slide)
        {
            // 访问数量+1
            $slide->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 3;
            $record["sort"] = "slide";
            $record["org_id"] = $slide->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.slide.detail')->with('data',$slide);
        }
        else dd("幻灯片不存在");
    }


    // 返回（前台）【调研问卷】列表页视图
    public function view_survey($org)
    {
        $query = Softorg::with(['administrators','websites',
            'surveys' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 2;
            $record["sort"] = "survey";
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.survey.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【调研问卷】【详情】页视图
    public function view_survey_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $survey = Survey::with(['org','admin',
            'questions' => function ($query) { $query->orderBy('order', 'asc'); }
        ])->whereId($decode_id)->first();
        if($survey)
        {
            // 访问数量+1
            $survey->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 3;
            $record["sort"] = "survey";
            $record["org_id"] = $survey->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.survey.detail')->with('data',$survey);
        }
        else dd("调研不存在");
    }


    // 返回（前台）【文章】列表页视图
    public function view_article($org)
    {
//        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        $query = Softorg::with(['administrators','websites',
            'articles' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 2;
            $record["sort"] = "article";
            $record["org_id"] = $org->id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.list').'.article.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）【文章】【详情】页视图
    public function view_article_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $article = Article::with(['org','admin'])->whereId($decode_id)->first();
        if($article)
        {
            // 访问数量+1
            $article->increment('visit_num');
            // 插入记录表
            if(Auth::check()) $record["user_id"] = Auth::id();
            $record["type"] = 3;
            $record["sort"] = "article";
            $record["org_id"] = $article->org->id;
            $record["page_id"] = $decode_id;
            $record["from"] = request('from',NULL);
            $this->record($record);

            return view('front.'.config('common.view.front.detail').'.article.detail')->with('data',$article);
        }
        else dd("文章不存在");
    }

    // 活动报名
    public function apply($post_data)
    {
        $v = Validator::make($post_data, [
            'type' => 'required|in:1,2',
            'id' => 'required'
        ]);
        if ($v->fails()) return response_error([],"参数错误");

        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"参数错误");

        $type = $post_data['type'];
        $apply = new Apply();
        $insert['activity_id'] = $id;
        $insert['type'] = $type;
        if($type == 1)
        {
            $v2 = Validator::make($post_data, [
                'name' => 'required',
                'mobile' => 'required|numeric',
            ]);
            if ($v2->fails()) return response_error([],"参数错误");

            $insert['name'] = $post_data['name'];
            $insert['mobile'] = $post_data['mobile'];
        }
        else if($type == 2)
        {
            if(Auth::check()) $insert['user_id'] = Auth::id();
            return response_error([],"请先登录！");
        }
        $bool = $apply->fill($insert)->save();
        if($bool) return response_success([]);
        return response_fail([]);
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
                'name' => 'required',
                'mobile' => 'required|numeric',
            ]);
            if ($v2->fails()) return response_error([],"参数错误");

            $insert['name'] = $post_data['name'];
            $insert['mobile'] = $post_data['mobile'];
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


    // 记录访问
    public function record($post_data)
    {
        $record = new Record();

        $browseInfo = getBrowserInfo();
        $type = $browseInfo['type'];
        if($type == "PC") $post_data["open_type"] = 0;
        else if($type == "Mobile") $post_data["open_type"] = 1;

        $post_data["open_system"] = $browseInfo['system'];
        $post_data["open_browser"] = $browseInfo['browser'];
        $post_data["open_app"] = $browseInfo['app'];

        $post_data["ip"] = Get_IP();
        $bool = $record->fill($post_data)->save();
        if($bool) return true;
        else return false;
    }

}