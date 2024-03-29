<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;


use Auth, Response;

class SuperMiddleware
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
            if(!Auth::guard('test_super')->check()) // 未登录
            {
                return redirect('/admin/login');

//            $return["status"] = false;
//            $return["log"] = "admin-no-login";
//            $return["msg"] = "请先登录";
//            return Response::json($return);

            }
            else
            {
                $this->auth_check = 1;
                $this->me = Auth::guard('test_super')->user();
            }


        }
        else
        {
            if(!Auth::guard('super')->check()) // 未登录
            {
                return redirect('/admin/login');

//            $return["status"] = false;
//            $return["log"] = "admin-no-login";
//            $return["msg"] = "请先登录";
//            return Response::json($return);

            }
            else
            {
                $this->auth_check = 1;
                $this->me = Auth::guard('super')->user();
            }

        }

        view()->share('me',$this->me);
        view()->share('auth_check',$this->auth_check);
        return $next($request);
    }
}
