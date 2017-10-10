<?php
namespace App\Models\Admin\Company;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = "menu";
    protected $fillable = [
        'sort', 'type', 'company_id', 'admin_id', 'name', 'title', 'description', 'content'
    ];
    protected $dateFormat = 'U';

    function company()
    {
        return $this->belongsTo('App\Models\Admin\Company\Company','company_id','id');
    }

    function products()
    {
        return $this->hasMany('App\Models\Admin\Company\Product','menu_id','id');
    }


}
