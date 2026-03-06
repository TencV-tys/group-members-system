@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container mx-auto">
    <!-- Welcome Banner -->
   <div class="bg-blue-600 rounded-lg shadow-lg p-6 text-white mb-6">
        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="text-blue-100">Admin Dashboard - Manage your group members</p>
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

    <!-- Quick Stats Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Stats</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center pb-2 border-b">
                    <span class="text-gray-600">Total Members:</span>
                    <span class="font-bold text-blue-600 text-xl">{{ $totalMembers }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Roles:</span>
                    <span class="font-bold text-green-600 text-xl">{{ \App\Models\Member::distinct('role')->count('role') }}</span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-3">
                <a href="/admin/members/table" class="bg-blue-50 hover:bg-blue-100 text-blue-700 p-3 rounded-lg text-center transition">
                    👥 View Members
                </a>
                <a href="/admin/members" class="bg-green-50 hover:bg-green-100 text-green-700 p-3 rounded-lg text-center transition">
                    ✏️ Manage Members
                </a>
                <a href="#" onclick="openCreateModal()" class="bg-purple-50 hover:bg-purple-100 text-purple-700 p-3 rounded-lg text-center transition col-span-2">
                    + Add New Member
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Members Table -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-gray-800">Recent Members</h2>
            <a href="/admin/members/table" class="text-sm text-blue-600 hover:text-blue-800">View All →</a>
        </div>
        
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
                        <tr class="hover:bg-gray-50 cursor-pointer" onclick="window.location.href='/admin/members/table'">
                            <td class="px-6 py-4">
                                @if($member->profile_photo)
                                    <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-image.png') }}" alt="Default profile" class="w-10 h-10 rounded-full object-cover">
                                @endif
                            </td>
                            <td class="px-6 py-4 font-medium">{{ $member->first_name }} {{ $member->last_name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                    {{ $member->role }}
                                </span>
                            </td>
                            <td class="px-6 py-4">{{ $member->age }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $member->created_at->diffForHumans() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- Create Modal (for quick add from dashboard) -->
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Add New Member</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        
        <form id="createForm" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4 max-h-[60vh] overflow-y-auto p-1">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                    <input type="text" id="first_name" name="first_name" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <input type="text" id="role" name="role" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                    <input type="number" id="age" name="age" required min="1" max="150"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                    <textarea id="bio" name="bio" rows="3" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                    <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6 pt-3 border-t">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createForm').reset();
    }

    function closeModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    // Handle Create Form Submit
    document.getElementById('createForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        
        fetch('/admin/members', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeModal();
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('createModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
@endsection