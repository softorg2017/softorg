<?php
namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $connection = 'mysql0';

    protected $table = "user";

    protected $fillable = [
        'active', 'status', 'user_active', 'user_status', 'user_category', 'user_group', 'user_type', 'category', 'group', 'type',
        'parent_id', 'p_id',
        'name', 'username', 'nickname', 'true_name', 'description', 'portrait_img', 'tag',
        'mobile', 'telephone', 'email', 'password',
        'wx_unionid',
        'introduction_id', 'advertising_id',
        'QQ_number', 'wechat_id', 'wechat_qr_code_img', 'weibo_name', 'weibo_address', 'website',
        'contact_address',
        'contact_phone', 'contact_wechat_id', 'contact_wechat_qr_code_img',
        'linkman', 'linkman_phone', 'linkman_wechat_id', 'linkman_wechat_qr_code_img',
        'visit_num', 'share_num', 'favor_num',  'follow_num', 'fans_num',
    ];

    protected $hidden = [
        'password', 'wx_unionid', 'remember_token',
    ];

    protected $dateFormat = 'U';

    function ext()
    {
        return $this->hasOne('App\UserExt','user_id','id');
    }


}
