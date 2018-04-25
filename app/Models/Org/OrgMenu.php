<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgMenu extends Model
{
    //
    protected $table = "softorg_org_menu";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'active', 'name', 'title', 'description', 'content', 'cover_pic',
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

    // 多对多 关联的内容
    function items()
    {
        return $this->belongsToMany('App\Models\Org\OrgItem','softorg_org_pivot_menu_item','menu_id','item_id');
    }

//    function items()
//    {
//        return $this->hasMany('App\Models\Item','menu_id','id');
//    }



    function products()
    {
        return $this->hasMany('App\Models\Product','menu_id','id');
    }

    function articles()
    {
        return $this->hasMany('App\Models\Article','menu_id','id');
    }

    function activities()
    {
        return $this->hasMany('App\Models\Activity','menu_id','id');
    }

    function surveys()
    {
        return $this->hasMany('App\Models\Survey','menu_id','id');
    }

    function slides()
    {
        return $this->hasMany('App\Models\Slide','menu_id','id');
    }


}
