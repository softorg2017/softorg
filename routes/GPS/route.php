<?php

/*
 * 后台管理
 */
Route::group(['prefix' => 'admin' , 'namespace' => 'Admin'], function () {


    App::setLocale("zh");
    Route::get('/i18n','IndexController@dataTableI18n');


    /*
     * 注册登录
     */
    Route::group([], function () {

        $controller = "GPSAuthController";

        Route::match(['get','post'], 'register', $controller.'@register');
        Route::match(['get','post'], 'login', $controller.'@login');
        Route::match(['get','post'], 'logout', $controller.'@logout');
        Route::match(['get','post'], 'activation', $controller.'@activation');

    });


    /*
     * 后台管理，需要登录
     */
    Route::group(['middleware' => 'gps'], function () {

        $controller = "GPSAdminController";

        Route::get('/', function () {
            return view('gps.admin.index');
        });

        //
        Route::match(['get','post'], '/navigation',$controller.'@navigation');
        Route::match(['get','post'], '/test-list',$controller.'@test_list');
        Route::match(['get','post'], '/tool-list',$controller.'@tool_list');
        Route::match(['get','post'], '/template-list',$controller.'@template_list');

        Route::match(['get','post'], '/tool',$controller.'@tool');




        Route::match(['get','post'], '/item/item-get', $controller.'@operate_item_item_get');
        Route::match(['get','post'], '/item/item-delete', $controller.'@operate_item_item_delete');
        Route::match(['get','post'], '/item/item-restore', $controller.'@operate_item_item_restore');
        Route::match(['get','post'], '/item/item-delete-permanently', $controller.'@operate_item_item_delete_permanently');
        Route::match(['get','post'], '/item/item-publish', $controller.'@operate_item_item_publish');

        Route::match(['get','post'], '/item/item-admin-disable', $controller.'@operate_item_admin_disable');
        Route::match(['get','post'], '/item/item-admin-enable', $controller.'@operate_item_admin_enable');


    });


});


/*
 * 后台管理
 */
Route::group(['prefix' => 'testing' , 'namespace' => 'Admin'], function () {

    /*
     * 后台管理，需要登录
     */
    Route::group(['middleware' => 'gps'], function () {

        $controller = "GPSTestController";

        Route::get('/', function () {
            return view('gps.admin.index');
        });

        //
        Route::get('/++', "{$controller}@plus_plus");

        Route::get('/url', "{$controller}@url");

        Route::get('/headers', "{$controller}@headers");

        Route::get('/json', "{$controller}@json");



        Route::match(['get','post'], '/preg_match_all', function () {


            $post_data = request()->all();
            $content = $post_data["content"];

            $strPreg = '/(\s+src\s?\=)\s?[\'|"]([^\'|"]*)/is';
//    $strPreg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
            preg_match_all($strPreg, $content, $matches);

            $base_image_list = $matches[2];

            foreach ($base_image_list as $v)
            {

                $image_all_arr = explode(';', $v);
//        dd($type);
                $img_type_all = explode('/', $image_all_arr[0]);
//        dd($img_type_all);
                $postfix = $img_type_all[1];
//        dd($postfix);

                $img_content = explode(',',$image_all_arr[1]);
//        dd($img_content);

                //生成唯一图片名
                $image_name = time() . '_' . uniqid() . '.' . $postfix;
//        dd($image_name);

                //解码base64
//        dd($img_content[1]);
                $encodedData = $img_content[1];

                $encodedData = str_replace(' ','+', $encodedData);
                $decode_image = base64_decode($encodedData);


                // 如果字符串过长，还需要先替换再分段解码：
                $decode_image_1 = "";
                for ($i=0; $i < ceil(strlen($encodedData)/256); $i++)
                {
                    $decode_image_1 = $decode_image_1 . base64_decode(substr($encodedData,$i*256,256));
                }



                $path = "./".date("Ymd",time());

                if (!is_dir($path)){ //判断目录是否存在 不存在就创建
                    mkdir($path,0777,true);
                }

                $imageSrc= $path."/". $image_name; //图片名字

                $r = file_put_contents($imageSrc, $decode_image);//返回的是字节数
                if (!$r) {
                    $tmparr1=array('data'=>null,"code"=>1,"msg"=>"{$imageSrc}图片生成失败");
                    echo json_encode($tmparr1);
                    echo "<br>";
                }else{
                    $tmparr2=array('data'=>1,"code"=>0,"msg"=>"{$imageSrc}图片生成成功");
                    echo json_encode($tmparr2);
                    echo "<br>";
                }

                $r_1 = file_put_contents($imageSrc, $decode_image_1);//返回的是字节数
                if (!$r_1) {
                    $tmparr1=array('data'=>null,"code"=>1,"msg"=>"{$imageSrc}图片生成失败");
                    echo json_encode($tmparr1);
                    echo "<br>";
                }else{
                    $tmparr2=array('data'=>1,"code"=>0,"msg"=>"{$imageSrc}图片生成成功");
                    echo json_encode($tmparr2);
                    echo "<br>";
                }
            }

        });


        Route::match(['get','post'], '/preg_replace_large', function () {

            // 获取所有帖子内容中的图片
            preg_match_all('/(\s+src\s?\=)\s?[\'|"]([^\'|"]*)/is', $content, $topic_imgs);

            $base_image_list = $topic_imgs[2];
            foreach ($base_image_list as $k => $v){
                if(!strstr($v,'large')){
                    $imgs = explode('.',$v);
                    $base_image_list[$k] = str_replace($imgs[count($imgs)-2],$imgs[count($imgs)-2].'_large',$v);
                }
            }
            return $content;


        });


        Route::match(['get','post'], '/preg_replace_blank', function () {

            $text = '<div class="textContent"><p>测试空格   我前面有三个空格，我后面有也有3个空格，   后面是一张图片，</p><p></p><div class="media-wrap image-wrap"><img id="**" title="**" alt="**" loop="" controls="" src="https://pet.sonystyle.com.cn/content_pipeline/image/display/84855CBBB7C54BFAA074C1459DD6096B_large.jpg?t=1565074806"></div><p></p></div>';

//    $patterns = array();
////    $patterns[0] = "/\\n/";
//    $patterns[1] = "/ /";
//    $replacements = array();
////    $replacements[0] = "<br>";
//    $replacements[1] = "&nbsp";
//    $content = preg_replace($patterns, $replacements, $text);

            /*    $pattern = '<p[^>]*?>[\w\W]*?<\/p>';*/


            $pattern = array (
                "/> *([^ ]*) *</", //去掉注释标记
            );
            $replace = array (
                ">\\1<",
            );

            $text = preg_replace($pattern, $replace, $text);

            return $text;

        });









        Route::get('/send/email', $controller.'@send_email');

        Route::get('/send_sms', "{$controller}@send_sms");

        Route::get('/image', "{$controller}@image");



    });


});


/*
 * 前台
 */
Route::group(['namespace' => 'Front', 'middleware' => 'wechat.share'], function () {

    Route::get('/', function () {
        dd('gps');
    });

    $controller = "GPSIndexController";

    Route::get('/developing', $controller."@view_developing");

    Route::get('/template/test', $controller."@view_template_test");
    Route::get('/template/metinfo', $controller."@view_template_metinfo");


});

