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






/*
 * LOOKWIT 如未科技
 */
// 跳转根域名跳转至www
Route::group(['domain' => env('LW_DOMAIN_ROOT')], function(){
    Route::get('{all}', function(){
        return Redirect::away(env('LW_DOMAIN_WWW').ltrim(Request::path(),'/'), 301);
    })->where('all','.*');
});
// WWW
Route::group(['domain' => env('LW_DOMAIN_WWW'), 'namespace' => 'LW\WWW'], function () {
    require(__DIR__ . '/LW/WWW/route.php');
});
// GPS 导航
Route::group(['domain' => env('LW_DOMAIN_GPS'), 'namespace' => 'LW\GPS'], function () {
    require(__DIR__ . '/LW/GPS/route.php');
});
// 超级管理员
Route::group(['domain' => env('LW_DOMAIN_SUPER'), 'namespace' => 'LW\Super'], function () {
    require(__DIR__ . '/LW/Super/route.php');
});
// 原子
Route::group(['domain' => env('LW_DOMAIN_ATOM'), 'namespace' => 'LW\Atom'], function () {
    require(__DIR__ . '/LW/Atom/route.php');
});
// 轻博
Route::group(['domain' => env('LW_DOMAIN_DOC'), 'namespace' => 'LW\Doc'], function () {
    require(__DIR__ . '/LW/Doc/route.php');
});
// 组织机构
Route::group(['domain' => env('LW_DOMAIN_ORG'), 'namespace' => 'LW\Org'], function () {
    require(__DIR__ . '/LW/Org/route.php');
});





/*
 * TEST 测试
 */
Route::group(['domain' => 'testing', 'namespace' => 'Test'], function () {
    require(__DIR__ . '/Test/route.php');
});


/*
 * 开发中
 */
Route::group(['domain' => 'developing', 'namespace' => 'Developing'], function () {
    require(__DIR__ . '/Developing/route.php');
});


