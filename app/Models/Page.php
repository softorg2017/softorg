<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $table = "page";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'slide_id', 'order', 'admin_id', 'name', 'title', 'description', 'content'
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

    function slide()
    {
        return $this->belongsTo('App\Models\Slide','slide_id','id');
    }
}
