<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $table = "question";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'survey_id', 'page_id', 'order', 'name', 'title', 'description', 'content'
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

    function survey()
    {
        return $this->belongsTo('App\Models\Survey','survey_id','id');
    }

    function page()
    {
        return $this->belongsTo('App\Models\Page','page_id','id');
    }

    function options()
    {
        return $this->hasMany('App\Models\Option','question_id','id');
    }

    function choices()
    {
        return $this->hasMany('App\Models\Choice','question_id','id');
    }


}
