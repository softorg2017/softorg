<?php

namespace App\Models\Outside;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class OutsideAdministrator extends Authenticatable
{
    use Notifiable;

    protected $table = "softorg_outside_administrator";

    protected $fillable = [
        'org_id', 'active', 'name', 'email', 'password', 'nickname', 'true_name', 'portrait_img',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dateFormat = 'U';
}
