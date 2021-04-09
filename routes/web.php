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




Route::group(['domain'=>env('DOMAIN_ROOT')], function(){
    Route::get('{all}', function(){
        return Redirect::away(env('DOMAIN_WWW').ltrim(Request::path(),'/'),301);
    })->where('all','.*');
});




//Route::get('/', function () {
//    return view('welcome');
//    return redirect(config('common.website.front.prefix').'/softorg');
//});




Route::get(config('common.website.front.prefix').'/', function () {
//    return view('welcome');
    return redirect(config('common.website.front.prefix').'/softorg');
});




//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');




Route::get('/home', function () {
    return view('front.'.config('common.view.front.template').'.index');
});




/*
 * Common 通用
 */
Route::group(['prefix' => 'common'], function () {

    $controller = "CommonController";

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
 * TEST 测试
 */
Route::group(['prefix' => 'test', 'namespace' => 'Test'], function () {
    require(__DIR__ . '/Test/route.php');
});


/*
 * 开发中
 */
Route::group(['prefix' => 'developing', 'namespace' => 'Developing'], function () {
    require(__DIR__ . '/Developing/route.php');
});


/*
 * 根
 */
Route::group(['namespace' => 'Root'], function () {
    require(__DIR__ . '/Root/route.php');
});


/*
 * 超级管理员
 */
Route::group(['namespace' => 'Super'], function () {
    require(__DIR__ . '/Super/route.php');
});


/*
 * 企业对内管理员
 */
Route::group(['namespace' => 'Inside'], function () {
    require(__DIR__ . '/Inside/route.php');
});


/*
 * 企业对外管理员
 */
Route::group(['namespace' => 'Outside'], function () {
    require(__DIR__ . '/Outside/route.php');
});


/*
 * 企业站
 */
Route::group(['namespace' => 'Org'], function () {
    require(__DIR__ . '/Org/route.php');
});


