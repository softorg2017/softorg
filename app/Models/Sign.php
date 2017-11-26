<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Sign extends Model
{
    //
    protected $table = "sign";
    protected $fillable = [
        'sort', 'type', 'activity_id', 'user_id', 'name', 'mobile'
    ];
    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }

    function activity()
    {
        return $this->belongsTo('App\Models\Activity','activity_id','id');
    }


}
