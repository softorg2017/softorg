<?php
namespace App\Models\Admin\Survey;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $table = "question";
    protected $fillable = [
        'sort', 'type', 'survey_id', 'name', 'title', 'description', 'content'
    ];
    protected $dateFormat = 'U';

    function survey()
    {
        return $this->belongsTo('App\Models\Admin\Survey\Survey','survey_id','id');
    }


}
