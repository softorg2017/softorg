<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgItem extends Model
{
    //
    protected $table = "softorg_items";
    protected $fillable = [
        'sort', 'type', 'active', 'user_id', 'org_id', 'admin_id', 'menu_id',
        'title', 'subtitle', 'description', 'content', 'cover_pic',
        'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

//    protected $dates = ['created_at','updated_at'];
//    public function getDates()
//    {
//        return array(); // 原形返回；
//        return array('created_at','updated_at');
//    }

    function org()
    {
        return $this->belongsTo('App\Models\Org\OrgOrganization','org_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Models\Org\OrgAdministrator','admin_id','id');
    }

    // 一对多 关联的目录
    function menu()
    {
        return $this->belongsTo('App\Models\Org\OrgMenu','menu_id','id');
    }

    // 多对多 关联的目录
    function menus()
    {
        return $this->belongsToMany('App\Models\Org\OrgMenu','softorg_org_pivot_menu_item','item_id','menu_id');
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
