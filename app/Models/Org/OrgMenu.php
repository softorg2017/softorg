<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgMenu extends Model
{
    //
    protected $table = "softorg_org_menu";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'active', 'name', 'title', 'description', 'content',
        'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

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
    function menus()
    {
        return $this->belongsToMany('App\Models\Org\OrgMenu','softorg_org_pivot_menu_item','item_id','menu_id');
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
