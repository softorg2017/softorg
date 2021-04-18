<?php


/*
 * 后台
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {

    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');


    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {

        $controller = "DocAuthController";

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
            $controller = "DocInfoController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');

            Route::match(['get','post'], 'edit/home', $controller.'@homeAction');
            Route::match(['get','post'], 'edit/information', $controller.'@informationAction');
            Route::match(['get','post'], 'edit/introduction', $controller.'@introductionAction');
            Route::match(['get','post'], 'edit/contactus', $controller.'@contactusAction');
            Route::match(['get','post'], 'edit/culture', $controller.'@cultureAction');

        });




    });

});


/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    Route::get('/', function () {
        dd('doc');
    });

    $controller = "DocIndexController";
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

        $controller = "DocIndexController";

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


