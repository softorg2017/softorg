<?php
namespace App\Repositories\Root\Admin;

use App\Models\Root\RootModule;
use App\Models\Root\RootMenu;
use App\Models\Root\RootItem;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode;

class ItemRepository {

    private $model;
    private $repo;
    private $commonRepo;
    public function __construct()
    {
        $this->model = new RootItem;
        $this->commonRepo = new CommonRepository();
    }

    // 返回【列表】数据（DataTable）
    public function get_list_datatable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $query = RootItem::select("*")->with(['admin','menu','pivot_menus']);

        $category = $post_data['category'];
        if($category == "info") $query->where('category', 1);
        else if($category == "about") $query->where('category', 2);
        else if($category == "advantage") $query->where('category', 5);
        else if($category == "cooperation") $query->where('category', 9);
        else if($category == "service") $query->where('category', 11);
        else if($category == "product") $query->where('category', 12);
        else if($category == "case") $query->where('category', 21);
        else if($category == "faq") $query->where('category', 31);
        else if($category == "coverage") $query->where('category', 41);
        else if($category == "activity") $query->where('category', 48);
        else if($category == "client") $query->where('category', 51);

        $total = $query->count();

        $draw  = isset($post_data['draw'])  ? $post_data['draw']  : 1;
        $skip  = isset($post_data['start'])  ? $post_data['start']  : 0;
        $limit = isset($post_data['length']) ? $post_data['length'] : 20;

        if(isset($post_data['order']))
        {
            $columns = $post_data['columns'];
            $order = $post_data['order'][0];
            $order_column = $order['column'];
            $order_dir = $order['dir'];

            $field = $columns[$order_column]["data"];
            $query->orderBy($field, $order_dir);
        }
        else $query->orderBy("updated_at", "desc");

