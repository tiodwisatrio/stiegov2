<nav 
    x-data="{ open: false, scrolled: false }"
    x-init="
        window.addEventListener('scroll', () => {
            scrolled = window.scrollY > 20;
        });
    "
    :class="scrolled 
        ? 'fixed top-0 left-0 w-full bg-white transition-all duration-500 ease-in-out z-50' 
        : 'fixed top-0 left-0 w-full bg-white transition-all duration-500 ease-in-out z-50'"
>
    <div class="container mx-auto px-6 sm:px-10">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center gap-2">
                <a href="{{ route('frontend.home') }}">
                    <img src="{{ asset('images/logo_stiego.png') }}" alt="StiegoApp Logo" class="h-8 w-auto">
                </a>
                <span class="font-bold text-gray-800 text-lg">StiegoApp</span>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex space-x-6">
                @php
                    $navLinks = [
                        'Home' => 'frontend.home',
                        'About' => 'frontend.about',
                        'Catalog' => 'frontend.catalog.index',
                        'Products' => 'frontend.products.index',
                        'Contact' => 'frontend.contact'
                    ];
                @endphp

                @foreach($navLinks as $label => $route)
                    <a href="{{ route($route) }}" 
                       class="text-gray-700 hover:text-red-600 px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs($route . '*') ? 'text-red-600 font-semibold' : '' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Right Actions (Desktop) -->
            <div class="hidden sm:flex items-center space-x-4">
                <!-- Cart Icon -->
                <a href="{{ route('frontend.cart.index') }}" 
                   class="relative text-gray-700 hover:text-red-600 p-2 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 
                                 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @php $cartCount = count(session()->get('cart', [])); @endphp
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Login Button -->
                <a href="{{ route('login') }}" 
                   class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 text-sm transition">
                    Login
                </a>
            </div>

            <!-- Mobile Toggle -->
            <div class="sm:hidden flex items-center space-x-3">
                <!-- Cart -->
                <a href="{{ route('frontend.cart.index') }}" 
                   class="relative text-gray-700 hover:text-red-600 p-2 transition">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 
                                 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    @if($cartCount > 0)
                        <span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <!-- Toggle Button -->
                <button @click="open = !open" 
                        class="p-2 rounded-md text-gray-700 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 transition">
                    <svg x-show="!open" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" x-cloak class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu with Motion Animation -->
    <div 
        x-show="open"
        x-transition:enter="transition ease-out duration-400 transform"
        x-transition:enter-start="opacity-0 -translate-y-3 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 -translate-y-3 scale-95"
        class="sm:hidden bg-white rounded-b-2xl origin-top"
    >
        <div class="px-4 py-3 space-y-1">
            @foreach($navLinks as $label => $route)
                <a href="{{ route($route) }}" 
                   class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-100 transition 
                          {{ request()->routeIs($route . '*') ? 'text-red-600 bg-gray-100' : '' }}">
                    {{ $label }}
                </a>
            @endforeach

            <div class="pt-4">
                <a href="{{ route('login') }}" 
                   class="block w-full text-center bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Spacer -->
<div class="h-16"></div>
