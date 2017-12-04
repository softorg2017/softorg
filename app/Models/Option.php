<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $table = "option";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'survey_id', 'question_id', 'name', 'title', 'description', 'content'
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

    function question()
    {
        return $this->belongsTo('App\Models\Question','question_id','id');
    }

    function choices()
    {
        return $this->hasMany('App\Models\Choice','option_id','id');
    }


}
