<?php
namespace App\Models\Outside;
use Illuminate\Database\Eloquent\Model;

class OutsideMenu extends Model
{
    //
    protected $table = "softorg_outside_menu";
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
        return $this->belongsTo('App\Models\Outside\OutsideOrganization','org_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Models\Outside\OutsideAdministrator','admin_id','id');
    }

    // 多对多 关联的内容
    function items()
    {
        return $this->belongsToMany('App\Models\Outside\OutsideItem','softorg_outside_pivot_menu_item','menu_id','item_id');
    }

    function itemsLimit4()
    {
        return $this->items()->groupBy('menu_id');
    }

//    function items()
//    {
//        return $this->hasMany('App\Models\Item','menu_id','id');
//    }




}
