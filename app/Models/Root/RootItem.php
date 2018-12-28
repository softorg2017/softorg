<?php
namespace App\Models\Root;
use Illuminate\Database\Eloquent\Model;

class RootItem extends Model
{
    //
    protected $table = "root_item";
    protected $fillable = [
        'sort', 'category', 'type', 'admin_id', 'menu_id', 'active',
        'name', 'title', 'subtitle', 'description', 'content', 'custom', 'custom2', 'custom3', 'link_url', 'cover_pic',
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
        return $this->belongsTo('App\Administrator','admin_id','id');
    }

    // 一对多 反向关联的目录（所属目录）
    function menu()
    {
        return $this->belongsTo('App\Models\Root\RootMenu','menu_id','id');
    }

    // 多对多 关联的目录
    function pivot_menus()
    {
        return $this->belongsToMany('App\Models\Root\RootMenu','root_pivot_menu_item','item_id','menu_id');
    }


    /**
     * 获得此文章的所有评论。
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'itemable');
    }

    /**
     * 获得此文章的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
}
