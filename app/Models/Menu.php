<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = "menu";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'active', 'name', 'title', 'description', 'content'
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

    function items()
    {
        return $this->hasMany('App\Models\Item','menu_id','id');
    }

    function products()
    {
        return $this->hasMany('App\Models\Product','menu_id','id');
    }

    function articles()
    {
        return $this->hasMany('App\Models\Article','menu_id','id');
    }

    function activities()
    {
        return $this->hasMany('App\Models\Activity','menu_id','id');
    }

    function surveys()
    {
        return $this->hasMany('App\Models\Survey','menu_id','id');
    }

    function slides()
    {
        return $this->hasMany('App\Models\Slide','menu_id','id');
    }


}
