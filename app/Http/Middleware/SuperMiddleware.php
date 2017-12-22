<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Softorg;
use Auth, Response;

class SuperMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if(!Auth::guard('admin')->check()) // 未登录
        {
            return redirect('/admin/login');

//            $return["status"] = false;
//            $return["log"] = "admin-no-login";
//            $return["msg"] = "请先登录";
//            return Response::json($return);
        }
        else
        {
            $admin = Auth::guard('admin')->user();
            if($admin->id != 1)
            {
                return redirect('/admin/login');
            }
            else
            {
//                $org_id = $admin->org_id;
//                $org = Softorg::find($org_id);
//                view()->share('org', $org);
            }
        }
        return $next($request);

    }
}
