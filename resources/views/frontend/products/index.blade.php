@extends('layouts.frontend')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto py-4 sm:py-6 lg:py-8">
<div 
    x-data="{ open: false }" 
    class="rounded-lg shadow-sm p-4 sm:p-6 mb-6"
>
    <!-- Mobile Toggle Button -->
    <div class="flex justify-between items-center sm:hidden">
        <h2 class="text-base font-semibold text-gray-800">Filter & Sort</h2>
        <button 
            @click="open = !open" 
            class="px-4 py-2 text-sm font-medium bg-red-600 text-white rounded-full hover:bg-red-700 transition">
            <span x-text="open ? 'Close' : 'Open'"></span>
        </button>
    </div>

    <!-- Filter Form -->
    <div 
        x-show="open || window.innerWidth >= 640" 
        x-transition 
        x-cloak
        class="mt-4 sm:mt-0"
    >
        <form method="GET" action="{{ route('frontend.products.index') }}" class="space-y-3 sm:space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Search Product</label>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Search by name..."
                           class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <!-- Category Filter -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Category</label>
                    <select name="category"
                            class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->category_slug }}"
                                    {{ request('category') == $parent->category_slug ? 'selected' : '' }}
                                    class="font-semibold">
                                {{ $parent->category_name }}
                            </option>
                            @foreach($parent->children as $child)
                                <option value="{{ $child->category_slug }}"
                                        {{ request('category') == $child->category_slug ? 'selected' : '' }}
                                        class="pl-4">
                                    &nbsp;&nbsp;&nbsp;• {{ $child->category_name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Min Price</label>
                    <input type="number" 
                           name="price_min" 
                           value="{{ request('price_min') }}"
                           placeholder="Rp 0"
                           class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 sm:mb-2">Max Price</label>
                    <input type="number" 
                           name="price_max" 
                           value="{{ request('price_max') }}"
                           placeholder="Rp 999,999"
                           class="w-full px-3 sm:px-4 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent">
                </div>
            </div>

            <!-- Sort & Actions -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pt-2">
                <div class="flex items-center gap-2 sm:gap-3">
                    <label class="text-xs sm:text-sm font-medium text-gray-700 whitespace-nowrap">Sort:</label>
                    <select name="sort" 
                            onchange="this.form.submit()"
                            class="flex-1 sm:flex-none px-2 sm:px-3 py-1.5 border border-gray-300 rounded-lg text-xs sm:text-sm focus:ring-2 focus:ring-red-500 focus:border-transparent">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                    </select>
                </div>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="submit" 
                            class="flex-1 text-center sm:flex-none px-4 sm:px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-medium text-xs sm:text-sm">
                        Apply
                    </button>
                    <a href="{{ route('frontend.products.index') }}" 
                       class="flex-1 text-center sm:flex-none px-4 sm:px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-xs sm:text-sm">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>


        <!-- Results Info -->
        <div class="text-xs sm:text-sm text-gray-600" style="margin-bottom: 10px;">
            Showing <span class="font-semibold">{{ $products->firstItem() ?? 0 }}</span> to 
            <span class="font-semibold">{{ $products->lastItem() ?? 0 }}</span> of 
            <span class="font-semibold">{{ $products->total() }}</span> products
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 items-stretch">
            @forelse ($products as $product)
                <div class="h-full">
                    @include('frontend.catalog.partials.product-card', ['product' => $product])
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <p class="text-gray-500 text-lg mb-2">Produk tidak ada.</p>
                    <a href="{{ route('frontend.products.index') }}" class="text-red-600 hover:underline">
                        Cari produk lainnya
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection