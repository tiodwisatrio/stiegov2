<nav
    x-data="{ open: false, scrolled: false, catalogDropdown: false, productsDropdown: false }"
    x-init="
        window.addEventListener('scroll', () => {
            scrolled = window.scrollY > 20;
        });
    "
    :class="scrolled ? 'bg-white/100 backdrop-blur-md fixed top-0 left-0 w-full z-50 transition-all duration-300' : 'bg-white fixed top-0 left-0 w-full z-50 transition-all duration-300'"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 bg-white">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ route('frontend.home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('images/logo_stiego.png') }}" alt="StiegoApp Logo" class="h-8 w-auto">
                    <!-- <span class="text-lg font-bold text-gray-800">Stiego</span> -->
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden sm:flex space-x-6">
                <a href="{{ route('frontend.home') }}"
                   class="relative text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors duration-200 group
                          {{ request()->routeIs('frontend.home') ? 'text-red-600 font-semibold' : '' }}">
                    Home
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left
                                 {{ request()->routeIs('frontend.home') ? 'scale-x-100' : '' }}"></span>
                </a>

                <a href="{{ route('frontend.about') }}"
                   class="relative text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors duration-200 group
                          {{ request()->routeIs('frontend.about*') ? 'text-red-600 font-semibold' : '' }}">
                    About
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left
                                 {{ request()->routeIs('frontend.about*') ? 'scale-x-100' : '' }}"></span>
                </a>

                <!-- Catalog with Dropdown -->
                <div class="relative"
                     @mouseenter="catalogDropdown = true"
                     @mouseleave="catalogDropdown = false">
                    <a href="{{ route('frontend.catalog.index') }}"
                       class="relative text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center gap-1 group
                              {{ request()->routeIs('frontend.catalog*') ? 'text-red-600 font-semibold' : '' }}">
                        Catalog
                        <svg class="w-4 h-4 transition-transform duration-200"
                             :class="catalogDropdown ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left
                                     {{ request()->routeIs('frontend.catalog*') ? 'scale-x-100' : '' }}"></span>
                    </a>
                </div>

                <!-- Products with Dropdown -->
                <div class="relative"
                     @mouseenter="productsDropdown = true"
                     @mouseleave="productsDropdown = false">
                    <a href="{{ route('frontend.products.index') }}"
                       class="relative text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors duration-200 inline-flex items-center gap-1 group
                              {{ request()->routeIs('frontend.products*') ? 'text-red-600 font-semibold' : '' }}">
                        Products
                        <svg class="w-4 h-4 transition-transform duration-200"
                             :class="productsDropdown ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left
                                     {{ request()->routeIs('frontend.products*') ? 'scale-x-100' : '' }}"></span>
                    </a>
                </div>

                <a href="{{ route('frontend.contact') }}"
                   class="relative text-gray-700 hover:text-red-600 px-3 py-2 text-sm font-medium transition-colors duration-200 group
                          {{ request()->routeIs('frontend.contact*') ? 'text-red-600 font-semibold' : '' }}">
                    Contact
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-red-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-out origin-left
                                 {{ request()->routeIs('frontend.contact*') ? 'scale-x-100' : '' }}"></span>
                </a>
            </div>

            <!-- Mega Dropdown Menu - Full Width -->
            <div x-show="catalogDropdown"
                 @mouseenter="catalogDropdown = true"
                 @mouseleave="catalogDropdown = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-3"
                 class="absolute left-0 right-0 top-full bg-white z-50 max-h-[calc(100vh-5rem)] overflow-y-auto"
                 style="display: none;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- All Catalog - Featured -->
                        <div class="md:col-span-1">
                            <a href="{{ route('frontend.catalog.index') }}"
                               class="block p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-lg hover:shadow-md transition-all group">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                                    </svg>
                                    <span class="text-xl font-bold text-red-600 group-hover:text-red-700">All Catalog</span>
                                </div>
                                <p class="text-sm text-gray-600">Cari produk kesukaanmu</p>
                            </a>
                        </div>

                        <!-- Highlight Types Grid -->
                        <div class="md:col-span-3">
                            @if(isset($highlightTypes) && $highlightTypes->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($highlightTypes as $type)
                                        <a href="{{ route('frontend.catalog.slug', $type->slug) }}"
                                           class="group p-4 rounded-lg hover:bg-red-50 transition-all border border-transparent hover:border-red-200
                                                  {{ request()->is('catalog/' . $type->slug) ? 'bg-red-50 border-red-200' : '' }}">
                                            <div class="flex items-start gap-3">
                                                <svg class="w-5 h-5 text-red-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                                <div>
                                                    <div class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
                                                        {{ $type->name }}
                                                    </div>
                                                    @if($type->description)
                                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($type->description, 60) }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Mega Dropdown Menu - Full Width -->
            <div x-show="productsDropdown"
                 @mouseenter="productsDropdown = true"
                 @mouseleave="productsDropdown = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 translate-y-3"
                 class="absolute left-0 right-0 top-full bg-white z-50 max-h-[calc(100vh-5rem)] overflow-y-auto"
                 style="display: none;">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- All Products - Featured -->
                        <div class="md:col-span-1">
                            <a href="{{ route('frontend.products.index') }}"
                               class="block p-6 bg-gradient-to-br from-red-50 to-red-100 rounded-lg hover:shadow-md transition-all group">
                                <div class="flex items-center gap-3 mb-2">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                                    </svg>
                                    <span class="text-xl font-bold text-red-600 group-hover:text-red-700">All Products</span>
                                </div>
                                <p class="text-sm text-gray-600">Cari produk kesukaanmu</p>
                            </a>
                        </div>

                        <!-- Categories Grid -->
                        <div class="md:col-span-3">
                            @if(isset($categories) && $categories->count() > 0)
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($categories as $category)
                                        <div class="space-y-2">
                                            <!-- Parent Category -->
                                            <a href="{{ route('frontend.products.index', ['category' => $category->category_slug]) }}"
                                               class="group p-4 rounded-lg hover:bg-red-50 transition-all border border-transparent hover:border-red-200 block">
                                                <div class="flex items-start gap-3">
                                                    <svg class="w-5 h-5 text-red-600 mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                    </svg>
                                                    <div class="flex-1">
                                                        <div class="font-semibold text-gray-900 group-hover:text-red-600 transition-colors">
                                                            {{ $category->category_name }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                            <!-- Sub Categories -->
                                            @if($category->children && $category->children->count() > 0)
                                                <div class="ml-8 space-y-1">
                                                    @foreach($category->children as $child)
                                                        <a href="{{ route('frontend.products.index', ['category' => $child->category_slug]) }}"
                                                           class="block px-3 py-1.5 text-sm text-gray-600 hover:text-red-600 hover:bg-red-50 rounded transition">
                                                            {{ $child->category_name }}
                                                        </a>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart & Auth Buttons -->
            <div class="hidden sm:flex items-center space-x-4">
                <!-- Cart Icon -->
                <a href="{{ route('frontend.cart.index') }}" 
                   class="relative text-gray-700 hover:text-red-600 transition p-2"
                   aria-label="Buka keranjang belanja Stiego">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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

                @auth
                    <!-- If User is Logged In -->
                    @if(auth()->user()->hasAdminAccess())
                        <!-- Admin/Developer: Show Dashboard Button -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="px-6 py-2 bg-indigo-600 text-white rounded-full hover:bg-indigo-700 text-sm transition">
                            Dashboard
                        </a>
                    @else
                        <!-- Customer: Show Username Dropdown -->
                        <div x-data="{ dropdownOpen: false }" class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" 
                                    class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:text-red-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="dropdownOpen" 
                                 @click.away="dropdownOpen = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- If User is NOT Logged In -->
                    <a href="{{ route('login') }}" 
                       class="px-6 py-2 text-gray-700 hover:text-red-600 text-sm font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="px-6 py-2 bg-red-600 text-white rounded-full hover:bg-red-700 text-sm transition">
                        Register
                    </a>
                @endauth
            </div>

            <!-- Mobile Cart & Menu -->
            <div class="sm:hidden flex items-center space-x-3">
                <!-- Cart -->
                <a href="{{ route('frontend.cart.index') }}" class="relative text-gray-700 hover:text-red-600 p-2 transition">
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

    <!-- Mobile Menu with Animation -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="sm:hidden bg-white border-t border-gray-100 max-h-[calc(100vh-4rem)] overflow-y-auto"
        x-data="{ mobileDropdown: false, mobileProductsDropdown: false }"
    >
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('frontend.home') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-100
                      transition {{ request()->routeIs('frontend.home') ? 'text-red-600 bg-gray-100' : '' }}">
                Home
            </a>

            <a href="{{ route('frontend.about') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-100
                      transition {{ request()->routeIs('frontend.about*') ? 'text-red-600 bg-gray-100' : '' }}">
                About
            </a>

            <!-- Catalog Mobile Dropdown -->
            <div>
                <button @click="mobileDropdown = !mobileDropdown"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-100 transition
                               {{ request()->routeIs('frontend.catalog*') ? 'text-red-600 bg-gray-100' : '' }}">
                    <span>Catalog</span>
                    <svg class="w-5 h-5 transition-transform duration-200"
                         :class="mobileDropdown ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Mobile Dropdown Content -->
                <div x-show="mobileDropdown"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="ml-4 mt-1 space-y-1"
                     style="display: none;">

                    <a href="{{ route('frontend.catalog.index') }}"
                       class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:text-red-600 hover:bg-gray-100 transition">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                            <span class="font-semibold">All Catalog</span>
                        </div>
                    </a>

                    @if(isset($highlightTypes) && $highlightTypes->count() > 0)
                        @foreach($highlightTypes as $type)
                            <a href="{{ route('frontend.catalog.slug', $type->slug) }}"
                               class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:text-red-600 hover:bg-gray-100 transition
                                      {{ request()->is('catalog/' . $type->slug) ? 'text-red-600 bg-gray-100' : '' }}">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span>{{ $type->name }}</span>
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Products Mobile Dropdown -->
            <div>
                <button @click="mobileProductsDropdown = !mobileProductsDropdown"
                        class="w-full flex items-center justify-between px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-100 transition
                               {{ request()->routeIs('frontend.products*') ? 'text-red-600 bg-gray-100' : '' }}">
                    <span>Products</span>
                    <svg class="w-5 h-5 transition-transform duration-200"
                         :class="mobileProductsDropdown ? 'rotate-180' : ''"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <!-- Mobile Products Dropdown Content -->
                <div x-show="mobileProductsDropdown"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     class="ml-4 mt-1 space-y-1"
                     style="display: none;">

                    <a href="{{ route('frontend.products.index') }}"
                       class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:text-red-600 hover:bg-gray-100 transition">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            <span class="font-semibold">All Products</span>
                        </div>
                    </a>

                    @if(isset($categories) && $categories->count() > 0)
                        @foreach($categories as $category)
                            <!-- Parent Category -->
                            <a href="{{ route('frontend.products.index', ['category' => $category->category_slug]) }}"
                               class="block px-3 py-2 rounded-md text-sm text-gray-700 hover:text-red-600 hover:bg-gray-100 transition font-medium">
                                <div class="flex items-center gap-2">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                    <span>{{ $category->category_name }}</span>
                                </div>
                            </a>

                            <!-- Sub Categories -->
                            @if($category->children && $category->children->count() > 0)
                                @foreach($category->children as $child)
                                    <a href="{{ route('frontend.products.index', ['category' => $child->category_slug]) }}"
                                       class="block px-3 py-2 ml-4 rounded-md text-xs text-gray-600 hover:text-red-600 hover:bg-gray-100 transition">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 8 8">
                                                <circle cx="4" cy="4" r="3"/>
                                            </svg>
                                            <span>{{ $child->category_name }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>

            <a href="{{ route('frontend.contact') }}"
               class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-red-600 hover:bg-gray-100
                      transition {{ request()->routeIs('frontend.contact*') ? 'text-red-600 bg-gray-100' : '' }}">
                Contact
            </a>

            <div class="pt-4 space-y-2">
                @auth
                    <!-- If User is Logged In -->
                    @if(auth()->user()->hasAdminAccess())
                        <!-- Admin/Developer: Show Dashboard Button -->
                        <a href="{{ route('admin.dashboard') }}" 
                           class="block w-full text-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">
                            Dashboard
                        </a>
                    @else
                        <!-- Customer: Show Username & Logout -->
                        <div class="px-3 py-2 text-gray-900 font-medium flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>{{ auth()->user()->name }}</span>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" 
                                    class="block w-full text-center bg-red-600 text-white py-2 rounded-md hover:bg-red-700 transition">
                                Logout
                            </button>
                        </form>
                    @endif
                @else
                    <!-- If User is NOT Logged In -->
                    <a href="{{ route('login') }}" 
                       class="block w-full text-center text-white bg-red-700 hover:bg-red-800 rounded-full py-2.5 transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}" 
                       class="block w-full text-center transition">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- Spacer agar konten tidak ketutup navbar -->
<div class="h-16"></div>
