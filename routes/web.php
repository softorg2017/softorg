<?php

require __DIR__.'/frontend.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return view('test');
});

Route::get('/home', function () {
    return view('front.'.config('common.view.front.template').'.index');
});

/*
 * TEST
 */
Route::group(['prefix' => 'test'], function () {

    $controller = "TestController";

    Route::get('/index', function () {
        return view('frontend.home.index');
    });
    Route::get('/detail', function () {
        return view('frontend.home.detail');
    });
    Route::get('/list', function () {
        return view('frontend.home.list');
    });

    Route::get('url', function () {
        echo "url()->full() ---- ".url()->full()."<br>";
        echo "url()->current() ---- ".url()->current()."<br>";
        echo "url()->previous() ---- ".url()->previous()."<br><br>";

        echo "request()->url() ---- ".request()->url()."<br>";
        echo "request()->getRequestUri() ---- ".request()->getRequestUri()."<br><br>";

        echo '$_SERVER["PHP_SELF"] ---- '.$_SERVER['PHP_SELF']."<br>";
        echo '$_SERVER["HTTP_HOST"] ---- '.$_SERVER['HTTP_HOST']."<br>";
        echo '$_SERVER["SERVER_NAME"] ---- '.$_SERVER['SERVER_NAME']."<br>";
        echo '$_SERVER["SERVER_PORT"] ---- '.$_SERVER['SERVER_PORT']."<br>";
        echo '$_SERVER["REQUEST_URI"] ---- '.$_SERVER['REQUEST_URI']."<br>";
        echo '$_SERVER["QUERY_STRING"] ---- '.$_SERVER["QUERY_STRING"]."<br><br>";
//        echo '$_SERVER["HTTP_REFERER"] ---- '.$_SERVER['HTTP_REFERER']."<br>";

        echo request()->route()->getName()."<br>";
        echo request()->route()->getActionName()."<br><br>";

        echo public_path('uploads')."<br>";
        echo base_path('uploads')."<br>";
        echo app_path('uploads')."<br>";
        echo resource_path('uploads')."<br>";
        echo storage_path('uploads')."<br>";
    });
    // Route::get('/send/email', $controller.'@send_email');

    // Route::get('/send_sms', "{$controller}@send_sms");

     Route::get('/image', "{$controller}@image");
});

/*后台*/
Route::group(['prefix' => 'common'], function () {

    $controller = "CommonController";

    Route::match(['get','post'], 'change_captcha', $controller.'@change_captcha');
});


