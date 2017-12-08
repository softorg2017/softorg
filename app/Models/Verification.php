<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    //
    protected $table = "verification";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'user_id', 'email', 'mobile', 'code'
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

    function admin()
    {
        return $this->belongsTo('App\Administrator','admin_id','id');
    }


}
