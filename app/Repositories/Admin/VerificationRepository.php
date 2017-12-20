<?php
namespace App\Repositories\Admin;

use App\Models\Verification;
use Response, Auth, Validator, DB, Exception;

class VerificationRepository {

    private $model;
    public function __construct()
    {
        $this->model = new Verification;
    }




}