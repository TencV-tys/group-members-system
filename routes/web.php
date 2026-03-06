<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;

// Home page
Route::get('/', function () {
    return view('home');
})->name('home');

// Members page (public)
Route::get('/members', [MemberController::class, 'index'])->name('members.index');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User dashboard (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('user.dashboard');
    })->name('user.dashboard');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
    
    Route::get('/members', [MemberController::class, 'adminIndex'])->name('admin.members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('admin.members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('admin.members.store');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('admin.members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('admin.members.destroy');
});