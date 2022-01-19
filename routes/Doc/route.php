<?php


/*
 * 管理员后台
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {

    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');



    // 后台管理，需要登录
    Route::group(['middleware' => 'doc.admin'], function () {

        Route::get('/', function () {
            dd('doc1');
            return view('doc.admin.index');
        });

        // 机构模块
        Route::group(['prefix' => 'info'], function () {
            $controller = "DocInfoController";

            Route::get('/', $controller.'@index');
            Route::get('index', $controller.'@index');
            Route::match(['get','post'], 'edit', $controller.'@editAction');


        });

    });

});




/*
 * Home
 */
Route::group(['prefix' => 'home', 'namespace' => 'Home'], function () {

    /*
     * 需要登录
     */
    Route::group(['middleware' => ['doc','doc.admin']], function () {

        $controller = 'DocHomeController';


        Route::get('/', $controller.'@index');
        Route::get('/404', $controller.'@view_404');




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
        Route::post('/item/content-enable', $controller.'@operate_item_content_enable');
        Route::post('/item/content-disable', $controller.'@operate_item_content_disable');

        Route::match(['get','post'], '/item/item-list', $controller.'@view_item_list');
        Route::match(['get','post'], '/item/item-list-for-all', $controller.'@view_item_list_for_all');
        Route::match(['get','post'], '/item/item-list-for-menu_type', $controller.'@view_item_list_for_menu_type');
        Route::match(['get','post'], '/item/item-list-for-time_line', $controller.'@view_item_list_for_time_line');
        Route::match(['get','post'], '/item/item-list-for-debase', $controller.'@view_item_list_for_debase');




        Route::match(['get','post'], '/user/my-administrator-list', $controller.'@view_user_my_administrator_list');
        Route::match(['get','post'], '/user/relation-administrator', $controller.'@operate_user_relation_administrator');
        Route::match(['get','post'], '/user/administrator-relation-add', $controller.'@operate_user_administrator_relation_add');
        Route::match(['get','post'], '/user/administrator-relation-add-bulk', $controller.'@operate_user_administrator_relation_add_bulk');

        Route::match(['get','post'], '/user/administrator-relation-remove', $controller.'@operate_user_administrator_relation_remove');








        // 【info】
        Route::group(['prefix' => 'info'], function () {

            $controller = 'HomeController';

            Route::get('index', $controller.'@info_index');
            Route::match(['get','post'], 'edit', $controller.'@infoEditAction');

            Route::match(['get','post'], 'password/reset', $controller.'@passwordResetAction');

        });


        // 内容
        Route::group(['prefix' => 'item'], function () {

            $controller = 'ItemController';

            Route::get('/', $controller.'@index');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('share', $controller.'@shareAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');


            // 内容管理
            Route::group(['prefix' => 'content'], function () {

                $controller = 'ItemController';

                Route::match(['get','post'], '/', $controller.'@content_viewIndex');
                Route::match(['get','post'], '/menutype', $controller.'@content_menutype_viewIndex');
                Route::match(['get','post'], '/timeline', $controller.'@content_timeline_viewIndex');

                Route::match(['get','post'], 'edit', $controller.'@content_editAction');
                Route::match(['get','post'], 'edit/menutype', $controller.'@content_menutype_editAction');
                Route::match(['get','post'], 'edit/timeline', $controller.'@content_timeline_editAction');

                Route::post('get', $controller.'@content_getAction');
                Route::post('delete', $controller.'@content_deleteAction');
                Route::post('enable', $controller.'@content_enableAction');
                Route::post('disable', $controller.'@content_disableAction');

            });

            // 时间线类型
            Route::group(['prefix' => 'point'], function () {

                $controller = 'PointController';

                Route::match(['get','post'], '/', $controller.'@viewList');
                Route::get('create', $controller.'@createAction');
                Route::match(['get','post'], 'edit', $controller.'@editAction');
                Route::match(['get','post'], 'list', $controller.'@viewList');
                Route::post('delete', $controller.'@deleteAction');
                Route::post('enable', $controller.'@enableAction');
                Route::post('disable', $controller.'@disableAction');

            });

            Route::get('select2_menus', $controller.'@select2_menus');

        });


        // 作者
        Route::group(['prefix' => 'course'], function () {

            $controller = 'CourseController';

            Route::get('/', $controller.'@index');
            Route::get('create', $controller.'@createAction');
            Route::match(['get','post'], 'edit', $controller.'@editAction');
            Route::match(['get','post'], 'list', $controller.'@viewList');
            Route::post('delete', $controller.'@deleteAction');
            Route::post('enable', $controller.'@enableAction');
            Route::post('disable', $controller.'@disableAction');

            // 作者
            Route::group(['prefix' => 'content'], function () {

                $controller = 'CourseController';

                Route::match(['get','post'], '/', $controller.'@course_content_view_index');
                Route::match(['get','post'], 'edit', $controller.'@course_content_editAction');
                Route::post('get', $controller.'@course_content_getAction');
                Route::post('delete', $controller.'@course_content_deleteAction');
            });

            Route::get('select2_menus', $controller.'@select2_menus');

        });



        // 收藏
        Route::group(['prefix' => 'collect'], function () {

            $controller = 'OtherController';

            Route::match(['get','post'], 'course/list', $controller.'@collect_course_viewList');
            Route::match(['get','post'], 'chapter/list', $controller.'@collect_chapter_viewList');
            Route::post('course/delete', $controller.'@collect_course_deleteAction');
            Route::post('chapter/delete', $controller.'@collect_chapter_deleteAction');

        });

        // 点赞
        Route::group(['prefix' => 'favor'], function () {

            $controller = 'OtherController';

            Route::match(['get','post'], 'course/list', $controller.'@favor_course_viewList');
            Route::match(['get','post'], 'chapter/list', $controller.'@favor_chapter_viewList');
            Route::post('course/delete', $controller.'@favor_course_deleteAction');
            Route::post('chapter/delete', $controller.'@favor_chapter_deleteAction');

        });

        // 消息
        Route::group(['prefix' => 'notification'], function () {

            $controller = 'NotificationController';

            Route::get('comment', $controller.'@comment');
            Route::get('favor', $controller.'@favor');

        });


    });

});




/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wx.share'], function () {


    $controller = "DocIndexController";

    Route::get('/', $controller.'@view_root');

//    Route::get('/item', $controller.'@view_item');
    Route::get('/item/{?id}', $controller.'@view_item');


    /*
     * 需要登录
     */
    Route::group(['middleware' => ['doc','doc.admin']], function () {

        $controller = "DocIndexController";


        Route::get('/mine/my-info-index', $controller.'@view_my_info_index');
        Route::match(['get','post'], '/mine/my-info-edit', $controller.'@operate_my_info_edit');
        Route::match(['get','post'], '/mine/my-info-introduction-edit', $controller.'@operate_my_info_introduction_edit');




        Route::get('/mine/item-mine', $controller.'@view_item_list_for_mine');
        Route::get('/mine/item-my-original', $controller.'@view_item_list_for_my_original');

        Route::get('/mine/item-my-todo-list', $controller.'@view_item_list_for_my_todo_list');
        Route::get('/mine/item-my-schedule', $controller.'@view_item_list_for_my_schedule');

        Route::get('/mine/item-my-favor', $controller.'@view_item_list_for_my_favor');
        Route::get('/mine/item-my-collection', $controller.'@view_item_list_for_my_collection');




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




    });



    Route::get('/item/{id?}', $controller.'@view_item');







});


