<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $table = "survey";
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

    function questions()
    {
        return $this->hasMany('App\Models\Question','survey_id','id');
    }


}
