<?php


/*
 * 前端
 */
Route::group(['namespace' => 'Front'], function () {


    $controller = "IndexController";

    Route::get('/root', $controller."@index");

    Route::get('/website/templates', $controller."@view_website_templates");




    // 微信分享页面
    Route::group(['middleware' => 'wx.share'], function () {


        $controller = "RootIndexController";

        Route::match(['get', 'post'],'login-link', $controller."@login_link");
        Route::get('/logout', $controller."@logout");

        Route::match(['get', 'post'],'record/share', $controller."@record_share");


        Route::get('/', $controller.'@view_root');
        Route::get('/introduction', $controller.'@view_introduction');

        Route::get('/user/{id?}', $controller.'@view_user');
//        Route::get('/item/{id?}', $controller.'@view_item');

//        Route::get('/user', $controller.'@view_user');
//        Route::get('/item', $controller.'@view_item');

        Route::get('/root/template/{id?}', $controller.'@view_template_item');
        Route::get('/root/template-list', $controller.'@view_template_list');




        /*
         * 需要登录
         */

        // 提示登录
        Route::group(['middleware' => ['login.alert']], function () {

            $controller = "RootIndexController";

            Route::post('user/relation/add', $controller.'@user_relation_add');
            Route::post('user/relation/remove', $controller.'@user_relation_remove');

        });


        // 登录跳转
        Route::group(['middleware' => ['login.turn']], function () {

            $controller = "RootIndexController";


            Route::get('/mine/my-notification', $controller.'@view_home_notification');

            Route::match(['get','post'], '/my-doc-account-create', $controller.'@operate_my_doc_account_create');
            Route::match(['get','post'], '/my-doc-account-edit', $controller.'@operate_my_doc_account_edit');
            Route::get('/my-doc-account-list', $controller.'@view_my_doc_account_list');
            Route::get('/my-doc-account-login', $controller.'@operate_my_doc_account_login');

            Route::get('/login-my-doc', $controller.'@operate_login_my_doc');


            Route::match(['get','post'], '/item/item-create', $controller.'@operate_item_item_create');
            Route::match(['get','post'], '/item/item-edit', $controller.'@operate_item_item_edit');
            Route::post('/item/item-delete', $controller.'@operate_item_item_delete');
            Route::post('/item/item-restore', $controller.'@operate_item_item_restore');
            Route::post('/item/item-delete-permanently', $controller.'@operate_item_item_delete_permanently');
            Route::post('/item/item-publish', $controller.'@operate_item_item_publish');
            Route::post('/item/item-complete', $controller.'@operate_item_item_complete');

            Route::match(['get','post'], '/item/content-management', $controller.'@view_item_content_management');
            Route::post('/item/content-edit', $controller.'@operate_item_content_edit');
            Route::post('/item/content-get', $controller.'@operate_item_content_get');
            Route::post('/item/content-delete', $controller.'@operate_item_content_delete');
            Route::post('/item/content-publish', $controller.'@operate_item_content_publish');
            Route::post('/item/content-enable', $controller.'@operate_item_content_enable');
            Route::post('/item/content-disable', $controller.'@operate_item_content_disable');




            // 点赞
            Route::post('/item/item-add-favor', $controller.'@operate_item_add_favor');
            Route::post('/item/item-remove-favor', $controller.'@operate_item_remove_favor');
            // 收藏
            Route::post('/item/item-add-collection', $controller.'@operate_item_add_collection');
            Route::post('/item/item-remove-collection', $controller.'@operate_item_remove_collection');
            // 待办事
            Route::post('/item/item-add-todo-list', $controller.'@operate_item_add_todo_list');
            Route::post('/item/item-remove-todo-list', $controller.'@operate_item_remove_todo_list');
            // 日程
            Route::post('/item/item-add-schedule', $controller.'@operate_item_add_schedule');
            Route::post('/item/item-remove-schedule', $controller.'@operate_item_remove_schedule');
            // 转发
            Route::post('/item/item-forward', $controller.'@item_forward');



            Route::get('/mine/item-mine', $controller.'@view_item_list_for_mine');
            Route::get('/mine/item-my-original', $controller.'@view_item_list_for_my_original');

            Route::get('/mine/item-my-todo-list', $controller.'@view_item_list_for_my_todo_list');
            Route::get('/mine/item-my-schedule', $controller.'@view_item_list_for_my_schedule');

            Route::get('/mine/item-my-favor', $controller.'@view_item_list_for_my_favor');
            Route::get('/mine/item-my-collection', $controller.'@view_item_list_for_my_collection');



            // 消息通知
            Route::group(['middleware' => 'notification'], function () {

                $controller = "RootIndexController";


                Route::get('/mine/my-info-index', $controller.'@view_my_info_index');
                Route::match(['get','post'], '/mine/my-info-edit', $controller.'@view_my_info_edit');
                Route::match(['get','post'], '/mine/my-introduction/edit', $controller.'@view_my_introduction_edit');

                Route::get('/mine/my-card', $controller.'@view_my_card_index');
                Route::match(['get','post'], '/mine/my-card-edit', $controller.'@view_my_card_edit');

                Route::get('/mine/my-cards-case', $controller.'@view_my_cards_case');

                Route::get('/mine/my-follow', $controller.'@view_my_follow');
                Route::get('/mine/my-favor', $controller.'@view_my_favor');
                Route::get('/mine/my-collection', $controller.'@view_my_collection');
                Route::get('/mine/my-notification', $controller.'@view_my_notification');








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





        Route::get('/item/{id?}', $controller.'@view_item');








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





