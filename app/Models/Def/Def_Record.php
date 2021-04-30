<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;

class Def_Record extends Model
{
    //
    protected $table = "def_record";
    protected $fillable = [
        'record_category', 'record_type', 'record_module', 'category', 'type', 'sort', 'form', 'module',
        'owner_id', 'creator_id', 'user_id', 'belong_id', 'source_id', 'object_id', 'visitor_id', 'item_id',
        'page_type', 'page_module', 'page_num',
        'title', 'content',
        'referer', 'from',
        'open',
        'open_device_type', 'open_device_name', 'open_device_version', 'open_system', 'open_browser', 'open_app',
        'shared_location',
        'ip'
    ];
    protected $dateFormat = 'U';


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
    // 用户
    function object()
    {
        return $this->belongsTo('App\User','object_id','id');
    }


    // 内容
    function item()
    {
        return $this->belongsTo('App\Models\Def\Def_Item','item_id','id');
    }


}
