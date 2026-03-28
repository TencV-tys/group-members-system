<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 
class UserMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        if (Auth::user()->isUser()) {
            return $next($request);
        }

        return redirect('/admin/dashboard')->with('error', 'This area is for regular users only.');
    }
}