/*后台*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');



    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {
        $controller = "AuthController";
        Route::match(['get','post'], 'register', $controller.'@register');
        Route::match(['get','post'], 'register/org', $controller.'@register_org');
        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');
        Route::match(['get','post'], 'activation', $controller.'@activation');
    });



    // 后台管理，需要登录
    Route::group(['middleware' => 'admin'], function () {

        Route::get('/', function () {
            return view('admin.index');
        });

        Route::get('/download_qrcode', function () {
            return view('admin.index');
        });

        Route::match(['get','post'], 'download_qrcode', 'SoftorgController@download_qrcode');

        // 机构模块
        Route::group(['prefix' => 'softorg'], function () {
            $controller = "SoftorgController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
        });

        // 管理员模块
        Route::group(['prefix' => 'administrator'], function () {
            $controller = "AdministratorController";

            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::match(['get','post'], 'password/reset', $controller.'@password_reset');
        });


        // 流量统计
        Route::group(['prefix' => 'statistics'], function () {
            $controller = "StatisticsController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::get('page', $controller.'@page');
        });

        // 网站模块
        Route::group(['prefix' => 'website'], function () {
            $controller = "WebsiteController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::get('statistics', $controller.'@statistics');

            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');

            Route::match(['get','post'], 'edit/home', $controller.'@homeAction');
            Route::match(['get','post'], 'edit/introduction', $controller.'@introductionAction');
            Route::match(['get','post'], 'edit/information', $controller.'@informationAction');
        });


        // 产品模块
        Route::group(['prefix' => 'product'], function () {
            $controller = "ProductController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');
        });

        // 目录模块
        Route::group(['prefix' => 'menu'], function () {
            $controller = "MenuController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');
        });

        // 活动模块
        Route::group(['prefix' => 'activity'], function () {
            $controller = "ActivityController";

            Route::get('/', $controller.'@indexAction');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');
        });

        // 幻灯片模块
        Route::group(['prefix' => 'slide'], function () {
            $controller = "SlideController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit/{id?}', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            // 幻灯页模块
            Route::group(['prefix' => 'page'], function () {
                $controller = "PageController";

                Route::get('/', $controller.'@index');
                Route::get('index', $controller.'@index');
                Route::match(['get','post'], 'list', $controller.'@viewList');
                Route::get('create', $controller.'@createAction');
                Route::match(['get','post'], 'edit/{id?}', $controller.'@editAction');
                Route::post('order', $controller.'@orderAction');
                Route::get('delete', $controller.'@deleteAction');
            });
        });

        // 调研
        Route::group(['prefix' => 'survey'], function () {
            $controller = "SurveyController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('sort', $controller.'@sortAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');
        });

        // 问题
        Route::group(['prefix' => 'question'], function () {
            $controller = "QuestionController";
            
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('option/delete', $controller.'@deleteOptionAction');
        });

        // 文章模块
        Route::group(['prefix' => 'article'], function () {
            $controller = "ArticleController";

            Route::get('/', $controller.'@indexAction');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');
        });

        // 回答模块
        Route::group(['prefix' => 'answer'], function () {
            $controller = "AnswerController";

            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::match(['get','post'], 'analysis', $controller.'@view_analysis');
            Route::match(['get','post'], 'detail', $controller.'@view_detail');
        });

        // 报名模块
        Route::group(['prefix' => 'apply'], function () {
            $controller = "ApplyController";

            Route::match(['get','post'], 'list', $controller.'@viewList');
        });

        // 签到模块
        Route::group(['prefix' => 'sign'], function () {
            $controller = "SignController";

            Route::match(['get','post'], 'list', $controller.'@viewList');
        });

        Route::group(['middleware' => 'page-mine'], function () {
            Route::get('delete','DisplayController@item_delete');
            Route::get('share','DisplayController@item_share');
        });

    });

});



/*前台*/
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    $controller = "SoftorgController";

    Route::get('/product', $controller.'@view_product_detail');
    Route::get('/activity', $controller.'@view_activity_detail');
    Route::get('/activity/apply', $controller.'@view_activity_apply');
    Route::get('/slide', $controller.'@view_slide_detail');
    Route::get('/survey', $controller.'@view_survey_detail');
    Route::get('/article', $controller.'@view_article_detail');

    Route::match(['get','post'], '/apply', $controller.'@apply');
    Route::match(['get','post'], '/apply/activation', $controller.'@apply_activation');
    Route::match(['get','post'], '/sign', $controller.'@sign');
    Route::match(['get','post'], '/answer', $controller.'@answer');

    Route::match(['get','post'], '/share', $controller.'@share');

});

/*前台*/
Route::group(['prefix' => config('common.website.front.prefix').'/{org_name}', 'namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    $controller = "SoftorgController";

    Route::get('/',$controller.'@root');
//    Route::get('/index', $controller.'@index');
    Route::get('/home', $controller.'@home');
    Route::get('/introduction', $controller.'@introduction');
    Route::get('/information', $controller.'@information');

    Route::get('/product', $controller.'@product');
    Route::get('/product/detail', $controller.'@product_detail');

    Route::get('/activity', $controller.'@activity');
    Route::get('/activity/detail', $controller.'@activity_detail');

    Route::get('/slide', $controller.'@slide');
    Route::get('/slide/detail', $controller.'@slide_detail');

    Route::get('/survey', $controller.'@survey');
    Route::get('/survey/detail', $controller.'@survey_detail');

    Route::get('/article', $controller.'@article');
    Route::get('/article/detail', $controller.'@article_detail');

});


/*前台注册与登录*/
Route::group(['prefix' => 'user', 'namespace' => 'Front'], function () {
    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {
        Route::match(['get','post'], 'register','AuthController@register');
        Route::match(['get','post'], 'login','AuthController@login');
        Route::match(['get','post'], 'logout','AuthController@logout');
    });
});



/*超级后台*/
Route::group(['prefix' => 'super', 'namespace' => 'Super', 'middleware' => 'super'], function () {

    $controller = "SuperController";

    Route::get('/', $controller.'@index');
    Route::match(['get','post'], 'list/softorg', $controller.'@view_softorg_list');
    Route::match(['get','post'], 'list/product', $controller.'@view_product_list');
    Route::match(['get','post'], 'list/article', $controller.'@view_article_list');
    Route::match(['get','post'], 'list/activity', $controller.'@view_activity_list');
    Route::match(['get','post'], 'list/survey', $controller.'@view_survey_list');
});










