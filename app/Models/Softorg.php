<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Softorg extends Model
{
    //
    protected $table = "softorg";
    protected $fillable = [
        'sort', 'type', 'name', 'short', 'slogan', 'description', 'logo', 'telephone', 'email', 'qq', 'wechat'
    ];
    protected $dateFormat = 'U';

    function administrators()
    {
        return $this->hasMany('App\Administrator','org_id','id');
    }

    function websites()
    {
        return $this->hasMany('App\Models\Website','org_id','id');
    }

    function menus()
    {
        return $this->hasMany('App\Models\Menu','org_id','id');
    }

    function products()
    {
        return $this->hasMany('App\Models\Product','org_id','id');
    }

    function activities()
    {
        return $this->hasMany('App\Models\Activity','org_id','id');
    }

    function slides()
    {
        return $this->hasMany('App\Models\Slide','org_id','id');
    }

    function surveys()
    {
        return $this->hasMany('App\Models\Survey','org_id','id');
    }

    function articles()
    {
        return $this->hasMany('App\Models\Article','org_id','id');
    }



}
