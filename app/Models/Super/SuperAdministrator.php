<?php

namespace App\Models\Super;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdministrator extends Authenticatable
{
    use Notifiable;

    protected $table = "softorg_super_administrator";

    protected $fillable = [
        'org_id', 'active', 'name', 'email', 'password', 'nickname', 'true_name', 'portrait_img',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dateFormat = 'U';
}
