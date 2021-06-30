<?php
namespace App\Models\Def;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Def_District extends Model
{
    use SoftDeletes;
    //
    protected $table = "def_district";
    protected $fillable = [
        'active', 'district_category', 'district_type', 'district_number', 'postcode',  'area_code',
        'owner_id', 'creator_id', 'user_id', 'belong_id', 'source_id', 'object_id', 'parent_id',
        'item_id', 'communication_id',
        'name', 'title', 'description', 'ps', 'content',
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




    // 父节点
    function parent()
    {
        return $this->belongsTo('App\Models\Def\Def_District','parent_id','id');
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
