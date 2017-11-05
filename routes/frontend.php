<?php

Route::group(['prefix' => 'frontend'], function () {
    //首页
    Route::get('/index', function () {
        return view('frontend.home.index');
    });
    //列表页
    Route::get('/list',function(){
        return view('frontend.home.list');
    });
    //详情页
    Route::get('/detail',function(){
       return view('frontend.home.detail');
    })->name('frontend.detail');

    Route::get('/index-new',function(){
        return view('frontend.theme.home.index')
    })
});