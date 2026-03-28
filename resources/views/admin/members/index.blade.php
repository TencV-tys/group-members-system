@extends('layouts.admin')

@section('title', 'Manage Members')

@section('content')
<div class="container mx-auto">
    <!-- Header with title and add button -->
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <h1 class="text-3xl font-bold text-gray-800">Manage Members</h1>
        <button onclick="openCreateModal()" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition flex items-center gap-2 w-full sm:w-auto justify-center">
            <span class="text-xl">+</span> Add New Member
        </button>
    </div>

    <!-- Responsive Members Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Photo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Age</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($members as $member)
                    <tr class="hover:bg-gray-50" id="member-{{ $member->id }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($member->profile_photo)
                                <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover">
                            @else
                                <img src="{{ asset('images/default-image.png') }}" alt="Default profile" class="w-10 h-10 rounded-full object-cover">
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $member->first_name }} {{ $member->last_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                {{ $member->role }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $member->age }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-2">
                                <button onclick="openViewModal({{ $member->id }})" class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded text-sm">View</button>
                                <button onclick="openEditModal({{ $member->id }})" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded text-sm">Edit</button>
                                <button onclick="deleteMember({{ $member->id }})" class="text-red-600 hover:text-red-900 bg-red-50 px-3 py-1 rounded text-sm">Delete</button>
                            </div>
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

<!-- Create Modal -->
<div id="createModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Add New Member</h3>
            <button onclick="closeModal('createModal')" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        
        <form id="createForm" enctype="multipart/form-data">
            @csrf
            <div class="space-y-4 max-h-[60vh] overflow-y-auto p-1">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                    <input type="text" id="create_first_name" name="first_name" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                    <input type="text" id="create_last_name" name="last_name" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <input type="text" id="create_role" name="role" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                    <input type="number" id="create_age" name="age" required min="1" max="150"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                    <textarea id="create_bio" name="bio" rows="3" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="create_email" name="email" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Used for login and communication</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" id="create_username" name="username" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Used for login (must be unique)</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" id="create_password" name="password" required minlength="8"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                    <input type="file" id="create_profile_photo" name="profile_photo" accept="image/*"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-3 border-t">
                <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Save</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Edit Member</h3>
            <button onclick="closeModal('editModal')" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        
        <form id="editForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" id="edit_id" name="id">
            
            <div class="space-y-4 max-h-[60vh] overflow-y-auto p-1">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                    <input type="text" id="edit_first_name" name="first_name" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                    <input type="text" id="edit_last_name" name="last_name" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <input type="text" id="edit_role" name="role" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                    <input type="number" id="edit_age" name="age" required min="1" max="150"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                    <textarea id="edit_bio" name="bio" rows="3" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" id="edit_email" name="email" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Used for login and communication</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                    <input type="text" id="edit_username" name="username" required 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Used for login (must be unique)</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">New Password (Optional)</label>
                    <input type="password" id="edit_password" name="password" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <p class="text-xs text-gray-500 mt-1">Leave blank to keep current password</p>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                    <input type="file" id="edit_profile_photo" name="profile_photo" accept="image/*"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    <div id="currentPhoto" class="mt-2 hidden">
                        <p class="text-sm text-gray-600">Current photo:</p>
                        <img id="currentPhotoImg" src="" alt="Current" class="w-16 h-16 rounded-full mt-1">
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 mt-6 pt-3 border-t">
                <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Member Details</h3>
            <button onclick="closeModal('viewModal')" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        
        <div id="viewContent" class="space-y-4 max-h-[70vh] overflow-y-auto p-1">
            <!-- Content will be populated by JavaScript -->
        </div>

        <div class="flex justify-end mt-6 pt-3 border-t">
            <button type="button" onclick="closeModal('viewModal')" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Close</button>
        </div>
    </div>
</div>

<script>
    // Open Create Modal
    function openCreateModal() {
        document.getElementById('createModal').classList.remove('hidden');
        document.getElementById('createForm').reset();
    }

    // Open Edit Modal
    function openEditModal(id) {
        fetch(`/admin/members/${id}/edit`)
            .then(res => res.json())
            .then(member => {
                document.getElementById('edit_id').value = member.id;
                document.getElementById('edit_first_name').value = member.first_name;
                document.getElementById('edit_last_name').value = member.last_name;
                document.getElementById('edit_role').value = member.role;
                document.getElementById('edit_age').value = member.age;
                document.getElementById('edit_bio').value = member.bio || '';
                
                // Populate email and username
                if (member.user) {
                    document.getElementById('edit_email').value = member.user.email || '';
                    document.getElementById('edit_username').value = member.user.username || '';
                } else {
                    document.getElementById('edit_email').value = '';
                    document.getElementById('edit_username').value = '';
                }
                
                // Clear password field for security
                document.getElementById('edit_password').value = '';
                
                // Handle profile photo
                if (member.profile_photo) {
                    document.getElementById('currentPhotoImg').src = '/storage/' + member.profile_photo;
                    document.getElementById('currentPhoto').classList.remove('hidden');
                } else {
                    document.getElementById('currentPhoto').classList.add('hidden');
                }
                
                document.getElementById('editModal').classList.remove('hidden');
            })
            .catch(error => console.error('Error:', error));
    }

    // Open View Modal
    function openViewModal(id) {
        fetch(`/admin/members/${id}/edit`)
            .then(res => res.json())
            .then(member => {
                const photoHtml = member.profile_photo 
                    ? `<img src="/storage/${member.profile_photo}" alt="Profile" class="w-24 h-24 rounded-full object-cover mx-auto">`
                    : `<img src="/images/default-image.png" alt="Default profile" class="w-24 h-24 rounded-full object-cover mx-auto">`;
                
                const content = `
                    <div class="text-center">
                        ${photoHtml}
                        <h2 class="text-2xl font-bold mt-4">${member.first_name} ${member.last_name}</h2>
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm mt-2">${member.role}</span>
                    </div>
                    <div class="border-t pt-4">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <p class="text-sm text-gray-500">Age</p>
                                <p class="text-xl font-bold text-gray-800">${member.age}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded-lg text-center">
                                <p class="text-sm text-gray-500">Member Since</p>
                                <p class="text-sm font-semibold text-gray-800">${new Date(member.created_at).toLocaleDateString()}</p>
                            </div>
                        </div>
                        ${member.user ? `
                        <div class="bg-gray-50 p-3 rounded-lg mb-4">
                            <p class="text-gray-600"><span class="font-semibold">Email:</span> ${member.user.email}</p>
                            <p class="text-gray-600 mt-2"><span class="font-semibold">Username:</span> ${member.user.username}</p>
                        </div>
                        ` : ''}
                        <div>
                            <p class="text-gray-600 font-semibold mb-2">Bio:</p>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">${member.bio || 'No bio provided'}</p>
                            </div>
                        </div>
                    </div>
                `;
                
                document.getElementById('viewContent').innerHTML = content;
                document.getElementById('viewModal').classList.remove('hidden');
            })
            .catch(error => console.error('Error:', error));
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Handle Create Form Submit
    document.getElementById('createForm').addEventListener('submit', function(e) {
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
                closeModal('createModal');
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Handle Edit Form Submit
    document.getElementById('editForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        let formData = new FormData(this);
        let id = document.getElementById('edit_id').value;
        
        // Add _method PUT for Laravel
        formData.append('_method', 'PUT');
        
        fetch(`/admin/members/${id}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                closeModal('editModal');
                location.reload();
            } else if (data.errors) {
                console.log(data.errors);
                alert('Please fix the errors: ' + JSON.stringify(data.errors));
            }
        })
        .catch(error => console.error('Error:', error));
    });

    // Delete Member
    function deleteMember(id) {
        if (confirm('Are you sure you want to delete this member?')) {
            fetch(`/admin/members/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Content-Type': 'application/json'
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

    // Close modals when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('fixed')) {
            const modals = ['createModal', 'editModal', 'viewModal'];
            modals.forEach(modalId => {
                const modal = document.getElementById(modalId);
                if (event.target === modal) {
                    closeModal(modalId);
                }
            });
        }
    }
</script>
@endsection