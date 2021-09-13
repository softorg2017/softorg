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
            dd('doc');
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
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    Route::get('/', function () {
        dd('doc.front');
    });

    $controller = "DocIndexController";

    Route::get('item/{id?}', $controller.'@view_item');


    // 前台
    Route::group([], function () {

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


