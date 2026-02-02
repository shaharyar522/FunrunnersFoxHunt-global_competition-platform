<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Funrunners</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    <!-- Sidebar -->
    <div class="w-64 bg-slate-900 text-white flex flex-col">
        <div class="p-6">
            <h2 class="text-xl font-bold tracking-tight">Funrunners</h2>
        </div>

        <nav class="flex-1 px-4 py-2 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 font-medium' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
                Dashboard
            </a>

             <a href="{{ route('admin.contestants.list') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.contestants.*') ? 'bg-blue-600 font-medium text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
                Contestants
            </a>

            <a href="{{ route('admin.members.list') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.members.*') ? 'bg-blue-600 font-medium text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
                Member
            </a>

            <a href="{{ route('admin.regions.index') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.regions.*') ? 'bg-blue-600 font-medium text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
                Regions
            </a>

             <a href="{{ route('admin.voting.list') }}" class="block px-4 py-2.5 rounded-lg {{ request()->routeIs('admin.voting.*') ? 'bg-blue-600 font-medium text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800' }} transition-all">
                Voting
            </a>

        </nav>

        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-slate-400 hover:text-white transition-all">
                    logout
                </button>
            </form>
        </div>




    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center shadow-sm">
            <h1 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Welcome')</h1>
            <div class="flex items-center space-x-4">
                <span class="text-sm text-gray-500">{{ Auth::user()->name }}</span>
                <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                    AD
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-8">
            @yield('content')
        </main>
    </div>

</body>
</html>
