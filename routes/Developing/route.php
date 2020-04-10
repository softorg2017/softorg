<?php


$controller = "IndexController";

Route::get('/', $controller."@index");


Route::get('/metinfo', function () {
    return view('root.case.metinfo');
});

/*
 * 样式开发
 */
Route::group(['prefix' => 'style'], function () {

    $controller = "StyleController";


    Route::get('enterprise/index/{num?}', $controller."@view_enterprise_index");
    Route::get('enterprise/list/{num?}', $controller."@view_enterprise_list");





});






