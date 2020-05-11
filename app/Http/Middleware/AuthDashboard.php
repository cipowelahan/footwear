<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;

class AuthDashboard
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
        if (Auth::check()) return $next($request);
        else {
            if ($request->ajax()) {
                return response('Please Login', 401);
            }
            else {
                return redirect()->route('login')->with('must-login', 'silahkan login');
            }
        }
    }
}
