<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Administrator;
use Auth, Response;

class WwwMiddleware
{
    protected $auth;
    protected $evn;
    protected $auth_check;
    protected $me;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(explode('.',request()->route()->getAction()['domain'])[0] == 'test')
        {
            if(!Auth::guard('test')->check()) // 未登录
            {
                $this->auth_check = 0;
            }
            else
            {
                $this->auth_check = 1;
                $this->me = Auth::guard('test')->user();
                view()->share('me',$this->me);
            }

            view()->share('evn','test');
        }
        else
        {
            if(!Auth::check()) // 未登录
            {
                $this->auth_check = 0;
            }
            else
            {
                $this->auth_check = 1;
                $this->me = Auth::user();
                view()->share('me',$this->me);
            }

            view()->share('evn','production');
        }

        view()->share('auth_check',$this->auth_check);
        return $next($request);

    }
}
