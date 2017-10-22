<?php
namespace App\Repositories\Admin;

use App\Models\Softorg;
use App\Models\Product;
use Response, Auth, Validator, DB, Excepiton;
use QrCode;

class ProductRepository {

    private $model;
    private $repo;
    public function __construct()
    {
        $this->model = new Product;
    }

    // 返回列表数据（DataTable）
    public function get_list_datatable($post_data)
    {
        $org_id = Auth::guard("admin")->user()->org_id;
        $query = Product::select("*")->where('org_id',$org_id)->with(['admin','menu']);
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
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回添加产品视图
    public function view_create()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;
        $org = Softorg::with(['menus'])->find($org_id);
        return view('admin.product.edit')->with(['org'=>$org]);
    }
    // 返回编辑产品视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0) return view('admin.product.edit')->with(['operate'=>'create', 'encode_id'=>$id]);
        else
        {
            $product = Product::with([
                    'menu',
                    'org' => function ($query) { $query->with(['menus'])->orderBy('id','desc'); }
                ])->find($decode_id);
            if($product)
            {
                unset($product->id);
                return view('admin.product.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$product]);
            }
            else return response("该产品不存在！", 404);
        }
    }

    // 添加or编辑
    public function save($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $id = decode($post_data["id"]);
        $operate = decode($post_data["operate"]);
        if(intval($id) !== 0 && !$id) return response_error();

        if($id == 0) // $id==0，添加一个新的产品
        {
            $product = new Product;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else // 编辑产品
        {
            $product = Product::find($id);
            if(!$product) return response_error([],"该产品不存在，刷新页面试试");
            if($product->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }

        $bool = $product->fill($post_data)->save();
        if($bool)
        {
            $encode_id = encode($product->id);
            // 目标URL
            $url = 'http://www.softorg.cn:8088/product?id='.$encode_id;
            // 保存位置
            $qrcodes_path = 'resource/org/'.$admin->id.'/qrcodes/products';
            if(!file_exists(storage_path($qrcodes_path)))
                mkdir(storage_path($qrcodes_path), 777, true);
            // qrcode图片文件
            $qrcode = $qrcodes_path.'/'.$encode_id.'.png';
            QrCode::format('png')->size(150)->generate($url,storage_path($qrcode));

            return response_success(['id'=>$encode_id]);
        }
        else return response_fail();
    }

    // 删除
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该产品不存在，刷新页面试试");

        $product = Product::find($id);
        if($product->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $bool = $product->delete();
        if(!$bool) return response_fail([],"删除失败，请重试");
        else return response_success([]);
    }


}