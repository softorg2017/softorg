<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgOrganization extends Model
{
    //
    protected $table = "softorg_organization";
    protected $fillable = [
        'sort', 'type', 'user_id', 'domain_name',
        'name', 'full_name', 'short_name', 'short', 'slogan', 'description', 'logo',
        'address', 'telephone', 'mobile', 'email',
        'qq', 'wechat_id', 'wechat_qrcode', 'weibo_name', 'weibo_address'
    ];
    protected $dateFormat = 'U';

    function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Models\Org\OrgAdministrator','admin_id','id');
    }

    function administrators()
    {
        return $this->hasMany('App\Models\Org\OrgAdministrator','org_id','id');
    }

    function ext()
    {
        return $this->hasOne('App\Models\Org\OrgOrganizationExt','org_id','id');
    }

    function website()
    {
        return $this->hasOne('App\Models\Website','org_id','id');
    }

    function websites()
    {
        return $this->hasMany('App\Models\Website','org_id','id');
    }

    function modules()
    {
        return $this->hasMany('App\Models\Org\OrgModule','org_id','id');
    }

    function menus()
    {
        return $this->hasMany('App\Models\Org\OrgMenu','org_id','id');
    }

    function items()
    {
        return $this->hasMany('App\Models\Org\OrgItem','org_id','id');
    }



    function products()
    {
        return $this->hasMany('App\Models\Product','org_id','id');
    }

    function articles()
    {
        return $this->hasMany('App\Models\Article','org_id','id');
    }

    function activities()
    {
        return $this->hasMany('App\Models\Activity','org_id','id');
    }

    function slides()
    {
        return $this->hasMany('App\Models\Slide','org_id','id');
    }

    function surveys()
    {
        return $this->hasMany('App\Models\Survey','org_id','id');
    }



}
