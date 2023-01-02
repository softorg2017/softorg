<?php

/*
 * 超级后台
 */
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {


    /*
     * 登录
     */
    Route::group([], function () {

        $controller = "SuperAuthController";

        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');

    });


    /*
     * 后台管理，需要登录
     */
    Route::group(['middleware' => 'super'], function () {


        Route::group(['prefix' => 'sql'], function () {

            $controller = "SuperSqlController";

            Route::get('/init', $controller.'@sql_init');
            Route::get('/insert', $controller.'@sql_insert');

        });




        $controller = "SuperAdminController";


        Route::get('/', $controller.'@index');
        Route::get('index', $controller.'@index');


        /*
         * info
         */
        Route::match(['get','post'], '/info/', $controller.'@view_info_index');
        Route::match(['get','post'], '/info/index', $controller.'@view_info_index');
        Route::match(['get','post'], '/info/edit', $controller.'@operate_info_edit');
        Route::match(['get','post'], '/info/password-reset', $controller.'@operate_info_password_reset');




        /*
         * user
         */
        Route::match(['get','post'], '/user/user_select2_district', $controller.'@operate_user_select2_district');

        Route::match(['get','post'], '/user/user-create', $controller.'@operate_user_user_create');
        Route::match(['get','post'], '/user/user-edit', $controller.'@operate_user_user_edit');

        Route::match(['get','post'], '/user/user-list-for-all', $controller.'@view_user_list_for_all');
        Route::match(['get','post'], '/user/user-list-for-individual', $controller.'@view_user_list_for_individual');
        Route::match(['get','post'], '/user/user-list-for-doc', $controller.'@view_user_list_for_doc');
        Route::match(['get','post'], '/user/user-list-for-org', $controller.'@view_user_list_for_org');
        Route::match(['get','post'], '/user/user-list-for-sponsor', $controller.'@view_user_list_for_sponsor');




        /*
         * item
         */
        Route::match(['get','post'], '/item/item-list-for-all', $controller.'@view_item_list_for_all');
        Route::match(['get','post'], '/item/item-list-for-atom', $controller.'@view_item_list_for_atom');
        Route::match(['get','post'], '/item/item-list-for-doc', $controller.'@view_item_list_for_doc');




        /*
         * district
         */
        Route::match(['get','post'], '/district/district_select2_parent', $controller.'@operate_district_select2_parent');

        Route::match(['get','post'], '/district/district-create', $controller.'@operate_district_create');
        Route::match(['get','post'], '/district/district-edit', $controller.'@operate_district_edit');

        Route::match(['get','post'], '/district/district-list-for-all', $controller.'@view_district_list_for_all');




        /*
         * statistic
         */
        Route::match(['get','post'], '/statistic', $controller.'@view_statistic_index');
        Route::match(['get','post'], '/statistic/index', $controller.'@view_statistic_index');
        Route::match(['get','post'], '/statistic/statistic-index', $controller.'@view_statistic_index');
        Route::match(['get','post'], '/statistic/statistic-user', $controller.'@view_statistic_user');
        Route::match(['get','post'], '/statistic/statistic-item', $controller.'@view_statistic_item');
        Route::match(['get','post'], '/statistic/statistic-all-list', $controller.'@view_statistic_all_list');






        Route::match(['get','post'], '/user/user-login', $controller.'@operate_user_user_login');

        Route::match(['get','post'], 'org/login', $controller.'@loginAction');

        Route::match(['get','post'], 'org/list', $controller.'@view_org_list');
        Route::match(['get','post'], 'org/create', $controller.'@createAction');
        Route::match(['get','post'], 'org/edit', $controller.'@editAction');

        Route::match(['get','post'], 'org/menu/list', $controller.'@view_org_menu_list');
        Route::match(['get','post'], 'org/item/list', $controller.'@view_org_item_list');

        Route::match(['get','post'], 'list/product', $controller.'@view_product_list');
        Route::match(['get','post'], 'list/article', $controller.'@view_article_list');
        Route::match(['get','post'], 'list/activity', $controller.'@view_activity_list');
        Route::match(['get','post'], 'list/survey', $controller.'@view_survey_list');

    });


});




/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wx.share'], function () {

    Route::get('/', function () {
        dd('super');
    });

    $controller = "SuperIndexController";

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



