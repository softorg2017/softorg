<?php


$controller = "IndexController";

Route::get('/', $controller."@index");

//    Route::get('index', "{$controller}@index");
//    Route::get('index1', "{$controller}@index1");

Route::get('index', function () {
    return view('developing.index');
});

Route::get('index0', function () {
    return view('developing.index0')->with(['org'=>[]]);
});

Route::get('index1', function () {
    return view('developing.index1');
});



