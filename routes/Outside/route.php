<?php


/*
 * 超级后台
 */
Route::group(['prefix' => 'outside/admin', 'namespace' => 'Admin'], function () {


    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {

        $controller = "AuthController";

        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');

    });


    // 后台管理，需要登录
    Route::group(['middleware' => 'outside.admin'], function () {

        $controller = "OutsideController";

        Route::get('/', $controller.'@index');
        Route::get('index', $controller.'@index');

    });



});
