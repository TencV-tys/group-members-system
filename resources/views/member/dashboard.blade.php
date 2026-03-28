<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard - Group Mark Hudson</title>
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
                    <a href="{{ route('member.profile.edit') }}" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                        Edit Profile
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
    </div>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">My Dashboard</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Profile Card -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        @if($member->profile_photo)
                            <img src="{{ asset('storage/' . $member->profile_photo) }}" alt="Profile" class="w-20 h-20 rounded-full object-cover mr-4">
                        @else
                            <div class="w-20 h-20 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center mr-4">
                                <span class="text-white text-2xl font-bold">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800">{{ $member->first_name }} {{ $member->last_name }}</h2>
                            <p class="text-gray-600">{{ $member->role }}</p>
                        </div>
                    </div>
                    
                    <div class="space-y-3 mt-4">
                        <p class="text-gray-700"><span class="font-semibold">Age:</span> {{ $member->age }}</p>
                        <p class="text-gray-700"><span class="font-semibold">Bio:</span></p>
                        <p class="text-gray-600 bg-white p-3 rounded-lg">{{ $member->bio ?? 'No bio provided' }}</p>
                    </div>
                </div>
                
                <!-- Quick Info Card -->
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Quick Info</h3>
                    <div class="space-y-3">
                        <div class="bg-white p-3 rounded-lg">
                            <p class="text-sm text-gray-500">Member Since</p>
                            <p class="font-semibold text-gray-800">{{ $member->created_at->format('F d, Y') }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg">
                            <p class="text-sm text-gray-500">Account Status</p>
                            <p class="font-semibold text-green-600">Active</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg">
                            <p class="text-sm text-gray-500">Email</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="bg-white p-3 rounded-lg">
                            <p class="text-sm text-gray-500">Username</p>
                            <p class="font-semibold text-gray-800">{{ Auth::user()->username }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>