<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class AdminMiddleware
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
        if(Auth::user()->usergroup == 'Admin')
        {
            return $next($request);
        }else
        {
            return redirect('/home')->with('status','Employee tidak bisa mengakses form Admin');
        }
    }
}
