<?php


$controller = "IndexController";

Route::get('/', $controller."@index");


/*
 * 样式开发
 */
Route::group(['prefix' => 'style'], function () {

    $controller = "StyleController";


    Route::get('/gps', $controller."@view_gps");

    Route::get('enterprise/index/{num?}', $controller."@view_enterprise_index");
    Route::get('enterprise/list/{num?}', $controller."@view_enterprise_list");


    //
    Route::get('industrious', $controller."@view_industrious");


    //
    Route::get('wicked', $controller."@view_wicked");
    Route::get('swimming-line', $controller."@view_swimming_line");
    Route::get('swimming-tadpole', $controller."@view_swimming_tadpole");
    Route::get('hover', $controller."@view_animate_hover");
    Route::get('hover2', $controller."@view_animate_hover2");
    Route::get('3d-rotate', $controller."@view_animate_3d_rotate");
    Route::get('floating-button', $controller."@view_animate_floating_button");
    Route::get('on-context-menu', $controller."@view_on_context_menu");
    Route::get('hover-screen-1', $controller."@view_animate_hover_screen_1");
    Route::get('hover-screen-2', $controller."@view_animate_hover_screen_2");
    Route::get('hover-screen-3', $controller."@view_animate_hover_screen_3");
    Route::get('hover-screen-4', $controller."@view_animate_hover_screen_4");
    Route::get('match-height', $controller."@view_match_height");

});






