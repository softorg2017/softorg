<?php

/*
 * 后台管理
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {


    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');


    /*
     * 注册登录
     */
    Route::group([], function () {

        $controller = "GPSAuthController";

        Route::match(['get','post'], 'register', $controller.'@register');
        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');
        Route::match(['get','post'], 'activation', $controller.'@activation');

    });


    /*
     * 后台管理，需要登录
     */
    Route::group(['middleware' => 'gps'], function () {

        $controller = "GPSAdminController";

        Route::get('/', function () {
            return view('gps.admin.index');
        });

        //
        Route::match(['get','post'], '/navigation',$controller.'@navigation');
        Route::match(['get','post'], '/test-list',$controller.'@test_list');
        Route::match(['get','post'], '/tool-list',$controller.'@tool_list');
        Route::match(['get','post'], '/template-list',$controller.'@template_list');

        Route::match(['get','post'], '/tool',$controller.'@tool');




        Route::match(['get','post'], '/item/item-get', $controller.'@operate_item_item_get');
        Route::match(['get','post'], '/item/item-delete', $controller.'@operate_item_item_delete');
        Route::match(['get','post'], '/item/item-restore', $controller.'@operate_item_item_restore');
        Route::match(['get','post'], '/item/item-delete-permanently', $controller.'@operate_item_item_delete_permanently');
        Route::match(['get','post'], '/item/item-publish', $controller.'@operate_item_item_publish');

        Route::match(['get','post'], '/item/item-admin-disable', $controller.'@operate_item_admin_disable');
        Route::match(['get','post'], '/item/item-admin-enable', $controller.'@operate_item_admin_enable');


    });


});




/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    Route::get('/', function () {
        dd('gps');
    });

    $controller = "GPSIndexController";

    Route::get('/developing', $controller."@view_developing");

    Route::get('/template/test', $controller."@view_template_test");
    Route::get('/template/metinfo', $controller."@view_template_metinfo");


});

