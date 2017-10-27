<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $table = "answer";
    protected $fillable = [
        'sort', 'type', 'user_id', 'survey_id', 'slide_id', 'page_id'
    ];
    protected $dateFormat = 'U';

    function org()
    {
        return $this->belongsTo('App\Models\Softorg','org_id','id');
    }

    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    function choices()
    {
        return $this->hasMany('App\Models\Choice','answer_id','id');
    }

    function survey()
    {
        return $this->belongsTo('App\Models\Survey','survey_id','id');
    }

    function page()
    {
        return $this->belongsTo('App\Models\Page','page_id','id');
    }


}
