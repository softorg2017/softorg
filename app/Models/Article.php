<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    //
    protected $table = "article";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'name', 'title', 'description', 'content'
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


}
