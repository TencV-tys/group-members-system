<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Group Mark Hundson')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation - Public Only -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <!-- Logo on the left -->
                <div class="flex items-center">
                    <a href="/" class="text-xl font-bold text-gray-800">Group Mark Hundson</a>
                </div>
                
                <!-- Navigation links on the right -->
                <div class="flex items-center space-x-4">
                    <a href="/" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">Home</a>
                    <a href="/members" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md">Members</a>
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