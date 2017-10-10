<?php
namespace App\Models\Admin\Activity;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $table = "activity";
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


}
