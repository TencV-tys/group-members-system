@extends('layouts.admin')

@section('title', 'All Members - Admin View')

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">All Members</h1>
        <p class="text-gray-600 mt-1">View all group members - Click any row to see details</p>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($members->isEmpty())
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No members found.</p>
            </div>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($members as $member)
                        <tr class="hover:bg-blue-50 cursor-pointer transition" 
                            id="member-{{ $member->id }}"
                            onclick="openViewModal({{ $member->id }})">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($member->profile_photo)
                                    <img src="{{ asset('storage/' . $member->profile_photo) }}" 
                                         alt="Profile" 
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <img src="{{ asset('images/default-image.png') }}" 
                                         alt="Default profile"
                                         class="w-10 h-10 rounded-full object-cover">
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
                            <td class="px-6 py-4 whitespace-nowrap" onclick="event.stopPropagation();">
                                <button onclick="openViewModal({{ $member->id }})" class="text-green-600 hover:text-green-900 bg-green-50 px-3 py-1 rounded text-sm">
                                    View
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

<!-- View Modal -->
<div id="viewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-md shadow-lg rounded-lg bg-white">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-gray-800">Member Details</h3>
            <button onclick="closeModal()" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
        </div>
        
        <div id="viewContent" class="space-y-4 max-h-[70vh] overflow-y-auto p-1">
            <!-- Content will be populated by JavaScript -->
        </div>

        <div class="flex justify-end mt-6 pt-3 border-t">
            <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Close</button>
        </div>
    </div>
</div>

<script>
    // Open View Modal
    function openViewModal(id) {
        fetch(`/admin/members/${id}/edit`)
            .then(res => res.json())
            .then(member => {
                const photoHtml = member.profile_photo 
                    ? `<img src="/storage/${member.profile_photo}" alt="Profile" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-blue-100">`
                    : `<img src="/images/default-image.png" alt="Default profile" class="w-24 h-24 rounded-full object-cover mx-auto border-4 border-blue-100">`;
                
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
            });
    }

    // Close Modal
    function closeModal() {
        document.getElementById('viewModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('viewModal');
        if (event.target === modal) {
            closeModal();
        }
    }
</script>
@endsection