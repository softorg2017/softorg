<?php


$controller = "IndexController";

Route::get('/', $controller."@index");


/*
 * 样式开发
 */
Route::group(['prefix' => 'case'], function () {

    $controller = "CaseController";

    Route::get('metinfo', $controller."@view_metinfo");

});






