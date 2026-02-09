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
<body class="bg-gray-100 min-h-screen">

    <!-- Main Content Area -->
    <div class="flex flex-col min-h-screen">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center shadow-sm sticky top-0 z-50">
            <div class="flex items-center space-x-4">
                <h2 class="text-xl font-bold text-slate-800">Funrunners</h2>
                <span class="text-xs text-slate-400 uppercase tracking-widest hidden sm:inline">Contestant Panel</span>
            </div>
            
            <div class="flex items-center gap-6">
                <nav class="hidden md:flex items-center space-x-4 mr-4">
                    <a href="{{ route('contestant.dashboard') }}" class="{{ request()->routeIs('contestant.dashboard') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }} text-sm transition-all">Dashboard</a>
                    <a href="{{ route('contestant.profile') }}" class="{{ request()->routeIs('contestant.profile') ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }} text-sm transition-all">My Profile</a>
                </nav>

                <div class="flex items-center space-x-3 border-l pl-6 border-gray-200">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</p>
                        <p class="text-[10px] font-bold text-gray-400 uppercase mt-1">Contestant</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg border border-red-100 font-bold hover:bg-red-600 hover:text-white transition-all">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Context Area (Centered) -->
        <main class="p-8 max-w-6xl mx-auto w-full">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            @yield('content')
        </main>
    </div>

</body>
</html>
