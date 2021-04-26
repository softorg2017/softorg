<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Administrator;
use Auth, Response, URL, Input;

class TurnToLoginMiddleware
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
            $url = urlencode(url()->full());

            if(is_weixin())
            {
                return redirect('https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx1bb8231a70478cba&redirect_uri=http%3A%2F%2Fsoftdoc.cn%2Fweixin%2Fauth&response_type=code&scope=snsapi_userinfo&state='.$url.'#wechat_redirect');
            }
            else
            {
                return redirect('https://open.weixin.qq.com/connect/qrconnect?appid=wxaf993c7aace04371&redirect_uri=http%3A%2F%2Fsoftdoc.cn%2Fweixin%2Flogin&response_type=code&scope=snsapi_login&state='.$url.'#wechat_redirect');
            }
        }
        return $next($request);

    }
}
