<!-- Dashboard -->
<a href="{{ route('admin.dashboard') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
    </svg>
    Dashboard
</a>

<!-- Categories -->
<a href="{{ route('admin.categories.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.categories.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
    </svg>
    Categories
</a>

<!-- Products -->
<a href="{{ route('admin.products.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.products.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-4m4 0h-4m4 0H8m8 0H8"></path>
    </svg>
    Products
</a>

<!-- Orders -->
<a href="{{ route('admin.orders.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
    </svg>
    Orders
</a>

<!-- Testimonials -->
<a href="{{ route('admin.testimonials.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.testimonials.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
    </svg>
    Testimonials
</a>

<!-- Banners -->
<a href="{{ route('admin.banners.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.banners.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
    </svg>
    Banners
</a>

<!-- Highlight Types -->
<a href="{{ route('admin.highlight-types.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.highlight-types.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
    </svg>
    Highlight Types
</a>

<!-- Product Highlights -->
<a href="{{ route('admin.highlights.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.highlights.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
    </svg>
    Product Highlights
</a>

<!-- Users -->
<a href="{{ route('admin.users.index') }}"
   @click="sidebarOpen = false"
   class="flex items-center px-4 py-2.5 text-sm font-medium {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }} rounded-lg group transition-colors">
    <svg class="w-5 h-5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
    </svg>
    {{ Auth::user()->isDeveloper() ? 'All Users' : 'Customers' }}
</a>
