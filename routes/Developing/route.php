<?php


$controller = "IndexController";

Route::get('/', $controller."@index");



/*
 * 样式开发
 */
Route::group(['prefix' => 'style'], function () {

    $controller = "StyleController";


    Route::get('enterprise/index/{num?}', $controller."@view_enterprise_index");
    Route::get('enterprise/list/{num?}', $controller."@view_enterprise_list");





});






