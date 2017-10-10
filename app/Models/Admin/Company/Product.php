<?php
namespace App\Models\Admin\Company;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = "product";
    protected $fillable = [
        'sort', 'type', 'company_id', 'admin_id', 'menu_id', 'name', 'title', 'description', 'content'
    ];
    protected $dateFormat = 'U';

    function company()
    {
        return $this->belongsTo('App\Models\Admin\Company\Company','company_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Administrator','admin_id','id');
    }

    function menu()
    {
        return $this->belongsTo('App\Models\Admin\Company\Menu','menu_id','id');
    }
}
