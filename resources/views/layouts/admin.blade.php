<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Admin Navigation -->
    <nav class="bg-gray-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <span class="text-xl font-bold text-white">Admin Panel</span>
                    <div class="hidden md:flex space-x-4">
                        <a href="/admin/dashboard" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        <a href="/admin/members/table" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">All Members</a>
                        <a href="/admin/members" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Manage Members</a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-300 text-sm">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="/logout">
                        @csrf
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-red-700 transition">
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
        @yield('content')
    </main>
</body>
</html>