<?php

namespace App\Http\Middleware;

use Closure;

class Adminview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(\Auth::check())
        {
            $userRole= \Auth::user()->employee->userrole->role_id;

            if($userRole == '1' || $userRole == '7')
            {
                return $next($request);
            }
        }
        return redirect('/noaccess');
    }

}
