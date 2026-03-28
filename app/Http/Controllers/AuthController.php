<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|string',
        'password' => 'required'
    ]);

    $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

    if (Auth::attempt([$field => $request->email, 'password' => $request->password], $request->remember)) {
        $request->session()->regenerate();
        
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            return redirect()->intended('/admin/dashboard')
                ->with('success', 'Welcome back, Admin!');
        }
        
        // Redirect regular users to member dashboard
        return redirect()->intended('/dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}

    /**
     * Handle logout - FIXED VERSION
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // CHANGED FROM '/' TO '/login'
        return redirect('/login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show registration form (optional - if you want registration)
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration (optional - if you want registration)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user' // Default role for new registrations
        ]);

        Auth::login($user);

        return redirect('/dashboard')
            ->with('success', 'Registration successful! Welcome aboard!');
    }
}