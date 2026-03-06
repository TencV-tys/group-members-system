<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Check if user is logged in
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $user = Auth::user();
        

        // Check multiple ways
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return $next($request);
        }
        
        // Fallback to direct role check
        if ($user->role === 'admin') {
            return $next($request);
        }

        // If not admin, redirect to dashboard
        return redirect('/dashboard')->with('error', 'You do not have permission to access the admin area.');
    }
}