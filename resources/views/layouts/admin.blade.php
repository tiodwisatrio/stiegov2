<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/stiego_icon.png') }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Alpine.js cloak style -->
    <style>
        [x-cloak] { display: none !important; }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen"
             x-cloak
             @click="sidebarOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden">
        </div>

        <!-- Mobile Sidebar (Drawer) -->
        <aside x-show="sidebarOpen"
               x-cloak
               x-transition:enter="transition ease-in-out duration-300 transform"
               x-transition:enter-start="-translate-x-full"
               x-transition:enter-end="translate-x-0"
               x-transition:leave="transition ease-in-out duration-300 transform"
               x-transition:leave-start="translate-x-0"
               x-transition:leave-end="-translate-x-full"
               class="fixed inset-y-0 left-0 bg-white shadow-lg w-64 z-50 lg:hidden">
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 bg-white border-b border-gray-200 px-4">
                <span class="text-xl font-semibold text-gray-800">Stiego Admin</span>
                <!-- Close button -->
                <button @click="sidebarOpen = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 overflow-y-auto h-[calc(100vh-4rem)] pb-6">
                <div class="px-4 space-y-2">
                    @include('layouts.partials.admin-nav-items')
                </div>
            </nav>
        </aside>

        <!-- Desktop Sidebar (Static) -->
        <aside class="hidden lg:block fixed inset-y-0 left-0 bg-white shadow-sm w-64 z-30">
            <!-- Logo -->
            <div class="flex items-center h-16 bg-white border-b border-gray-200 px-4">
                <span class="text-xl font-semibold text-gray-800">Stiego Admin</span>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 overflow-y-auto h-[calc(100vh-4rem)] pb-6">
                <div class="px-4 space-y-2">
                    @include('layouts.partials.admin-nav-items')
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="lg:ml-64">
            <!-- Top Navigation -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
                    <!-- Left side: Hamburger Menu + Title -->
                    <div class="flex items-center space-x-3">
                        <!-- Hamburger Menu (Mobile only) -->
                        <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>

                        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">@yield('header', 'Dashboard')</h2>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-sm focus:outline-none hover:text-indigo-600 transition-colors">
                            <span class="hidden sm:inline text-gray-700">{{ Auth::user()->name }}</span>
                            <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <svg class="hidden sm:inline w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>

                        <div x-show="open"
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200"
                             style="display: none;">
                            <!-- User info header (Mobile) -->
                            <div class="px-4 py-2 border-b border-gray-200 sm:hidden">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('admin.profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Profile Settings
                                </div>
                            </a>
                            <hr class="my-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
    @stack('scripts')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
