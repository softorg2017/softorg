<?php


    $controller = "TestController";


    Route::get('/', function () {
        dd('test');
    });




    Route::get('/index', function () {
        return view('frontend.home.index');
    });
    Route::get('/detail', function () {
        return view('frontend.home.detail');
    });
    Route::get('/list', function () {
        return view('frontend.home.list');
    });
    // Route::get('/send/email', $controller.'@send_email');

     Route::get('/send_sms', "{$controller}@send_sms");

     Route::get('/image', "{$controller}@image");

    Route::get('/eloquent', "{$controller}@eloquent");




