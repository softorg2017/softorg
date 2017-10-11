<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    //
    protected $table = "slide";
    protected $fillable = [
        'sort', 'type','org_id',  'name', 'title', 'description', 'content'
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

    function pages()
    {
        return $this->hasMany('App\Models\Page','slide_id','id');
    }
}
