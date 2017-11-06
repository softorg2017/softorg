<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $table = "activity";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'active', 'name', 'title', 'description', 'content', 'start_time', 'end_time'
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
