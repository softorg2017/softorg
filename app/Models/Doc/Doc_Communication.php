<?php
namespace App\Models\Doc;
use Illuminate\Database\Eloquent\Model;

class Doc_Communication extends Model
{
    //
    protected $table = "doc_communication";
    protected $fillable = [
        'active', 'communication_category', 'communication_type', 'category', 'type', 'sort',
        'owner_id', 'creator_id', 'user_id', 'belong_id', 'source_id', 'object_id', 'parent_id',
        'item_id', 'communication_id', 'reply_id', 'dialog_id', 'order',
        'title', 'description', 'ps', 'content',
        'is_anonymous', 'is_shared',
        'support',
        'favor_num', 'comment_num'
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


    // 内容
    function item()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Item','item_id','id');
    }

    //
    function chapter()
    {
        return $this->belongsTo('App\Models\Content','content_id','id');
    }

    // 回复
    function reply()
    {
        return $this->belongsTo('App\Models\Doc\Doc_Communication','reply_id','id');
    }

    // 子节点
    function children()
    {
        return $this->hasMany('App\Models\Doc\Doc_Communication','reply_id','id');
    }

    // 对话
    function dialogs()
    {
        return $this->hasMany('App\Models\Doc\Doc_Communication','dialog_id','id');
    }

    // 点赞
    function favors()
    {
        return $this->hasMany('App\Models\Doc\Doc_Communication','reply_id','id');
    }

    /**
     * 获得此人的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

}
