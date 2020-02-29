<?php

namespace App\Http\Middleware;

use Closure;

class CheckIdentity
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
        $users=session('users_id');
        if(!$users){
            return redirect('/logins');
        }
        return $next($request);
    }
}
