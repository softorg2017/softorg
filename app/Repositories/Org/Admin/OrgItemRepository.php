<?php
namespace App\Repositories\Org\Admin;

use App\Models\Org\OrgOrganization;
use App\Models\Org\OrgItem;
use App\Models\Org\OrgMenu;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode;

class OrgItemRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new OrgItem;
    }

    // 返回【列表】数据（DataTable）
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("org_admin")->user()->org_id;
        $query = OrgItem::select("*")->where('org_id',$org_id)->with(['admin','menus']);
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
            foreach ($v->menus as $key => $val)
            {
                $val->encode_id = encode($val->id);
            }
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回【目录】【列表】数据
    public function get_menu_items_list_datatable($post_data)
    {
        $id = $post_data["id"];
        $decode_id = decode($id);

        $org_id = Auth::guard("org_admin")->user()->org_id;
//        $query = OrgItem::select("*")->with(['admin','menus'])->where('id',$decode_id);
        $query = OrgMenu::find($decode_id)->items()->with(['admin','menus']);
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

        $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
            foreach ($v->menus as $key => $val)
            {
                $val->encode_id = encode($val->id);
            }
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回【目录】【列表】视图
    public function view_menu_items()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        $menu = OrgMenu::find($decode_id);
        if($menu)
        {
            unset($menu->id);
            return view('org.admin.item.menu')->with(['encode_id'=>$id, 'data'=>$menu]);
        }
        else return response("该目录不存在！", 404);
    }

    // 返回【添加】视图
    public function view_create()
    {
        $admin = Auth::guard('org_admin')->user();
        $org_id = $admin->org_id;
        $org = OrgOrganization::with(['menus'=>function ($query1) {$query1->orderBy('order','asc');}])->find($org_id);
        return view('org.admin.item.edit')->with(['operate'=>'create', 'encode_id'=>encode(0), 'org'=>$org]);
    }

    // 返回【编辑】视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0)
        {
            $org = OrgOrganization::with(['menus'=>function ($query1) {$query1->orderBy('order','asc');}])->find($decode_id);
            return view('org.admin.item.edit')->with(['operate'=>'create', 'encode_id'=>$id, 'org'=>$org]);
        }
        else
        {
            $item = OrgItem::with([
                'menu',
                'org' => function ($query) { $query->with([
                    'menus'=>function ($query1) {$query1->orderBy('order','asc');}
                ]); },
            ])->find($decode_id);
            if($item)
            {
                unset($item->id);
                return view('org.admin.item.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$item]);
            }
            else return response("该产品不存在！", 404);
        }
    }

    // 【保存】数据
    public function save($post_data)
    {
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

        $admin = Auth::guard('org_admin')->user();

        $decode_id = decode($post_data["encode_id"]);
        if(intval($decode_id) !== 0 && !$decode_id) return response_error();


        // 判断操作类型
        $operate = $post_data["operate"];
        if($operate == 'create') // 添加 ( $id==0，添加一个新的产品 )
        {
            $item = new OrgItem;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else if($operate == 'edit') // 编辑
        {
            $item = OrgItem::find($decode_id);
            if(!$item) return response_error([],"该产品不存在，刷新页面重试");
            if($item->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }
        else return response_error([],"参数有误");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $bool = $item->fill($post_data)->save();
            if($bool)
            {
                if(!empty($post_data["menus"]))
                {
//                $item->menus()->attach($post_data["menus"]);
                    $item->menus()->syncWithoutDetaching($post_data["menus"]);
                }

                $encode_id = encode($item->id);

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'org-item' , 'cover_org_item_'.$encode_id);
                    if($result["status"])
                    {
                        $item->cover_pic = $result["data"];
                        $item->save();
                    }
                    else throw new Exception("upload-cover-fail");
                }


                // 保存二维码
                $url = 'http://www.softorg.cn/org/item/'.$encode_id;  // 目标URL
                // 保存位置
                $qrcode_path = 'resource/org/item';
                if(!file_exists(storage_path($qrcode_path)))
                    mkdir(storage_path($qrcode_path), 0777, true);
                // qrcode图片文件
                $qrcode = $qrcode_path.'/qrcode_org_item_'.$encode_id.'.png';
                QrCode::errorCorrection('H')->format('png')->size(480)->margin(0)->encoding('UTF-8')->generate($url,storage_path($qrcode));



//                $organization = OrgOrganization::find($admin->org_id);
//                $create = new CommonRepository();
//                $org_name = $organization->name;
//                $logo_path = '/resource/'.$organization->logo;
//                $title = $item->title;
//                $name = $qrcode_path.'/qrcode__item_'.$encode_id.'.png';
//                $create->create_qrcode_image($org_name, '内容', $title, $qrcode, $logo_path, $name);
            }
            else throw new Exception("insert--item--fail");

            DB::commit();
            return response_success(['id'=>$encode_id]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '操作失败，请重试！';
//            $msg = $e->getMessage();
//            exit($e->getMessage());
            return response_fail([],$msg);
        }
    }

    // 【删除】
    public function delete($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");
        $encode_id = encode($id);

        $item = OrgItem::find($id);
        if($item->admin_id != $admin->id) return response_error([],"你没有操作权限");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $cover_pic = $item->cover_pic;

            $bool = $item->delete();
            if(!$bool) throw new Exception("delete--item--fail");

            // 删除封面图片
            if(!empty($cover_pic) && file_exists(storage_path("resource/" . $cover_pic)))
            {
                unlink(storage_path("resource/" . $cover_pic));
            }

            // 删除二维码图片
            $qrcode = storage_path("resource/org/item/qrcode_org_item_" . $encode_id . ".png");
            if(file_exists($qrcode)) unlink($qrcode);

            DB::commit();
            return response_success([]);
        }
        catch (Exception $e)
        {
            DB::rollback();
            $msg = '删除失败，请重试';
            return response_fail([],$msg);
        }
    }

    // 【启用】
    public function enable($post_data)
    {
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $item = OrgItem::find($id);
        if($item->admin_id != $admin->id) return response_error([],"你没有操作权限");
        DB::beginTransaction();
        try
        {
            $update["active"] = 1;
            $bool = $item->fill($update)->save();
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
        $admin = Auth::guard('org_admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该内容不存在，刷新页面试试");

        $item = OrgItem::find($id);
        if($item->admin_id != $admin->id) return response_error([],"你没有操作权限");
        DB::beginTransaction();
        try
        {
            $update["active"] = 9;
            $bool = $item->fill($update)->save();
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
        $admin = Auth::guard('org_admin')->user();
        if(empty($post_data['keyword']))
        {
            $list =OrgMenu::select(['id','title as text'])->where(['org_id'=>$admin->id])->orderBy('id','desc')->get()->toArray();
        }
        else
        {
            $keyword = "%{$post_data['keyword']}%";
            $list =OrgMenu::select(['id','title as text'])->where(['org_id'=>$admin->id])->where('title','like',"%$keyword%")
                ->orderBy('id','desc')->get()->toArray();
        }
        return $list;
    }


}