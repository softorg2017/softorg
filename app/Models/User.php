<?php
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = "softorg_users";

    protected $fillable = [
        'status', 'sort', 'type', 'mobile', 'email', 'password', 'name', 'nickname',
        'org_id',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dateFormat = 'U';

    function ext()
    {
        return $this->hasOne('App\Models\UserExt','user_id','id');
    }

    function org()
    {
        return $this->hasOne('App\Org\OrgOrganization','user_id','id');
    }


}
