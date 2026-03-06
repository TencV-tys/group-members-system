@extends('layouts.app')

@section('title', 'Manage Members')

@section('content')
<div class="flex gap-6">
    <!-- Sidebar -->
    <div class="w-64 bg-white rounded-lg shadow-lg p-6 h-fit">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Admin Menu</h2>
        <nav class="space-y-2">
            <a href="/admin/members" 
               class="block px-4 py-2 rounded-lg bg-blue-500 text-white font-medium">
                📋 Manage Members
            </a>
            <a href="/members" 
               class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                👥 All Members (View)
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
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manage Members</h1>
            <button onclick="openCreateModal()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2">
                <span class="text-xl">+</span> Add New Member
            </button>
        </div>

        <!-- Members Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Age</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Bio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($members as $member)
                    <tr class="hover:bg-gray-50" id="member-{{ $member->id }}">
                        <td class="px-6 py-4">
                            @if($member->profile_photo)
                                <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="Profile" class="w-12 h-12 rounded-full object-cover">
                            @else
                                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center">
                                    <span class="text-gray-600 text-xs">No photo</span>
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium">{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td class="px-6 py-4">{{ $member->role }}</td>
                        <td class="px-6 py-4">{{ $member->age }}</td>
                        <td class="px-6 py-4 max-w-xs truncate">{{ $member->bio ?? 'No bio' }}</td>
                        <td class="px-6 py-4">
                            <button onclick="openEditModal({{ $member->id }})" class="text-blue-600 hover:text-blue-900 mr-3 bg-blue-50 px-3 py-1 rounded">Edit</button>
                            <button onclick="deleteMember({{ $member->id }})" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($members->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No members yet. Click "Add New Member" to create one!</p>
            </div>
        @endif
    </div>
</div>

<!-- Create/Edit Modal (same as before) -->
<div id="memberModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold" id="modalTitle">Add New Member</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        
        <form id="memberForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="memberId" name="memberId">
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                <input type="text" id="first_name" name="first_name" required 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                <input type="text" id="last_name" name="last_name" required 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                <input type="text" id="role" name="role" required 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                <input type="number" id="age" name="age" required min="1" max="150"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                <textarea id="bio" name="bio" rows="3" 
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                <input type="file" id="profile_photo" name="profile_photo" accept="image/*"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                <div id="currentPhoto" class="mt-2 hidden">
                    <p class="text-sm text-gray-600">Current photo:</p>
                    <img id="currentPhotoImg" src="" alt="Current" class="w-16 h-16 rounded-full mt-1">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('modalTitle').textContent = 'Add New Member';
        document.getElementById('memberForm').reset();
        document.getElementById('memberId').value = '';
        document.getElementById('currentPhoto').classList.add('hidden');
        document.getElementById('memberModal').classList.remove('hidden');
    }

    function openEditModal(id) {
        fetch(`/admin/members/${id}/edit`)
            .then(res => res.json())
            .then(member => {
                document.getElementById('modalTitle').textContent = 'Edit Member';
                document.getElementById('memberId').value = member.id;
                document.getElementById('first_name').value = member.first_name;
                document.getElementById('last_name').value = member.last_name;
                document.getElementById('role').value = member.role;
                document.getElementById('age').value = member.age;
                document.getElementById('bio').value = member.bio || '';
                
                if (member.profile_photo) {
                    document.getElementById('currentPhotoImg').src = '/storage/' + member.profile_photo;
                    document.getElementById('currentPhoto').classList.remove('hidden');
                } else {
                    document.getElementById('currentPhoto').classList.add('hidden');
                }
                
                document.getElementById('memberModal').classList.remove('hidden');
            });
    }

    function closeModal() {
        document.getElementById('memberModal').classList.add('hidden');
    }

    document.getElementById('memberForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let id = document.getElementById('memberId').value;
        let url = id ? `/admin/members/${id}` : '/admin/members';
        let method = id ? 'POST' : 'POST';
        
        if (id) {
            formData.append('_method', 'PUT');
        }
        
        fetch(url, {
            method: method,
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

    function deleteMember(id) {
        if (confirm('Are you sure you want to delete this member?')) {
            fetch(`/admin/members/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`member-${id}`).remove();
                }
            });
        }
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('memberModal');
        if (event.target == modal) {
            closeModal();
        }
    }
</script>
@endsection