<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAdminAuthenticated
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
        // If request comes from logged in user, he will
        // be redirect to home page.
        if (Auth::guard('web')->check()) {
            return redirect('/home');
        }

        // If request comes from logged in admin, he will
        // be redirected to seller's home page.
        if (Auth::guard('web_admin')->check()) {
            return redirect('/global');
        }

        return $next($request);
    }
}
