<?php

require __DIR__.'/frontend.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::group(['domain' => env('DOMAIN_ROOT')], function(){
    Route::get('{all}', function(){
        return Redirect::away(env('DOMAIN_WWW').ltrim(Request::path(),'/'),301);
    })->where('all','.*');
});




//Route::get('/', function () {
//    return view('welcome');
//    return redirect(config('common.website.front.prefix').'/softorg');
//});




Route::get('org', function () {
//    return view('welcome');
//    return redirect('org/softorg');
});




//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');




Route::get('/home-', function () {
    return view('front.online.index');
});




/*
 * Common 通用
 */
Route::group(['prefix' => 'common'], function () {

    $controller = "CommonController";

    //
    Route::match(['get','post'], '/haha', $controller.'@index');

    // 验证码
    Route::match(['get','post'], 'change_captcha', $controller.'@change_captcha');

    //
    Route::get('dataTableI18n', function () {
        return trans('pagination.i18n');
    });
});




/*前台注册与登录*/
Route::group(['prefix' => 'user', 'namespace' => 'Front'], function () {
    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {
        Route::match(['get','post'], 'register','AuthController@register');
        Route::match(['get','post'], 'login','AuthController@login');
        Route::match(['get','post'], 'logout','AuthController@logout');
    });
});




/*
 * GPS 导航
 */
Route::group(['domain' => 'gps.'.env('DOMAIN_ROOT'), 'namespace' => 'GPS'], function () {
    require(__DIR__ . '/GPS/route.php');
});





/*
 * TEST 测试
 */
Route::group(['prefix' => 'testing', 'namespace' => 'Test'], function () {
    require(__DIR__ . '/Test/route.php');
});


/*
 * 开发中
 */
Route::group(['prefix' => 'developing', 'namespace' => 'Developing'], function () {
    require(__DIR__ . '/Developing/route.php');
});


/*
 * 超级管理员
 */
Route::group(['domain' => 'super.'.env('DOMAIN_ROOT'), 'namespace' => 'Super'], function () {
    require(__DIR__ . '/Super/route.php');
});
Route::group(['domain' => 'test.super.'.env('DOMAIN_ROOT'), 'namespace' => 'Super'], function () {
    require(__DIR__ . '/Super/route.php');
});


/*
 * ORG
 */
Route::group(['domain' => 'org.'.env('DOMAIN_ROOT'), 'namespace' => 'Org'], function () {
    require(__DIR__ . '/Org/route.php');
});
Route::group(['domain' => 'test.org.'.env('DOMAIN_ROOT'), 'namespace' => 'Org'], function () {
    require(__DIR__ . '/Org/route.php');
});


/*
 * DOC
 */
Route::group(['domain' => 'doc.'.env('DOMAIN_ROOT'), 'namespace' => 'Doc'], function () {
    require(__DIR__ . '/Doc/route.php');
});
Route::group(['domain' => 'test.doc.'.env('DOMAIN_ROOT'), 'namespace' => 'Doc'], function () {
    require(__DIR__ . '/Doc/route.php');
});


/*
 * ATOM
 */
Route::group(['domain' => 'atom.'.env('DOMAIN_ROOT'), 'namespace' => 'Atom'], function () {
    require(__DIR__ . '/Atom/route.php');
});
Route::group(['domain' => 'test.atom.'.env('DOMAIN_ROOT'), 'namespace' => 'Atom'], function () {
    require(__DIR__ . '/Atom/route.php');
});


/*
 * 企业对内管理员
 */
Route::group(['domain' => 'inside.'.env('DOMAIN_ROOT'), 'namespace' => 'Inside'], function () {
//    require(__DIR__ . '/Inside/route.php');
});


/*
 * 企业对外管理员
 */
Route::group(['domain' => 'outside.'.env('DOMAIN_ROOT'), 'namespace' => 'Outside'], function () {
//    require(__DIR__ . '/Outside/route.php');
});


/*
 * 根
 */
Route::group(['domain' => 'www.'.env('DOMAIN_ROOT'), 'namespace' => 'Root'], function () {
    require(__DIR__ . '/Root/route.php');
});
Route::group(['domain' => 'test.www.'.env('DOMAIN_ROOT'), 'namespace' => 'Root'], function () {
    require(__DIR__ . '/Root/route.php');
});


