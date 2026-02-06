<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Contestant Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar (Simple like Admin) -->
    <div class="w-64 bg-slate-800 text-white flex flex-col">
        <div class="p-6">
            <h2 class="text-xl font-bold">Funrunners</h2>
            <p class="text-xs text-slate-400 uppercase tracking-widest mt-1">Contestant Panel</p>
        </div>

        <nav class="flex-1 px-4 py-2 space-y-1">
            <a href="{{ route('contestant.dashboard') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('contestant.dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }} transition-all">
                Dashboard
            </a>
            <a href="{{ route('contestant.profile') }}" class="block px-4 py-3 rounded-lg {{ request()->routeIs('contestant.profile') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }} transition-all">
                My Profile
            </a>
        </nav>

        <div class="p-4 border-t border-slate-700">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 text-sm text-slate-400 hover:text-white transition-all">
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center shadow-sm">
            <h1 class="text-lg font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
            <div class="flex items-center space-x-3">
                <span class="text-sm font-medium text-gray-600">{{ Auth::user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs uppercase">
                    {{ substr(Auth::user()->name, 0, 2) }}
                </div>
            </div>
        </header>

        <!-- Context Area -->
        <main class="p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>
