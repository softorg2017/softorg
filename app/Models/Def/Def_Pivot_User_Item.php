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
