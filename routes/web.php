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

Route::get('/', function () {
//    return view('welcome');
//    return redirect(config('common.website.front.prefix').'/softorg');
});
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



/*超级后台*/
Route::group(['prefix' => 'super', 'namespace' => 'Super', 'middleware' => 'super'], function () {

    $controller = "SuperController";

    Route::get('/', $controller.'@index');
    Route::match(['get','post'], 'list/softorg', $controller.'@view_softorg_list');
    Route::match(['get','post'], 'list/product', $controller.'@view_product_list');
    Route::match(['get','post'], 'list/article', $controller.'@view_article_list');
    Route::match(['get','post'], 'list/activity', $controller.'@view_activity_list');
    Route::match(['get','post'], 'list/survey', $controller.'@view_survey_list');
});



/*
 * TEST 测试
 */
Route::group(['prefix' => 'test'], function () {
    require(__DIR__ . '/Test/route.php');
});


/*
 * 开发中
 */
Route::group(['prefix' => 'developing', 'namespace' => 'Developing'], function () {
    require(__DIR__ . '/Developing/route.php');
});


/*
 * 企业站
 */
Route::group(['namespace' => 'Org'], function () {
    require(__DIR__ . '/Org/route.php');
});


