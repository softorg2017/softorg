<?php

/*
 * 原子系统
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {


    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');


    /*
     * 后台管理，需要登录
     */
    Route::group(['middleware' => ['atom','atom.admin']], function () {

        $controller = "AtomAdminController";

        Route::get('/', $controller.'@view_admin_index');


        // item
        Route::match(['get','post'], '/item/select2_people', $controller.'@operate_item_select2_people');

        Route::match(['get','post'], '/item/item-list', $controller.'@view_item_list');
        Route::match(['get','post'], '/item/item-list-for-all', $controller.'@view_item_list_for_all');
        Route::match(['get','post'], '/item/item-list-for-people', $controller.'@view_item_list_for_people');
        Route::match(['get','post'], '/item/item-list-for-object', $controller.'@view_item_list_for_object');
        Route::match(['get','post'], '/item/item-list-for-product', $controller.'@view_item_list_for_product');
        Route::match(['get','post'], '/item/item-list-for-event', $controller.'@view_item_list_for_event');
        Route::match(['get','post'], '/item/item-list-for-conception', $controller.'@view_item_list_for_conception');


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
        dd('atom.frontend');
    });

    $controller = "AtomIndexController";


});

