<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use Auth, Response, URL, Input;

class LoginTurnMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Auth::check()) // 未登录
        {
            $state = urlencode(url()->full());
            $return = request('return',null);

            if(is_weixin())
            {
                $app_id = env('WECHAT_LOOKWIT_APPID');
                $app_secret = env('WECHAT_LOOKWIT_SECRET');
                $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$app_id}&redirect_uri=http%3A%2F%2Fwww.lookwit.com%2Fweixin%2Fauth&response_type=code&scope=snsapi_userinfo&state={$state}#wechat_redirect";
                return redirect($url);
            }
            else
            {
                $app_id = env('WECHAT_WEBSITE_LOOKWIT_APPID');
                $app_secret = env('WECHAT_WEBSITE_LOOKWIT_SECRET');
                $url = "https://open.weixin.qq.com/connect/qrconnect?appid={$app_id}&redirect_uri=http%3A%2F%2Fwww.lookwit.com%2Fweixin%2Flogin&response_type=code&scope=snsapi_login&state={$state}#wechat_redirect";
                return redirect($url);
            }
        }
        else
        {
            $me = Auth::user();
            view()->share('me',$me);
        }
        return $next($request);

    }
}
