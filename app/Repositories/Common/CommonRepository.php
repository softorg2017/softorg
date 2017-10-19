<?php
namespace App\Repositories\Common;

use QrCode;

/**
 * Description of UploadRepository
 */
class UploadRepository {
    
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
            mkdir(storage_path("resource/" . $destinationPath), 755, true);
        }
        $file->move(storage_path("resource/" . $destinationPath), $fileName);
        
        return ["status" => true, "info" => "上传成功", "data" => $destinationPath . $fileName, "fileName"=>$fileName];
    }

}
