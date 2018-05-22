<?php
namespace App\Repositories\Outside;

use App\Models\Outside\OutsideModule;
use App\Models\Outside\OutsideMenu;
use App\Models\Outside\OutsideItem;
use App\Models\Outside\OutsideTemplate;

use App\Repositories\Common\CommonRepository;

use Response, Auth, Validator, DB, Exception, Cache;
use QrCode;

class OutsideCommonRepository {

    private $model;
    private $repo;
    public function __construct()
    {
//        $this->model = new OutsideTemplate();
    }


    public function set_cache_root_is_refresh()
    {
        $cache_key_root_is_refresh = config('outside.cache.key.root_is_refresh');
        Cache::put($cache_key_root_is_refresh, 1, 60*24*7);
    }


}