<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class UserExt extends Model
{
    //
    protected $table = "user_ext";
    protected $fillable = [
        'sort', 'type', 'user_id', 'name',
    ];
    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }


}
