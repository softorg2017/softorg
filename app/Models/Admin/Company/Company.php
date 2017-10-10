<?php
namespace App\Models\Admin\Company;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    protected $table = "company";
    protected $fillable = [
        'sort', 'type', 'name', 'short', 'slogan', 'description', 'telephone', 'email', 'qq', 'wechat'
    ];
    protected $dateFormat = 'U';

    function administrators()
    {
        return $this->hasMany('App\Administrator','company_id','id');
    }

    function websites()
    {
        return $this->hasMany('App\Models\Admin\Company\Website','company_id','id');
    }

    function menus()
    {
        return $this->hasMany('App\Models\Admin\Company\Menu','company_id','id');
    }

    function products()
    {
        return $this->hasMany('App\Models\Admin\Company\Product','company_id','id');
    }

    function activities()
    {
        return $this->hasMany('App\Models\Admin\Activity\Activity','company_id','id');
    }

    function slides()
    {
        return $this->hasMany('App\Models\Admin\Slide\Slide','company_id','id');
    }

    function surveys()
    {
        return $this->hasMany('App\Models\Admin\Survey\Survey','company_id','id');
    }

    function articles()
    {
        return $this->hasMany('App\Models\Admin\Article\Article','company_id','id');
    }



}
