<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    //
    protected $table = "choice";
    protected $fillable = [
        'sort', 'type', 'answer_id', 'question_id', 'option_id', 'text'
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

    function answer()
    {
        return $this->belongsTo('App\Models\Survey','answer_id','id');
    }

    function question()
    {
        return $this->belongsTo('App\Models\Question','question_id','id');
    }

    function option()
    {
        return $this->hasMany('App\Models\Option','question_id','id');
    }


}
