<?php


/*
 * 前端
 */
Route::group(['namespace' => 'Front'], function () {


    $controller = "IndexController";

    Route::get('/root', $controller."@index");

    Route::get('/website/templates', $controller."@view_website_templates");







    Route::group(['middleware' => 'wechat.share'], function () {


        $controller = "RootIndexController";

        Route::match(['get', 'post'],'login-link', $controller."@login_link");
        Route::get('/logout', $controller."@logout");


        Route::get('/', $controller.'@view_root');
        Route::get('/user/{id?}', $controller.'@view_user');
        Route::get('/item/{id?}', $controller.'@view_item');

        Route::get('/root/template/{id?}', $controller.'@view_template_item');
        Route::get('/root/template-list', $controller.'@view_template_list');


        Route::group(['middleware' => ['login.turn']], function () {

            $controller = "RootIndexController";

            Route::post('user/relation/add', $controller.'@user_relation_add');
            Route::post('user/relation/remove', $controller.'@user_relation_remove');







            Route::get('/home/notification', $controller.'@view_home_notification');

            Route::group(['middleware' => 'notification'], function () {

                $controller = "RootIndexController";

                Route::get('/my-info/index', $controller.'@view_my_info_index');
                Route::match(['get','post'], '/my-info/edit', $controller.'@view_my_info_edit');

                Route::get('/my-cards', $controller.'@view_my_cards');
                Route::get('/my-follow', $controller.'@view_my_follow');
                Route::get('/my-favor', $controller.'@view_my_favor');
                Route::get('/my-notification', $controller.'@view_my_notification');








                Route::get('/home/mine/original', $controller.'@view_home_mine_original');

                Route::get('/home/mine/todolist', $controller.'@view_home_mine_todolist');
                Route::get('/home/mine/schedule', $controller.'@view_home_mine_schedule');

                Route::get('/home/mine/collection', $controller.'@view_home_mine_collection');
                Route::get('/home/mine/favor', $controller.'@view_home_mine_favor');

                Route::get('/home/mine/discovery', $controller.'@view_home_mine_discovery');
                Route::get('/home/mine/follow', $controller.'@view_home_mine_follow');
                Route::get('/home/mine/circle', $controller.'@view_home_mine_circle');

                // 添加&编辑
                Route::get('/home/mine/item/create', $controller.'@view_home_mine_item_create');
                Route::match(['get','post'], '/home/mine/item/edit', $controller.'@view_home_mine_item_edit');
                Route::match(['get','post'], '/home/mine/item/edit/menutype', $controller.'@view_home_mine_item_edit_menutype');
                Route::match(['get','post'], '/home/mine/item/edit/timeline', $controller.'@view_home_mine_item_edit_timeline');


                Route::get('/home/relation/follow', $controller.'@view_relation_follow');
                Route::get('/home/relation/fans', $controller.'@view_relation_fans');

            });

        });




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
        Route::group(['prefix' => 'org'], function () {

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


});




/*
 * weixin
 */
Route::group(['prefix' => 'weixin'], function () {

    $wxController = "WeixinController";

    Route::match(['get', 'post'],'auth/MP_verify_0m3bPByLDcHKLvIv.txt', function () {
        return "0m3bPByLDcHKLvIv";
    });

    Route::match(['get', 'post'],'auth/MP_verify_eTPw6Fu85pGY5kiV.txt', function () {
        return "eTPw6Fu85pGY5kiV";
    });

    Route::match(['get', 'post'],'auth/MP_verify_enRXVHgfnjolnsIN.txt', function () {
        return "enRXVHgfnjolnsIN";
    });

    Route::match(['get', 'post'],'auth', $wxController."@weixin_auth");
    Route::match(['get', 'post'],'login', $wxController."@weixin_login");


    Route::match(['get', 'post'],'gongzhonghao', $wxController."@gongzhonghao");
    Route::match(['get', 'post'],'root', $wxController."@root");
    Route::match(['get', 'post'],'test', $wxController."@test");

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





