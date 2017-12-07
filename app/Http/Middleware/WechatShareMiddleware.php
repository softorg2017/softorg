<?php

namespace App\Http\Middleware;

use Closure;
use Auth, Response;

class WechatShareMiddleware
{

    public function handle($request, Closure $next)
    {
        $string = "jsapi_ticket=HoagFKDcsGMVCIY2vOjf9nzhkKortt07_TqfuxtJ_AUc8rukR4TLzJVXm8EwEi43gyiVaYBvVJzHZSKiAMvGIg&noncestr=Softorg20171010Softorg20171207&timestamp=1512624767&url=".url()->full();
        request()->url();
        $signature = sha1($string);
        view()->share('signature', $signature);

        return $next($request);
    }
}