        if($limit == -1) $list = $query->get();
        else $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            foreach ($v->pivot_menus as $key => $val)
            {
                $val->encode_id = encode($val->id);
            }
        }
        return datatable_response($list, $draw, $total);
    }



    // 返回【添加】视图
    public function view_create()
    {
        $admin = Auth::guard('admin')->user();

        $category = request("category",'');

        $query = RootMenu::select("*");
        if($category == 'service') $query->where('category',11);
        elseif($category == 'product') $query->where('category',12);
        elseif($category == 'faq') $query->where('category',31);
        elseif($category == 'coverage') $query->where('category',41);
        $menus = $query->get();

        if($category == 'info') $view_blade = 'root.admin.item.edit-info';
        elseif($category == 'about') $view_blade = 'root.admin.item.edit-about';
        elseif($category == 'advantage') $view_blade = 'root.admin.item.edit-advantage';
        elseif($category == 'cooperation') $view_blade = 'root.admin.item.edit-cooperation';
        elseif($category == 'service') $view_blade = 'root.admin.item.edit-service';
        elseif($category == 'product') $view_blade = 'root.admin.item.edit-product';
        elseif($category == 'case') $view_blade = 'root.admin.item.edit-case';
        elseif($category == 'faq') $view_blade = 'root.admin.item.edit-faq';
        elseif($category == 'coverage') $view_blade = 'root.admin.item.edit-coverage';
        elseif($category == 'activity') $view_blade = 'root.admin.item.edit-activity';
        elseif($category == 'client') $view_blade = 'root.admin.item.edit-client';
        else $view_blade = 'root.admin.item.edit';

        return view($view_blade)->with(['operate'=>'create', 'encode_id'=>encode(0), 'menus'=>$menus, 'category'=>'']);
    }

    // 返回【编辑】视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0)
        {
            return view('admin.item.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        }
        else
        {
            $mine = RootItem::with([
                'menu',
            ])->find($decode_id);
            if($mine)
            {
                unset($mine->id);
                $mine->custom = json_decode($mine->custom);
                $mine->custom2 = json_decode($mine->custom2);
                $mine->custom3 = json_decode($mine->custom3);
                $category = $mine->category;

                $query = RootMenu::select("*");
                if($category == 11) $query->where('category',11);
                elseif($category == 12) $query->where('category',12);
                elseif($category == 31) $query->where('category',31);
                elseif($category == 41) $query->where('category',41);
                $menus = $query->get();

                if($category == '1') $view_blade = 'root.admin.item.edit-info';
                elseif($category == '2') $view_blade = 'root.admin.item.edit-about';
                elseif($category == '5') $view_blade = 'root.admin.item.edit-advantage';
                elseif($category == '9') $view_blade = 'root.admin.item.edit-cooperation';
                elseif($category == '11') $view_blade = 'root.admin.item.edit-service';
                elseif($category == '12') $view_blade = 'root.admin.item.edit-product';
                elseif($category == '21') $view_blade = 'root.admin.item.edit-case';
                elseif($category == '31') $view_blade = 'root.admin.item.edit-faq';
                elseif($category == '41') $view_blade = 'root.admin.item.edit-coverage';
                elseif($category == '48') $view_blade = 'root.admin.item.edit-activity';
                elseif($category == '51') $view_blade = 'root.admin.item.edit-client';
                else $view_blade = 'root.admin.item.edit';

                return view($view_blade)->with(['operate'=>'edit', 'encode_id'=>$id, 'menus'=>$menus, 'data'=>$mine, 'category'=>'']);
            }
            else return response("该产品不存在！", 404);
        }
    }

    // 【保存】数据
    public function save($post_data)
    {
//        dd($post_data);
        $messages = [
            'encode_id.required' => '参数有误',
            'title.required' => '请输入标题',
        ];
        $v = Validator::make($post_data, [
            'encode_id' => 'required',
            'title' => 'required'
        ], $messages);
        if ($v->fails())
        {
            $messages = $v->errors();
            return response_error([],$messages->first());
        }

        $admin = Auth::guard('admin')->user();

        $decode_id = decode($post_data["encode_id"]);
        if(intval($decode_id) !== 0 && !$decode_id) return response_error();


        // 判断操作类型
        $operate = $post_data["operate"];
        if($operate == 'create') // 添加 ( $id==0，添加一个新的产品 )
        {
            $category = $post_data["category"];
            $mine = new RootItem;
            $post_data["admin_id"] = $admin->id;
        }
        else if($operate == 'edit') // 编辑
        {
            $mine = RootItem::find($decode_id);
            if(!$mine) return response_error([],"该内容不存在，刷新页面重试");
            if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }
        else return response_error([],"参数有误");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            if(!empty($post_data['custom']))
            {
                $post_data['custom'] = json_encode($post_data['custom']);
            }

            $bool = $mine->fill($post_data)->save();
            if($bool)
            {
                if(!empty($post_data["menus"]))
                {
//                $mine->pivot_menus()->attach($post_data["menus"]);
                    $mine->pivot_menus()->syncWithoutDetaching($post_data["menus"]);
                }

                $encode_id = encode($mine->id);

                // 户型图片
                $multiple_images = [];
                if(!empty($post_data["multiple_images"][0]))
                {
                    // 删除原有图片
                    $custom2_decode = json_decode($mine->custom2,true);
                    if(count($custom2_decode) > 0)
                    {
                        foreach ($custom2_decode as $img)
                        {
                            if(!empty($img["img"]) && file_exists(storage_path("resource/" . $img["img"])))
                            {
                                unlink(storage_path("resource/" . $img["img"]));
                            }
                        }
                    }

                    // 添加图片
                    foreach ($post_data["multiple_images"] as $n => $f)
                    {
                        if(!empty($f))
                        {
                            $result = upload_storage($f);
                            if($result["result"]) $multiple_images[$n]["img"] = $result["local"];
                            else throw new Exception("upload-image-fail");
                        }
                    }

                    if(count($multiple_images) > 0)
                    {
                        $custom2_encode = json_encode($multiple_images);
                        $mine->custom2 = $custom2_encode;
                        $mine->save();
                    }
                }

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    // 删除原封面图片
                    $mine_cover_pic = $mine->cover_pic;
                    if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                    {
                        unlink(storage_path("resource/" . $mine_cover_pic));
                    }

                    $result = upload_storage($post_data["cover"]);
                    if($result["result"])
                    {
                        $mine->cover_pic = $result["local"];
                        $mine->save();
                    }
                    else throw new Exception("upload-cover-fail");

//                    $upload = new CommonRepository();
//                    $result = $upload->upload($post_data["cover"], 'outside-unique-items' , 'cover_item_'.$encode_id);
//                    if($result["status"])
//                    {
//                        $mine->cover_pic = $result["data"];
//                        $mine->save();
//                    }
//                    else throw new Exception("upload-cover-fail");
                }


//                $url = 'http://www.softorg.cn/outside/item/'.$encode_id;  // 目标URL
//                // 保存位置
//                $qrcode_path = 'resource/'.$admin->id.'/unique/items';
//                if(!file_exists(storage_path($qrcode_path)))
//                    mkdir(storage_path($qrcode_path), 0777, true);
//                // qrcode图片文件
//                $qrcode = $qrcode_path.'/qrcode_item_'.$encode_id.'.png';
//                QrCode::errorCorrection('H')->format('png')->size(160)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));


            }
            else throw new Exception("insert--item--fail");

            DB::commit();
            return response_success(['id'=>$encode_id]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }



    // 【删除】
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = RootItem::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $content = $mine->content;
            $cover_pic = $mine->cover_pic;

            $mine->pivot_menus()->detach();
            $bool = $mine->delete();
            if(!$bool) throw new Exception("delete--item--fail");

            DB::commit();

            // 删除UEditor图片
            $img_tags = get_html_img($content);
            foreach ($img_tags[2] as $img)
            {
                if (!empty($img) && file_exists(public_path($img)))
                {
                    unlink(public_path($img));
                }
            }

            // 删除封面图片
            if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
            {
                unlink(storage_path("resource/" . $cover_pic));
            }

            // 删除户型图片
            $custom2_decode = json_decode($mine->custom2,true);
            if(count($custom2_decode) > 0)
            {
                foreach ($custom2_decode as $img)
                {
                    if(!empty($img["img"]) && file_exists(storage_path("resource/" . $img["img"])))
                    {
                        unlink(storage_path("resource/" . $img["img"]));
                    }
                }
            }

            // 删除样板图片
            $custom3_decode = json_decode($mine->custom3,true);
            if(count($custom3_decode) > 0)
            {
                foreach ($custom3_decode as $img)
                {
                    if(!empty($img["img"]) && file_exists(storage_path("resource/" . $img["img"])))
                    {
                        unlink(storage_path("resource/" . $img["img"]));
                    }
                }
            }

            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '删除失败，请重试';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }

    // 【启用】
    public function enable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = RootItem::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        DB::beginTransaction();
        try
        {
            $update["active"] = 1;
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '启用失败，请重试';
            return response_fail([],$msg);
        }
    }

    // 【禁用】
    public function disable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $mine = RootItem::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        DB::beginTransaction();
        try
        {
            $update["active"] = 9;
            $bool = $mine->fill($update)->save();
            if(!$bool) throw new Exception("update--item--fail");

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '禁用失败，请重试';
            return response_fail([],$msg);
        }
    }



    // 【select2】
    public function select2_menus($post_data)
    {
        $admin = Auth::guard('admin')->user();
        if(empty($post_data['keyword']))
        {
            $list =RootMenu::select(['id','title as text'])->where(['org_id'=>$admin->id])->orderBy('id','desc')->get()->toArray();
        }
        else
        {
            $keyword = "%{$post_data['keyword']}%";
            $list =RootMenu::select(['id','title as text'])->where(['org_id'=>$admin->id])->where('title','like',"%$keyword%")
                ->orderBy('id','desc')->get()->toArray();
        }
        return $list;
    }


}