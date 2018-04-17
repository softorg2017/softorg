<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgOrganizationExt extends Model
{
    //
    protected $table = "softorg_organization_ext";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'home', 'information', 'introduction', 'contactus', 'culture'
    ];
    protected $dateFormat = 'U';

    function org()
    {
        return $this->belongsTo('App\Models\Org\OrgOrganization','org_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Models\Org\OrgAdministrator','admin_id','id');
    }



}
