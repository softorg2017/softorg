<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

use App\Models\Def\Def_Notification;

use Auth, Response;

class NotificationMiddleware
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        // 执行动作
        if(Auth::check())
        {
            $me = Auth::user();
            $count = Def_Notification::where(['owner_id'=>$me->id,'is_read'=>0])->whereIn('notification_category',[9,11])->count();
            view()->share('notification_count', $count);
        }
        else view()->share('notification_count', 0);


        return $next($request);
    }
}
