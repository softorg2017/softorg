<?php

namespace App\Models\Sys;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SysAdministrator extends Authenticatable
{
    use Notifiable;

    protected $table = "softorg_sys_administrator";

    protected $fillable = [
        'active', 'sort', 'type', 'mobile', 'email', 'password', 'name', 'nickname', 'true_name', 'portrait_img',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dateFormat = 'U';
}
