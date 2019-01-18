<?php


$controller = "IndexController";

Route::get('/root', $controller."@index");

Route::get('/website/templates', $controller."@view_website_templates");




/*
 * 样式开发
 */
Route::group(['prefix' => 'case'], function () {

    $controller = "CaseController";

    Route::get('metinfo', $controller."@view_metinfo");

});




/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {


    $controller = "IndexController";
    Route::get('/', $controller.'@view_root');
    Route::get('/root/template/{id?}', $controller.'@view_template_item');
    Route::get('/root/template-list', $controller.'@view_template_list');




    // 前台主页
    Route::group(['prefix' => config('common.org.front.index').'/{org_name}'], function () {

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





/*
 * 后台
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {

        $controller = "AuthController";

        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');

    });


    // 后台管理，需要登录
    Route::group(['middleware' => 'admin'], function () {

        $controller = "AdminController";

        Route::get('/404', $controller.'@view_404');

        Route::get('/', $controller.'@index');

        // 管理员模块
        Route::group(['prefix' => 'administrator'], function () {
            $controller = "AdministratorController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');

            Route::match(['get','post'], 'password/reset', $controller.'@password_reset');

            Route::match(['get','post'], 'list', $controller.'@viewList');
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
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            Route::get('select2_menus', $controller.'@select2_menus');
        });

        //留言模块
        Route::group(['prefix' => 'message'], function () {
            $controller = "MessageController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'list', $controller.'@viewList');
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
 * weixin
 */
Route::group(['prefix' => 'weixin'], function () {

    $controller = "WeixinController";

    Route::match(['get', 'post'],'auth/MP_verify_0m3bPByLDcHKLvIv.txt', function () {
        return "0m3bPByLDcHKLvIv";
    });

    Route::match(['get', 'post'],'auth/MP_verify_eTPw6Fu85pGY5kiV.txt', function () {
        return "eTPw6Fu85pGY5kiV";
    });

    Route::match(['get', 'post'],'auth', $controller."@weixin_auth");


    Route::match(['get', 'post'],'gongzhonghao', $controller."@gongzhonghao");
//    Route::match(['get', 'post'],'root', $controller."@root");
//    Route::match(['get', 'post'],'test', $controller."@test");

});


