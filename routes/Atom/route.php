<?php

/*
 * 原子系统
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {


    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');


    /*
     * 注册登录
     */
    Route::group([], function () {

        $controller = "AtomAuthController";

        Route::match(['get','post'], 'register', $controller.'@register');
        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');
        Route::match(['get','post'], 'activation', $controller.'@activation');

    });


    /*
     * 后台管理，需要登录
     */
    Route::group(['middleware' => 'atom'], function () {

        $controller = "AtomAdminController";

        Route::get('/', function () {
            return view('atom.admin.index');
        });


        // item
        Route::match(['get','post'], '/item/select2_people', $controller.'@operate_item_select2_people');

        Route::match(['get','post'], '/item/item-list', $controller.'@view_item_item_list');
        Route::match(['get','post'], '/item/item-all-list', $controller.'@view_item_all_list');
        Route::match(['get','post'], '/item/item-people-list', $controller.'@view_item_people_list');
        Route::match(['get','post'], '/item/item-object-list', $controller.'@view_item_object_list');
        Route::match(['get','post'], '/item/item-product-list', $controller.'@view_item_product_list');
        Route::match(['get','post'], '/item/item-event-list', $controller.'@view_item_event_list');
        Route::match(['get','post'], '/item/item-conception-list', $controller.'@view_item_conception_list');


        Route::match(['get','post'], '/item/item-create', $controller.'@operate_item_item_create');
        Route::match(['get','post'], '/item/item-edit', $controller.'@operate_item_item_edit');

        Route::match(['get','post'], '/item/item-people-create', $controller.'@operate_item_people_create');
        Route::match(['get','post'], '/item/item-people-edit', $controller.'@operate_item_people_edit');

        Route::match(['get','post'], '/item/item-object-create', $controller.'@operate_item_object_create');
        Route::match(['get','post'], '/item/item-object-edit', $controller.'@operate_item_object_edit');

        Route::match(['get','post'], '/item/item-product-create', $controller.'@operate_item_product_create');
        Route::match(['get','post'], '/item/item-product-edit', $controller.'@operate_item_product_edit');

        Route::match(['get','post'], '/item/item-event-create', $controller.'@operate_item_event_create');
        Route::match(['get','post'], '/item/item-event-edit', $controller.'@operate_item_event_edit');

        Route::match(['get','post'], '/item/item-conception-create', $controller.'@operate_item_conception_create');
        Route::match(['get','post'], '/item/item-conception-edit', $controller.'@operate_item_conception_edit');


        Route::match(['get','post'], '/item/item-get', $controller.'@operate_item_item_get');
        Route::match(['get','post'], '/item/item-delete', $controller.'@operate_item_item_delete');
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
        dd('atom');
    });

    $controller = "AtomIndexController";


});

