<?php


/*
 * 后台
 */
Route::group(['prefix' => config('common.org.admin.prefix'), 'namespace' => 'Admin'], function () {

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
    Route::group(['middleware' => 'org.admin'], function () {

        Route::get('/', function () {
            return view('org.admin.index');
        });

        Route::get('/download_qrcode', function () {
            return view('org.admin.index');
        });

        Route::match(['get','post'], 'download_root_qrcode', 'SoftorgController@download_root_qrcode');
        Route::match(['get','post'], 'download-qrcode', 'SoftorgController@download_qrcode');

        // 机构模块
        Route::group(['prefix' => 'info'], function () {
            $controller = "InfoController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');

            Route::match(['get','post'], 'edit/home', $controller.'@homeAction');
            Route::match(['get','post'], 'edit/information', $controller.'@informationAction');
            Route::match(['get','post'], 'edit/introduction', $controller.'@introductionAction');
            Route::match(['get','post'], 'edit/contactus', $controller.'@contactusAction');
            Route::match(['get','post'], 'edit/culture', $controller.'@cultureAction');

        });

        // 机构模块
        Route::group(['prefix' => 'softorg'], function () {
            $controller = "SoftorgController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');

            Route::match(['get','post'], 'edit/home', $controller.'@homeAction');
            Route::match(['get','post'], 'edit/information', $controller.'@informationAction');
            Route::match(['get','post'], 'edit/introduction', $controller.'@introductionAction');
            Route::match(['get','post'], 'edit/contactus', $controller.'@contactusAction');
            Route::match(['get','post'], 'edit/culture', $controller.'@cultureAction');

        });

        // 管理员模块
        Route::group(['prefix' => 'administrator'], function () {
            $controller = "AdministratorController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');

            Route::match(['get','post'], 'password/reset', $controller.'@password_reset');

            Route::match(['get','post'], 'list', $controller.'@viewList');
        });


        // 流量统计
        Route::group(['prefix' => 'statistics'], function () {
            $controller = "StatisticsController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');

            Route::get('page', $controller.'@page');

            Route::get('website', $controller.'@website');
            Route::get('menu', $controller.'@menu');
            Route::get('item', $controller.'@item');
        });

        // 网站模块
        Route::group(['prefix' => 'website'], function () {
            $controller = "WebsiteController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');

            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');

            Route::match(['get','post'], 'edit/home', $controller.'@homeAction');
            Route::match(['get','post'], 'edit/introduction', $controller.'@introductionAction');
            Route::match(['get','post'], 'edit/information', $controller.'@informationAction');

            Route::match(['get','post'], 'style', $controller.'@viewStyle');
        });

        // 样式模块
        Route::group(['prefix' => 'module'], function () {
            $controller = "ModuleController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::match(['get','post'], 'sort', $controller.'@sortAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            Route::post('delete_multiple_option', $controller.'@deleteMultipleOption');
        });

        // 目录模块
        Route::group(['prefix' => 'menu'], function () {
            $controller = "MenuController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::match(['get','post'], 'items', $controller.'@viewItemsList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::match(['get','post'], 'sort', $controller.'@sortAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');
        });

        // 内容模块
        Route::group(['prefix' => 'item'], function () {
            $controller = "ItemController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::match(['get','post'], 'menu', $controller.'@viewMenuItemsList');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            Route::get('select2_menus', $controller.'@select2_menus');
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


/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    $controller = "IndexController";
    Route::get('item/{id?}', $controller.'@view_item');
    Route::get('org-item/{id?}', $controller.'@view_item');

    // 前台主页
    Route::group(['prefix' => 'org/{org_name}'], function () {

        $controller = "IndexController";

        Route::get('/',$controller.'@root');
//    Route::get('/index', $controller.'@index');
        Route::get('/home', $controller.'@home');
        Route::get('/information', $controller.'@information');
        Route::get('/introduction', $controller.'@introduction');
        Route::get('/contactus', $controller.'@contactus');
        Route::get('/culture', $controller.'@culture');

    });

    // 前台
    Route::group(['prefix' => config('common.org.front.prefix')], function () {

        $controller = "IndexController";

        Route::get('menu/{id?}', $controller.'@view_menu');
        Route::get('item/{id?}', $controller.'@view_item');

        Route::get('product/{id?}', $controller.'@view_product');
        Route::get('article/{id?}', $controller.'@view_article');
        Route::get('activity/{id?}', $controller.'@view_activity');
        Route::get('slide/{id?}', $controller.'@view_slide');
        Route::get('survey/{id?}', $controller.'@view_survey');

        Route::get('activity/apply', $controller.'@view_activity_apply');
        Route::match(['get','post'], '/apply', $controller.'@apply');
        Route::match(['get','post'], '/apply/activation', $controller.'@apply_activation');
        Route::match(['get','post'], '/sign', $controller.'@sign');
        Route::match(['get','post'], '/answer', $controller.'@answer');

        Route::match(['get','post'], '/share', $controller.'@share');
    });

});


