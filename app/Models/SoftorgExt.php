<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SoftorgExt extends Model
{
    //
    protected $table = "softorg_ext";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'home', 'information', 'introduction', 'contactus', 'culture'
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
