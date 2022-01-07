<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Pivot_User_Item extends Model
{
    //
    protected $connection = 'mysql_doc';
    protected $table = "pivot_user_item";
    protected $fillable = [
        'sort', 'type', 'user_id', 'item_id', 'content_id'
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
        return $this->belongsTo('App\Models\Doc_Item','item_id','id');
    }


}
