<?php

namespace App\Http\Middleware;

use Closure;
use Auth, Response;
use Lib\Wechat\TokenManager;

class WechatShareMiddleware
{

    public function handle($request, Closure $next)
    {

        $wechat_config = json_encode(TokenManager::getConfig());
        view()->share('wechat_config', $wechat_config);

        return $next($request);
    }
}
