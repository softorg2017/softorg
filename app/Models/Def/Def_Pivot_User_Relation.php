<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;

class Def_Pivot_User_Relation extends Model
{
    //
    protected $connection = 'mysql_def';
    protected $table = "pivot_user_relation";
    protected $fillable = [
        'active', 'category', 'type', 'relation_active', 'relation_category', 'relation_type', 'relation',
        'mine_user_id', 'relation_user_id'
    ];
    protected $dateFormat = 'U';


    public function __construct()
    {
        parent::__construct();

        if(explode('.',request()->route()->getAction()['domain'])[0] == 'test')
        {
            $this->connection = 'mysql_test';
        }
        else
        {
            $this->connection = 'mysql_def';
        }
    }




    // 用户
    function belong_user()
    {
        return $this->belongsTo('App\User','belong_user_id','id');
    }

    // 用户
    function mine_user()
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
