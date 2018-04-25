<?php
namespace App\Models\Org;
use Illuminate\Database\Eloquent\Model;

class OrgModule extends Model
{
    //
    protected $table = "softorg_org_module";
    protected $fillable = [
        'sort', 'type', 'org_id', 'admin_id', 'menu_id', 'active', 'name', 'title', 'description', 'content', 'cover_pic',
        'order', 'style', 'column', 'link', 'img_multiple',
        'visit_num', 'share_num'
    ];
    protected $dateFormat = 'U';

//    protected $dates = ['created_at','updated_at'];
//    public function getDates()
//    {
//        return array(); // 原形返回；
//        return array('created_at','updated_at');
//    }

    function org()
    {
        return $this->belongsTo('App\Models\Org\OrgOrganization','org_id','id');
    }

    function admin()
    {
        return $this->belongsTo('App\Models\Org\OrgAdministrator','admin_id','id');
    }

    // 一对多 关联的目录
    function menu()
    {
        return $this->belongsTo('App\Models\Org\OrgMenu','menu_id','id');
    }

    // 多对多 关联的目录
    function menus()
    {
        return $this->belongsToMany('App\Models\Org\OrgMenu','softorg_org_pivot_module_menu','module_id','menu_id');
    }





}
