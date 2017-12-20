<?php
namespace App\Repositories\Admin;

use App\Models\Page;
use Response, Auth, Validator, DB, Exception;

class PageRepository {

    private $model;
    private $repo;
    public function __construct()
    {
    }

    // 返回编辑页面
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0) return view('admin.slide.page.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $page = Page::with(['slide'])->find($decode_id);
            if($page)
            {
                unset($page->id);
                return view('admin.slide.page.edit')->with(['operate'=>'edit', 'encode_id'=>$id,'data'=>$page]);
            }
            else return response("该页面不存在！", 404);
        }
    }

    // 添加or编辑幻灯页
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        $page = Page::find($id);
        if(!$page) return response_error();

        $post_data["admin_id"] = $admin->id;
//        $post_data["org_id"] = $admin->org_id;

        $bool = $page->fill($post_data)->save();
        if($bool) return response_success();
        else return response_fail();
    }

    // 幻灯片页面排序
    public function order($post_data)
    {
        $slide_id = decode($post_data["slide_id"]);
        if(!$slide_id) return response_error();

        $page = collect($post_data['page'])->values()->toArray();

        foreach($page as $k => $v)
        {
            $id = $v['id'];
            if(empty($id)) $page = new Page; // $id为空，创建一个新的幻灯页
            else // 修改幻灯页
            {
                $page = Page::find($id);
                if(!$page) return response_error();
            }
            $v['order'] = $k;
            $v['slide_id'] = $slide_id;
            $bool = $page->fill($v)->save();
        }
//        if($bool) return response_success();
//        else return response_fail();
        return response_success();
    }

}