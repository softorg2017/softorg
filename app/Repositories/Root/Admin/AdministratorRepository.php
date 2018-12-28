<?php
namespace App\Repositories\Root\Admin;

use App\Administrator;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class AdministratorRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Administrator;
    }

    // 返回（后台）主页视图
    public function view_index()
    {
        $admin = Auth::guard('admin')->user();
        $me = $admin;

        return view('admin.administrator.index')->with(['me'=>$me]);
    }

    // 返回（后台）企业信息编辑视图
    public function view_edit()
    {
        $me = Auth::guard('admin')->user();
        return view('admin.administrator.edit')->with(['me'=>$me]);
    }
    // 保存企业信息
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        if(!empty($post_data["portrait_img"]))
        {
            // 删除原封面图片
            $mine_cover_pic = $admin->portrait_img;
            if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
            {
                unlink(storage_path("resource/" . $mine_cover_pic));
            }

            $upload = new CommonRepository();
            $result = $upload->create($post_data["portrait_img"], 'root-unique-portrait-admin_'. $admin->id);
            if($result["status"]) $post_data["portrait_img"] = $result["data"];
            else return response_fail();
        }
        else unset($post_data["portrait_img"]);

        $bool = $admin->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }






}