<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgRecord extends Model
{
    //
    protected $table = "softorg_org_records";
    protected $fillable = [
        'type', 'sort', 'module', 'shared_location', 'form', 'org_id', 'page_id', 'user_id', 'referer', 'from', 'open',
        'open_type', 'open_device_name', 'open_device_version', 'open_system', 'open_browser', 'open_app', 'ip'
    ];
    protected $dateFormat = 'U';

    function org()
    {
        return $this->belongsTo('App\Models\Org\OrgOrganization','org_id','id');
    }


}
