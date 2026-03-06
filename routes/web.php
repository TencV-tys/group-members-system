<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Admin\DashboardController;

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

// Admin routes (all protected)
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // All Members (Table View) - ADD THIS LINE
    Route::get('/members/table', [MemberController::class, 'adminTableView'])->name('admin.members.table');
    
    // Member Management (CRUD)
    Route::get('/members', [MemberController::class, 'adminIndex'])->name('admin.members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('admin.members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('admin.members.store');
    Route::get('/members/{member}/edit', [MemberController::class, 'edit'])->name('admin.members.edit');
    Route::put('/members/{member}', [MemberController::class, 'update'])->name('admin.members.update');
    Route::delete('/members/{member}', [MemberController::class, 'destroy'])->name('admin.members.destroy');
});