<?php
namespace App\Models\Root;
use Illuminate\Database\Eloquent\Model;

class RootPivotModuleMenu extends Model
{
    //
    protected $table = "root_pivot_module_menu";
    protected $fillable = [
        'sort', 'type', 'admin_id', 'module_id', 'menu_id'
    ];
    protected $dateFormat = 'U';

//    protected $dates = ['created_at','updated_at'];
//    public function getDates()
//    {
//        return array(); // 原形返回；
//        return array('created_at','updated_at');
//    }


    function module()
    {
        return $this->belongsTo('App\Models\Root\RootModule','module_id','id');
    }

    function menu()
    {
        return $this->belongsTo('App\Models\Root\RootMenu','menu_id','id');
    }



}
