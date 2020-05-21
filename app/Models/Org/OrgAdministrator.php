<?php

namespace App\Models\Org;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OrgAdministrator extends Authenticatable
{
    use Notifiable;

    protected $table = "softorg_org_administrator";

    protected $fillable = [
        'org_id', 'active', 'name', 'mobile', 'email', 'password', 'nickname', 'truename', 'portrait_img',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dateFormat = 'U';
}
