<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Group Mark Hundson')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <a href="/" class="text-xl font-bold text-gray-800">Group Mark Hundson</a>
                    <div class="hidden md:flex space-x-4">
                        <a href="/" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">Home</a>
                        <!-- Public Members Link - Only visible to non-logged in users -->
                        @guest
                            <a href="/members" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">Members</a>
                        @endguest
                        
                        <!-- Admin Navigation - Only visible to logged in admin -->
                        @auth
                            @if(Auth::user()->isAdmin())
                                <a href="/admin/dashboard" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">Admin Dashboard</a>
                                <a href="/admin/members/table" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">All Members</a>
                                <a href="/admin/members" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">Manage Members</a>
                            @endif
                        @endauth
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <span class="text-gray-600">Welcome, {{ Auth::user()->name }}</span>
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Logout</button>
                        </form>
                    @else
                        <!-- No login button visible -->
                    @endauth
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
        @yield('content')
    </main>
</body>
</html>