<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $table = "records";
    protected $fillable = [
        'type', 'sort', 'module', 'shared_location', 'form', 'org_id', 'page_id', 'user_id', 'referer', 'from', 'open',
        'open_type', 'open_device_name', 'open_device_version', 'open_system', 'open_browser', 'open_app', 'ip'
    ];
    protected $dateFormat = 'U';

    function org()
    {
        return $this->belongsTo('App\Models\Softorg','org_id','id');
    }


}
