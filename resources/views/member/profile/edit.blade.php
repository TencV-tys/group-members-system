<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Group Mark Hudson</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Custom Navigation for Members -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/members" class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">Members</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('member.dashboard') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition">
                        Dashboard
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-800">Edit My Profile</h1>
                <a href="{{ route('member.dashboard') }}" class="text-blue-600 hover:text-blue-800">← Back to Dashboard</a>
            </div>
            
            <form action="{{ route('member.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">First Name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $member->first_name) }}" required 
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2">Last Name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $member->last_name) }}" required 
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                    <input type="text" value="{{ $member->role }}" disabled 
                        class="w-full px-3 py-2 border rounded-lg bg-gray-100 text-gray-500">
                    <p class="text-xs text-gray-500 mt-1">Role cannot be changed</p>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Age</label>
                    <input type="number" name="age" value="{{ old('age', $member->age) }}" required min="1" max="150"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                    <textarea name="bio" rows="4" 
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">{{ old('bio', $member->bio) }}</textarea>
                </div>
                
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Profile Photo</label>
                    <input type="file" name="profile_photo" accept="image/*"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-blue-500">
                    @if($member->profile_photo)
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">Current photo:</p>
                            <img src="{{ asset('storage/' . $member->profile_photo) }}" class="w-20 h-20 rounded-full mt-1">
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-end space-x-3 mt-6">
                    <a href="{{ route('member.dashboard') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400">Cancel</a>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">Update Profile</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>