<?php
namespace App\Repositories\Common;

use QrCode, Image;

/**
 * Description of UploadRepository
 */
class CommonRepository {
    
    public function create($file, $namespace, $size='', $allowed_extensions=["png", "jpg", "gif", "jpeg", "PNG", "JPG", "GIF", "JPEG"]) {
        if(empty($file)) return ["status" => false, "info" => "请上传图片!", "data" => ""];
        
        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return ["status" => false, "info" => $file->getClientOriginalExtension() . "上传图片格式不正确!", "data" => ""];
        }
        $namespace = str_replace("-", "/", $namespace);
        $destinationPath = $namespace . "/";
        $extension = $file->getClientOriginalExtension();
        $fileName = md5(date("ymdhis")) . $size . '.' . $extension;
        
        if (!is_dir(storage_path("resource/" . $destinationPath))) {
            mkdir(storage_path("resource/" . $destinationPath), 0744, true);
        }
        $file->move(storage_path("resource/" . $destinationPath), $fileName);
        
        return ["status" => true, "info" => "上传成功", "data" => $destinationPath . $fileName, "fileName"=>$fileName];
    }


    public function upload($file, $namespace, $filename, $size='', $allowed_extensions=["png", "jpg", "gif", "jpeg", "PNG", "JPG", "GIF", "JPEG"]) {
        if(empty($file)) return ["status" => false, "info" => "请上传图片!", "data" => ""];

        if ($file->getClientOriginalExtension() && !in_array($file->getClientOriginalExtension(), $allowed_extensions)) {
            return ["status" => false, "info" => $file->getClientOriginalExtension() . "上传图片格式不正确!", "data" => ""];
        }
        $namespace = str_replace("-", "/", $namespace);
        $destinationPath = $namespace . "/";
        $extension = $file->getClientOriginalExtension();
//        $fileName = md5(date("ymdhis")) . $size . '.' . $extension;
        $fileName = $filename . '.' . $extension;

        if (!is_dir(storage_path("resource/" . $destinationPath))) {
            mkdir(storage_path("resource/" . $destinationPath), 0744, true);
        }
        $file->move(storage_path("resource/" . $destinationPath), $fileName);

        return ["status" => true, "info" => "上传成功", "data" => $destinationPath . $fileName, "fileName"=>$fileName];
    }

    public function create_qrcode_image($org_name, $type_string, $title, $qrcode_path, $logo_path, $name)
    {

        $font_file = public_path().'/fonts/huawenkaiti.ttf';
        $font_2 = public_path().'/fonts/huawenkaiti.ttf';

        $img = Image::canvas(400, 400, '#fafafa');

//        $type_string = '活动';
        $img->text($type_string, 200, 50, function($font) use ($font_file) {
            $font->file($font_file);
            $font->size(16);
            $font->color('#000');
            $font->align('center');
            $font->valign('bottom');
        });

        $points1 = array(
            30,  60,  // Point 1 (x, y)
            370,  60, // Point 2 (x, y)
            30,  60,  // Point 3 (x, y)
        );
        $img->polygon($points1, function ($draw) {
//            $draw->background('#0000ff');
            $draw->border(1, '#000');
        });

//        $title = "2017天津How I Treat和淋巴瘤转化医学国际研讨会";
        $title = $this->autowrap(16, 0, $font_file, $title, 280); // 自动换行处理
        $img->text($title, 200, 90, function($font) use ($font_file) {
            $font->file($font_file);
            $font->size(24);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });

        $qrcode = Image::make(storage_path($qrcode_path));
        $img->insert($qrcode, 'bottom-right',120, 60);

        $logo = Image::make(storage_path($logo_path));
        $logo->resize(40, 40);

        // define polygon points
        $points = array(
            1,  1,  // Point 1 (x, y)
            39,  1, // Point 2 (x, y)
            39,  39,  // Point 3 (x, y)
            1, 39,  // Point 4 (x, y)
        );
        $logo->polygon($points, function ($draw) {
//            $draw->background('#0000ff');
            $draw->border(1, '#ffffff');
        });

        $img->insert($logo, 'bottom-right',180, 120);

//        $org_name = "上海如哉网络科技有限公司";
        $img->text($org_name, 200, 360, function($font) use ($font_file) {
            $font->file($font_file);
            $font->size(16);
            $font->color('#000');
            $font->align('center');
            $font->valign('top');
        });

        return $img->save(storage_path($name));
    }

    public function autowrap($font_size, $angle, $font_face, $string, $width)
    {
        // 这几个变量分别是 字体大小, 角度, 字体名称, 字符串, 预设宽度
        $content = "";

        // 将字符串拆分成一个个单字 保存到数组 letter 中
        for ($i=0;$i<mb_strlen($string);$i++)
        {
            $letter[] = mb_substr($string, $i, 1);
        }

        foreach ($letter as $l)
        {
            $test_str = $content." ".$l;
            $test_box = imagettfbbox($font_size, $angle, $font_face, $test_str);

            // 判断拼接后的字符串是否超过预设的宽度
            if (($test_box[2] > $width) && ($content !== ""))
            {
                $content .= "\n";
            }
            $content .= $l;
        }
        return $content;
    }


}
