<?php
namespace App\Repositories\Atom\Admin;

use App\User;
use App\Models\Doc\Doc_Item;

use App\Repositories\Common\CommonRepository;
use App\Repositories\Common\MailRepository;

use Response, Auth, Validator, DB, Exception;
use QrCode, Excel;


class AtomAuthRepository {

    private $model;
    public function __construct()
    {
    }


}