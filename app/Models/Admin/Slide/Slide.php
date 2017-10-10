<?php
namespace App\Models\Admin\Slide;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //
    protected $table = "slide";
    protected $fillable = [
        'sort', 'type','company_id',  'name', 'title', 'description', 'content'
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

    function pages()
    {
        return $this->hasMany('App\Models\Admin\Slide\Page','slide_id','id');
    }
}
