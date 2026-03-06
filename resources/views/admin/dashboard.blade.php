@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="flex gap-6">
    <!-- Sidebar -->
    <div class="w-64 bg-white rounded-lg shadow-lg p-6 h-fit">
        <h2 class="text-lg font-semibold text-gray-800 mb-6">Admin Menu</h2>
        <nav class="space-y-2">
            <!-- Dashboard -->
            <a href="/admin/dashboard" 
               class="block px-4 py-2 rounded-lg {{ request()->is('admin/dashboard') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                📊 Dashboard
            </a>
            
            <!-- Manage Members -->
            <a href="/admin/members" 
               class="block px-4 py-2 rounded-lg {{ request()->is('admin/members') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                ✏️ Manage Members
            </a>
            
            <!-- View All Members (Public View) -->
            <a href="/members" 
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                👥 View All Members
            </a>
        </nav>
        
        <!-- Quick Stats -->
        <div class="mt-8 pt-4 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600 uppercase mb-3">Quick Stats</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Members:</span>
                    <span class="font-bold text-blue-600">{{ $totalMembers }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1">
        <!-- Welcome Banner -->
        <div class="bg-gradient-to from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white mb-6">
            <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="text-blue-100">Here's what's happening with your group today.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Members</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $totalMembers }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Roles</p>
                        <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Member::distinct('role')->count('role') }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Recent Additions</p>
                        <p class="text-3xl font-bold text-gray-800">{{ $recentMembers->count() }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Members Table -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Members</h2>
            
            @if($recentMembers->isEmpty())
                <p class="text-gray-500 text-center py-4">No members added yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Added</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($recentMembers as $member)
                            <tr>
                                <td class="px-6 py-4">
                                    @if($member->profile_photo)
                                        <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <span class="text-gray-600 text-xs font-bold">
                                                {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $member->first_name }} {{ $member->last_name }}</td>
                                <td class="px-6 py-4">{{ $member->role }}</td>
                                <td class="px-6 py-4">{{ $member->age }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $member->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 text-right">
                    <a href="/admin/members" class="text-blue-500 hover:text-blue-700 text-sm font-medium">
                        View All Members →
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection