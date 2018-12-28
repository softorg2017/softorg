<?php
namespace App\Repositories\Root\Admin;

use App\Models\Root\RootModule;
use App\Models\Root\RootMenu;
use App\Models\Root\RootItem;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode;

class MenuRepository {

    private $model;
    private $repo;
    private $commonRepo;
    public function __construct()
    {
        $this->model = new RootMenu;
        $this->commonRepo = new CommonRepository();
    }

    // 返回【列表】数据
    public function get_list_datatable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $query = RootMenu::select("*")->withCount(['items'])->with(['admin']);

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

        $list = $query->skip($skip)->take($limit)->get();

        foreach ($list as $k => $v)
        {
            $list[$k]->encode_id = encode($v->id);
        }
        return datatable_response($list, $draw, $total);
    }

    // 返回列表数据
    public function get_items_list_datatable($post_data)
    {
        $id = $post_data["id"];
        $decode_id = decode($id);

        $org_id = Auth::guard('admin')->user()->org_id;
//        $query = OrgItem::select("*")->with(['admin','menus'])->where('id',$decode_id);
        // 单目录
        $query = RootMenu::find($decode_id)->items()->with(['admin','menu']);
        // 多目录
//        $query = RootMenu::find($decode_id)->items()->with(['admin','menu','pivot_menus']);
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
            // 多目录
//            foreach ($v->pivot_menus as $key => $val)
//            {
//                $val->encode_id = encode($val->id);
//            }
        }
        return datatable_response($list, $draw, $total);
    }



    // 返回【添加】视图
    public function view_items()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        $mine = RootMenu::find($decode_id);
        if($mine)
        {
            unset($mine->id);
            return view('root.admin.menu.items')->with(['encode_id'=>$id, 'data'=>$mine]);
        }
        else return response("该目录不存在！", 404);
    }

    // 返回【添加】视图
    public function view_create()
    {
        return view('root.admin.menu.edit')->with(['operate'=>'create', 'encode_id'=>encode(0)]);
    }

    // 返回【编辑】视图
    public function view_edit()
    {
        $id = request("id",0);
        $decode_id = decode($id);
        if(!$decode_id) return response("参数有误", 404);

        if($decode_id == 0) return view('root.admin.menu.edit')->with(['operate'=>'create', 'encode_id'=>$id, 'category'=>'']);
        else
        {
            $mine = RootMenu::with(['items'])->find($decode_id);
            if($mine)
            {
                unset($mine->id);
                return view('root.admin.menu.edit')->with(['operate'=>'edit', 'encode_id'=>$id, 'data'=>$mine, 'category'=>'']);
            }
            else return response("该目录不存在！", 404);
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

        $admin = Auth::guard('admin')->user();

        $decode_id = decode($post_data["encode_id"]);
        if(intval($decode_id) !== 0 && !$decode_id) return response_error();


        // 判断操作类型
        $operate = $post_data["operate"];
        if($operate == 'create') // 添加 ( $id==0，添加一个新的目录 )
        {
            $mine = new RootMenu;
            $post_data["admin_id"] = $admin->id;
            $post_data["org_id"] = $admin->org_id;
        }
        else if($operate == 'edit') // 修改
        {
            $mine = RootMenu::find($decode_id);
            if(!$mine) return response_error([],"该目录不存在，刷新页面试试");
            if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        }
        else return response_error([],"参数有误");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $bool = $mine->fill($post_data)->save();
            if($bool) {

                $encode_id = encode($mine->id);

                // 封面图片
                if(!empty($post_data["cover"]))
                {
                    // 删除原封面图片
                    $mine_cover_pic = $mine->cover_pic;
                    if(!empty($mine_cover_pic) && file_exists(storage_path("resource/" . $mine_cover_pic)))
                    {
                        unlink(storage_path("resource/" . $mine_cover_pic));
                    }

                    $upload = new CommonRepository();
                    $result = $upload->upload($post_data["cover"], 'root-unique-menus' , 'cover_menu_'.$encode_id);
                    if($result["status"])
                    {
                        $mine->cover_pic = $result["data"];
                        $mine->save();
                    }
                    else throw new Exception("upload-cover-fail");
                }
            }
            else throw new Exception("insert--menu--fail");

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



    // 返回【排序】视图
    public function view_sort()
    {
        $admin = Auth::guard('admin')->user();
        $org_id = $admin->org_id;

        $mine = RootMenu::where(['org_id'=>$org_id])->orderBy('order', 'asc')->get();
        return view('admin.menu.sort')->with(['data'=>$mine]);
    }

    // 【排序】
    public function sort($post_data)
    {
        $admin = Auth::guard('admin')->user();

        $admin_decode = decode($post_data["admin"]);
        if(!$admin) return response_error();
        if($admin->id == $admin_decode)
        {
            $menus = collect($post_data['menu'])->values()->toArray();

            foreach($menus as $k => $v)
            {
                $id = $v['id'];
                $menu = RootMenu::find($id);
                if(!$menu) return response_error();
                $menu->order = $k;
                $bool = $menu->save();
            }
            return response_success();
        }
        else return response_fail([],'用户有变更，请刷新重试！');

    }



    // 【删除】
    public function delete($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootMenu::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");

        // 启动数据库事务
        DB::beginTransaction();
        try
        {
            $content = $mine->content;
            $cover_pic = $mine->cover_pic;

            $bool = $mine->delete();
            if(!$bool) throw new Exception("delete--menu--fail");

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
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootMenu::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 1;
        $bool = $mine->fill($update)->save();
        if(!$bool) return response_fail([],"启用失败，请重试");
        else return response_success([]);
    }

    // 【禁用】
    public function disable($post_data)
    {
        $admin = Auth::guard('admin')->user();
        $id = decode($post_data["id"]);
        if(intval($id) !== 0 && !$id) return response_error([],"该目录不存在，刷新页面试试");

        $mine = RootMenu::find($id);
        if($mine->admin_id != $admin->id) return response_error([],"你没有操作权限");
        $update["active"] = 9;
        $bool = $mine->fill($update)->save();
        if(!$bool) return response_fail([],"禁用失败，请重试");
        else return response_success([]);
    }



}