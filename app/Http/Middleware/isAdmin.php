<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            if (Auth::user()->role_id == 2) {
                $request->session()->put('isAdmin', Auth::user());
                return  $next($request);
            } else if (Auth::user()->role_id == 3) {
                $request->session()->put('isAdmin', Auth::user());
                return  $next($request);
            } else if (Auth::user()->role_id == 4) {
                $request->session()->put('isAdmin', Auth::user());
                return  $next($request);
            } else {
                abort('404');
            }
        } else {
            Auth::logout();
            return redirect(url('login'));
        }
    }
}
