<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Auth::user()) {
            if (Auth::user()->role == 'admin' || Auth::user()->role == 'superAdmin') {

                // user call login and register page when he login, denied url request
                if ($request->route()->getName() == 'login' || $request->route()->getName() == 'register') {
                    // abort(404);
                    return back();
                }
                // user call all request excepts login and register url
                return $next($request);
            }
            return back();
        }else{
            // when user not login , can call login and register route url
            return $next($request);
        }

    }
}
