<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;

class Def_Notification extends Model
{
    //
    protected $connection = 'mysql_def';
    protected $table = "notification";
    protected $fillable = [
        'active', 'notification_category', 'notification_type', 'category', 'type', 'sort', 'is_read',
        'owner_id', 'creator_id', 'user_id', 'belong_id', 'source_id', 'object_id', 'parent_id',
        'item_id', 'communication_id', 'reply_id',
        'title', 'description', 'ps', 'content'
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




    // 拥有者
    function owner()
    {
        return $this->belongsTo('App\User','owner_id','id');
    }
    // 创作者
    function creator()
    {
        return $this->belongsTo('App\User','creator_id','id');
    }
    // 用户
    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    // 归属
    function belong()
    {
        return $this->belongsTo('App\User','belong_id','id');
    }
    // 来源
    function source()
    {
        return $this->belongsTo('App\User','source_id','id');
    }
    // 对象
    function object()
    {
        return $this->belongsTo('App\User','object_id','id');
    }


    // 内容
    function item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','item_id','id');
    }

    function communication()
    {
        return $this->belongsTo('App\Models\Def\Def_Communication','communication_id','id');
    }

    function reply()
    {
        return $this->belongsTo('App\Models\Def\Def_Communication','reply_id','id');
    }


}
