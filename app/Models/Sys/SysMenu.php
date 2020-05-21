<?php
namespace App\Models\Sys;
use Illuminate\Database\Eloquent\Model;

class SysMenu extends Model
{
    //
    protected $table = "softorg_sys_menu";
    protected $fillable = [
        'active', 'sort', 'type', 'admin_id', 'name', 'title', 'subtitle', 'description', 'content', 'cover_pic',
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
        return $this->belongsTo('App\Models\Sys\SysAdministrator','admin_id','id');
    }

    // 多对多 关联的内容
    function items()
    {
        return $this->belongsToMany('App\Models\Sys\SysItem','softorg_sys_pivot_menu_item','menu_id','item_id');
    }

//    function items()
//    {
//        return $this->hasMany('App\Models\Item','menu_id','id');
//    }


}
