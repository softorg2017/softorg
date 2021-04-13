<?php


/*
 * 后台
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {

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
    Route::group(['middleware' => 'doc.admin'], function () {

        Route::get('/', function () {
            dd('doc');
            return view('doc.admin.index');
        });


        Route::match(['get','post'], 'download_root_qr_code', 'SoftorgController@download_root_qrcode');
        Route::match(['get','post'], 'download-qr-code', 'SoftorgController@download_qrcode');

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
            Route::match(['get','post'], 'edit/contact-us', $controller.'@contact_usAction');
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

    });

});


/*
 * 前台
 */
Route::group(['namespace' => 'Frontend', 'middleware' => 'wechat.share'], function () {

    Route::get('/', function () {
        dd('doc');
    });

    $controller = "IndexController";
    Route::get('item/{id?}', $controller.'@view_item');
    Route::get('org-item/{id?}', $controller.'@view_item');

    // 前台主页
    Route::group(['prefix' => 'org/{org_name}'], function () {

        $controller = "IndexController";

//        Route::get('/',$controller.'@root');
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


