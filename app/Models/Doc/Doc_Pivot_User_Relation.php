<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Pivot_User_Relation extends Model
{
    //
    protected $table = "doc_pivot_user_relation";
    protected $fillable = [
        'sort', 'type', 'relation', 'relation_type', 'mine_user_id', 'relation_user_id'
    ];
    protected $dateFormat = 'U';


    // 用户
    function mine()
    {
        return $this->belongsTo('App\User','mine_user_id','id');
    }

    // 用户
    function relation_user()
    {
        return $this->belongsTo('App\User','relation_user_id','id');
    }

    // 关联人
    function relations()
    {
        return $this->hasMany('App\User','relation_user_id','id');
    }


}
