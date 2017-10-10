<?php

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
    return view('welcome');
});

//Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
    return view('test');
});

Route::get('/home', function () {
    return view('front.'.config('common.view.front.template').'.index');
});



/*后台*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {

    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');

    // 注册登录
    Route::group(['namespace' => 'Auth'], function () {
        Route::match(['get','post'], 'register','AuthController@register');
        Route::match(['get','post'], 'login','AuthController@login');
        Route::match(['get','post'], 'logout','AuthController@logout');
    });

    Route::group(['middleware' => 'admin'], function () {

        Route::get('/', function () {
            return view('admin.index');
        });

        // 企业模块
        Route::group(['prefix' => 'company', 'namespace' => 'Company'], function () {
            Route::get('/','CompanyController@index');
            Route::get('index','CompanyController@index');
            Route::get('create','CompanyController@createAction');
            Route::match(['get','post'], 'edit','CompanyController@editAction');

            // 产品模块
            Route::group(['prefix' => 'website'], function () {
                Route::get('/','WebsiteController@index');
                Route::get('index','WebsiteController@index');
                Route::match(['get','post'], 'list','WebsiteController@viewList');
                Route::get('create','WebsiteController@createAction');
                Route::match(['get','post'], 'edit','WebsiteController@editAction');
                Route::get('delete','WebsiteController@deleteAction');
            });

            // 产品模块
            Route::group(['prefix' => 'product'], function () {
                Route::get('/','ProductController@index');
                Route::get('index','ProductController@index');
                Route::match(['get','post'], 'list','ProductController@viewList');
                Route::get('create','ProductController@createAction');
                Route::match(['get','post'], 'edit','ProductController@editAction');
                Route::get('delete','ProductController@deleteAction');
            });

            // 目录模块
            Route::group(['prefix' => 'menu'], function () {
                Route::get('/','MenuController@index');
                Route::get('index','MenuController@index');
                Route::match(['get','post'], 'list','MenuController@viewList');
                Route::get('create','MenuController@createAction');
                Route::match(['get','post'], 'edit','MenuController@editAction');
                Route::get('delete','MenuController@deleteAction');
            });
        });

        // 活动模块
        Route::group(['prefix' => 'article', 'namespace' => 'Article'], function () {
            Route::get('/','ArticleController@indexAction');
            Route::get('index','ArticleController@index');
            Route::match(['get','post'], 'list','ArticleController@viewList');
            Route::get('create','ArticleController@createAction');
            Route::match(['get','post'], 'edit','ArticleController@editAction');
            Route::get('delete','ArticleController@deleteAction');
        });

        // 活动模块
        Route::group(['prefix' => 'activity', 'namespace' => 'Activity'], function () {
            Route::get('/','ActivityController@indexAction');
            Route::get('index','ActivityController@index');
            Route::match(['get','post'], 'list','ActivityController@viewList');
            Route::get('create','ActivityController@createAction');
            Route::match(['get','post'], 'edit','ActivityController@editAction');
            Route::get('delete','ActivityController@deleteAction');
        });

        // 幻灯片模块
        Route::group(['prefix' => 'slide', 'namespace' => 'Slide'], function () {
            Route::get('/','SlideController@index');
            Route::get('index','SlideController@index');
            Route::match(['get','post'], 'list','SlideController@viewList');
            Route::get('create','SlideController@createAction');
            Route::match(['get','post'], 'edit/{id?}','SlideController@editAction');
            Route::get('delete','SlideController@deleteAction');

            // 幻灯页模块
            Route::group(['prefix' => 'page'], function () {
                Route::get('/','PageController@index');
                Route::get('index','PageController@index');
                Route::match(['get','post'], 'list','PageController@viewList');
                Route::get('create','PageController@createAction');
                Route::match(['get','post'], 'edit/{id?}','PageController@editAction');
                Route::post('order','PageController@orderAction');
                Route::get('delete','PageController@deleteAction');
            });
        });

        // 调研
        Route::group(['prefix' => 'survey', 'namespace' => 'Survey'], function () {
            Route::get('/','SurveyController@index');
            Route::get('index','SurveyController@index');
            Route::match(['get','post'], 'list','SurveyController@viewList');
            Route::get('create','SurveyController@createAction');
            Route::match(['get','post'], 'edit','SurveyController@editAction');
            Route::get('delete','SurveyController@deleteAction');
        });

        Route::group(['middleware' => 'page-mine'], function () {
            Route::get('delete','DisplayController@item_delete');
            Route::get('share','DisplayController@item_share');
        });

    });

});


/*前台*/
Route::group(['namespace' => 'Front\Company'], function () {

    Route::get('/product','CompanyController@view_product_detail');
    Route::get('/activity','CompanyController@view_activity_detail');
    Route::get('/survey','CompanyController@view_survey_detail');
    Route::get('/slide','CompanyController@view_slide_detail');
    Route::get('/article','CompanyController@view_article_detail');

});

/*前台*/
Route::group(['prefix' => config('common.website.front.prefix').'/{company_name}', 'namespace' => 'Front'], function () {

    Route::group(['namespace' => 'Company'], function () {
        Route::get('/','CompanyController@index');
        Route::get('/index','CompanyController@index');

        Route::get('/product','CompanyController@product');
        Route::get('/product/detail','CompanyController@product_detail');

        Route::get('/activity','CompanyController@activity');
        Route::get('/activity/detail','CompanyController@activity_detail');

        Route::get('/slide','CompanyController@slide');
        Route::get('/slide/detail','CompanyController@slide_detail');

        Route::get('/survey','CompanyController@survey');
        Route::get('/survey/detail','CompanyController@survey_detail');

        Route::get('/article','CompanyController@article');
        Route::get('/article/detail','CompanyController@article_detail');
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

