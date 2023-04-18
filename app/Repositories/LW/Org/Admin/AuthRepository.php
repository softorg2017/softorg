<?php
namespace App\Repositories\Org\Admin;

use App\Models\Softorg;
use App\Models\SoftorgExt;
use App\Administrator;
use App\Models\Website;
use App\Models\Verification;

use App\Repositories\Common\CommonRepository;
use App\Repositories\Org\MailRepository;
use Response, Auth, Validator, DB, Exception;
use QrCode;

class AuthRepository {

    private $model;
    public function __construct()
    {
    }



}