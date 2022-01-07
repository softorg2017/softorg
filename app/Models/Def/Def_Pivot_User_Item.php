<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;

class Def_Pivot_User_Item extends Model
{
    //
    protected $connection = 'mysql_def';
    protected $table = "pivot_user_item";
    protected $fillable = [
        'sort', 'type', 'user_id', 'item_id'
    ];
    protected $dateFormat = 'U';


    // 用户
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // ITEM
    function item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','item_id','id');
    }


}
