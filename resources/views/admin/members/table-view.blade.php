@extends('layouts.app')

@section('title', 'All Members - Admin View')

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
            
            <!-- All Members (Table View) -->
            <a href="/admin/members/table" 
               class="block px-4 py-2 rounded-lg {{ request()->is('admin/members/table') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                👥 All Members (Table)
            </a>
            
            <!-- Manage Members (CRUD) -->
            <a href="/admin/members" 
               class="block px-4 py-2 rounded-lg {{ request()->is('admin/members') && !request()->is('admin/members/table') ? 'bg-blue-500 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition">
                ✏️ Manage Members
            </a>
        </nav>
        
        <!-- Quick Stats -->
        <div class="mt-8 pt-4 border-t border-gray-200">
            <h3 class="text-sm font-semibold text-gray-600 uppercase mb-3">Quick Stats</h3>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Members:</span>
                    <span class="font-bold text-blue-600">{{ $members->count() }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">All Members</h1>
        
        @if($members->isEmpty())
            <p class="text-gray-500 text-center py-12">No members found.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($members as $member)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->profile_photo)
                                    <img src="{{ asset('storage/' . $member->profile_photo) }}" 
                                         alt="Profile" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center">
                                        <span class="text-gray-600 text-xs font-bold">
                                            {{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap font-medium">
                                {{ $member->first_name }} {{ $member->last_name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    {{ $member->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $member->age }}
                            </td>
                            <td class="px-6 py-4 max-w-xs truncate">
                                {{ $member->bio ?? 'No bio provided' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $member->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection