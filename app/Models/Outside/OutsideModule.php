<?php
namespace App\Models\Outside;
use Illuminate\Database\Eloquent\Model;

class OutsideModule extends Model
{
    //
    protected $table = "softorg_outside_module";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'menu_id', 'active', 'name', 'title', 'description', 'content', 'cover_pic',
        'order', 'style', 'column', 'link', 'img_multiple',
        'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

//    protected $dates = ['created_at','updated_at'];
//    public function getDates()
//    {
//        return array(); // 原形返回；
//        return array('created_at','updated_at');
//    }


    function admin()
    {
        return $this->belongsTo('App\Models\Outside\OutsideAdministrator','admin_id','id');
    }

    // 一对多 关联的目录
    function menu()
    {
        return $this->belongsTo('App\Models\Outside\OutsideMenu','menu_id','id');
    }

    // 多对多 关联的目录
    function menus()
    {
        return $this->belongsToMany('App\Models\Outside\OutsideMenu','softorg_outside_pivot_module_menu','module_id','menu_id');
    }





}
