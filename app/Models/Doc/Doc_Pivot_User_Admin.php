<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Pivot_User_Admin extends Model
{
    //
    protected $table = "doc_pivot_user_admin";
    protected $fillable = [
        'active', 'category', 'type', 'relation_active', 'relation_category', 'relation_type', 'relation',
        'user_id', 'admin_id'
    ];
    protected $dateFormat = 'U';


    // 用户
    function belong_user()
    {
        return $this->belongsTo('App\User','belong_user_id','id');
    }

    // 用户
    function mine_user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    // 用户
    function administrator()
    {
        return $this->belongsTo('App\User','admin_id','id');
    }

    // 关联人
    function administrator_list()
    {
        return $this->hasMany('App\User','admin_id','id');
    }


}
