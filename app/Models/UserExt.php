<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UserExt extends Model
{
    //
    protected $table = "softorg_user_ext";

    protected $fillable = [
        'sort', 'type', 'user_id', 'name', 'custom',
    ];

    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }


}
