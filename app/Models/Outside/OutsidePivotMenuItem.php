<?php
namespace App\Models\Outside;
use Illuminate\Database\Eloquent\Model;

class OutsidePivotMenuItem extends Model
{
    //
    protected $table = "softorg_outside_pivot_menu_item";
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


    function menu()
    {
        return $this->belongsTo('App\Models\Outside\OutsideMenu','menu_id','id');
    }

    function item()
    {
        return $this->belongsTo('App\Models\Outside\OutsideItem','item_id','id');
    }



}
