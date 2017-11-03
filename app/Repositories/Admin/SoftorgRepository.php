<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Models\Website;
use App\Models\Menu;
use App\Models\Product;
use App\Models\Activity;
use App\Models\Slide;
use App\Models\Survey;
use App\Models\Article;
use App\Models\Answer;
use App\Models\Choice;
use App\Repositories\Common\UploadRepository;
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
            $upload = new UploadRepository;
            $result = $upload->create($post_data["logo"], 'org-'. $admin->id . '-common-logo');
            if($result["status"]) $post_data["logo"] = $result["data"];
            else return response_fail();
        }

        $bool = $org->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }



    // 返回（前台）主页视图
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
            return view('front.'.config('common.view.front.template').'.index')->with('org',$org);
        }
        else dd("企业不存在");
    }


    // 返回（前台）产品页视图
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
            return view('front.'.config('common.view.front.template').'.product.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）产品详情页视图
    public function view_product_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $product = Product::with(['org','admin'])->whereId($decode_id)->first();
        if($product)
        {
            return view('front.'.config('common.view.front.template').'.product.detail')->with('data',$product);
        }
        else dd("产品不存在");
    }


    // 返回（前台）活动页视图
    public function view_activity($org)
    {
//        $query = Softorg::with(['administrators','websites','menus','products','activities','slides','surveys','articles']);
        $query = Softorg::with(['administrators','websites',
            'activities' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.activity.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）活动详情页视图
    public function view_activity_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $activity = Activity::with(['org','admin'])->whereId($decode_id)->first();
        if($activity)
        {
            return view('front.'.config('common.view.front.template').'.activity.detail')->with('data',$activity);
        }
        else dd("活动不存在");
    }


    // 返回（前台）幻灯片列表页视图
    public function view_slide($org)
    {
        $query = Softorg::with(['administrators','websites',
            'slides' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.slide.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）幻灯片详情页视图
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
            return view('front.'.config('common.view.front.template').'.slide.detail')->with('data',$slide);
        }
        else dd("幻灯片不存在");
    }


    // 返回（前台）调研列表页视图
    public function view_survey($org)
    {
        $query = Softorg::with(['administrators','websites',
            'surveys' => function ($query) { $query->orderBy('updated_at', 'desc'); }
        ]);
        if(is_numeric($org)) $org = $query->whereId($org)->first();
        else $org = $query->where('website_name',$org)->first();

        if($org)
        {
            return view('front.'.config('common.view.front.template').'.survey.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）调研详情页视图
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
            return view('front.'.config('common.view.front.template').'.survey.detail')->with('data',$survey);
        }
        else dd("调研不存在");
    }


    // 返回（前台）文章列表页视图
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
            return view('front.'.config('common.view.front.template').'.article.list')->with('org',$org);
        }
        else dd("企业不存在");
    }
    // 返回（前台）文章详情页视图
    public function view_article_detail()
    {
        $encode_id = request('id');
        $decode_id = decode($encode_id);
        if(intval($decode_id) !== 0 && !$decode_id) dd("地址有误");

        $article = Article::with(['org','admin'])->whereId($decode_id)->first();
        if($article)
        {
            return view('front.'.config('common.view.front.template').'.article.detail')->with('data',$article);
        }
        else dd("文章不存在");
    }


    // 回答
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



}