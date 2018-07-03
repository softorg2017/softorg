<?php


$controller = "IndexController";

Route::get('/', $controller."@index");

Route::get('/website/templates', $controller."@view_website_templates");
Route::get('/website/template/{id?}', $controller."@view_website_template");



/*
 * 样式开发
 */
Route::group(['prefix' => 'case'], function () {

    $controller = "CaseController";

    Route::get('test', $controller."@view_test");

    Route::get('metinfo', $controller."@view_metinfo");

});




/*
 * weixin
 */
Route::group(['prefix' => 'weixin'], function () {

    $controller = "WeixinController";

    Route::match(['get', 'post'],'gongzhonghao', $controller."@gongzhonghao");
    Route::match(['get', 'post'],'root', $controller."@root");
    Route::match(['get', 'post'],'test', $controller."@test");

});


