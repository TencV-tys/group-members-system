<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMembers = Member::count();
        $recentMembers = Member::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('totalMembers', 'recentMembers'));
    }
}