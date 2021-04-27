<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Softorg;
use Auth, Response;

class AtomAdminMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Auth::guard('atom_admin')->check()) // 未登录
        {
            return redirect('/admin/login');

//            $return["status"] = false;
//            $return["log"] = "admin-no-login";
//            $return["msg"] = "请先登录";
//            return Response::json($return);
        }
        else
        {
            $me = Auth::guard('atom_admin')->user();
            view()->share('atom_admin_me', $me);
        }
        return $next($request);

    }
}