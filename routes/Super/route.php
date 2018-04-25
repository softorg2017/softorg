<?php


/*
 * 超级后台
 */
Route::group(['prefix' => 'super/admin', 'namespace' => 'Admin'], function () {


    // 登录
    Route::group(['namespace' => 'Auth'], function () {
        $controller = "AuthController";
        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');
    });


    // 后台管理，需要登录
    Route::group(['middleware' => 'super.admin'], function () {

        $controller = "SuperController";

        Route::get('/', $controller.'@index');
        Route::get('index', $controller.'@index');

        Route::match(['get','post'], 'org/list', $controller.'@view_org_list');
        Route::match(['get','post'], 'org/menu/list', $controller.'@view_org_menu_list');
        Route::match(['get','post'], 'org/item/list', $controller.'@view_org_item_list');

        Route::match(['get','post'], 'list/product', $controller.'@view_product_list');
        Route::match(['get','post'], 'list/article', $controller.'@view_article_list');
        Route::match(['get','post'], 'list/activity', $controller.'@view_activity_list');
        Route::match(['get','post'], 'list/survey', $controller.'@view_survey_list');

    });



});
