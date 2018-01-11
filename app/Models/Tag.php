<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //
    protected $table = "tags";
    protected $fillable = [
        'sort', 'type', 'sort', 'org_id', 'admin_id', 'name'
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

    /**
     *  获得此标签下所有的产品。
     */
    public function products()
    {
        return $this->morphedByMany('App\Models\Product', 'taggable');
    }

    /**
     * 获得此标签下所有的文章。
     */
    public function articles()
    {
        return $this->morphedByMany('App\Models\Article', 'taggable');
    }

    /**
     * 获得此标签下所有的文章。
     */
    public function activities()
    {
        return $this->morphedByMany('App\Models\Activity', 'taggable');
    }

    /**
     * 获得此标签下所有的文章。
     */
    public function surveys()
    {
        return $this->morphedByMany('App\Models\Survey', 'taggable');
    }

    /**
     * 获得此标签下所有的文章。
     */
    public function slides()
    {
        return $this->morphedByMany('App\Models\Slide', 'taggable');
    }



}
