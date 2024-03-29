<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "product";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'item_id', 'menu_id', 'active', 'name', 'title', 'description', 'content', 'cover_pic',
        'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

    function org()
    {
        return $this->belongsTo('App\Models\Softorg','org_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Administrator','admin_id','id');
    }

    function item()
    {
        return $this->belongsTo('App\Models\Item','item_id','id');
    }

    function menu()
    {
        return $this->belongsTo('App\Models\Menu','menu_id','id');
    }

    /**
     * 获得此文章的所有评论。
     */
    public function comments()
    {
        return $this->morphMany('App\Models\Comment', 'itemable');
    }

    /**
     * 获得此文章的所有标签。
     */
    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }
}
