<?php
namespace App\Models\Admin\Slide;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $table = "page";
    protected $fillable = [
        'sort', 'type', 'slide_id', 'order', 'admin_id', 'name', 'title', 'description', 'content'
    ];
    protected $dateFormat = 'U';

    function slide()
    {
        return $this->belongsTo('App\Models\Admin\Slide\Slide','slide_id','id');
    }
}
