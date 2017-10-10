<?php
namespace App\Models\Admin\Survey;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    //
    protected $table = "survey";
    protected $fillable = [
        'sort', 'type', 'company_id', 'admin_id', 'name', 'title', 'description', 'content'
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

    function questions()
    {
        return $this->hasMany('App\Models\Admin\Survey\Question','survey_id','id');
    }


}
