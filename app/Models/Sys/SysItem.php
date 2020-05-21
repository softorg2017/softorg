<?php
namespace App\Models\Sys;
use Illuminate\Database\Eloquent\Model;

class SysItem extends Model
{
    //
    protected $table = "softorg_sys_item";
    protected $fillable = [
        'sort', 'type', 'admin_id', 'menu_id', 'active',
        'name', 'title', 'subtitle', 'description', 'content', 'cover_pic',
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

    // 一对多 关联的目录
    function menu()
    {
        return $this->belongsTo('App\Models\Sys\SysMenu','menu_id','id');
    }

    // 多对多 关联的目录
    function menus()
    {
        return $this->belongsToMany('App\Models\Sys\SysMenu','softorg_sys_pivot_menu_item','item_id','menu_id');
    }


    /**
     * 获得此文章的所有评论。
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Sys\Comment', 'itemable');
    }

    /**
     * 获得此文章的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Sys\Tag', 'taggable');
    }
}
