<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    protected $table = "question";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'survey_id', 'page_id', 'name', 'title', 'description', 'content'
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


}
