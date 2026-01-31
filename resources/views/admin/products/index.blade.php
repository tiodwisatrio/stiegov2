@extends('layouts.admin')

@section('content')
    <div class="bg-white p-3 sm:p-6 rounded-lg shadow">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 sm:mb-6">
            <h3 class="text-lg sm:text-xl text-gray-900 font-semibold mb-3 sm:mb-0">Product Management</h3>

            <!-- Add Product Button (Mobile & Desktop) -->
            <a href="{{ route('admin.products.create') }}" class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add Product
            </a>
        </div>

        <!-- Filters Section -->
        <div x-data="{ filtersOpen: false }" class="mb-4 sm:mb-6">
            <!-- Mobile Filter Toggle Button -->
            <button @click="filtersOpen = !filtersOpen" class="w-full sm:hidden flex items-center justify-between px-4 py-3 bg-gray-50 rounded-lg mb-3">
                <span class="text-sm font-medium text-gray-700">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                    </svg>
                    Filters
                </span>
                <svg class="w-5 h-5 text-gray-500 transition-transform" :class="filtersOpen ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Filters Form -->
            <div x-show="filtersOpen" x-transition class="sm:!block">
                <form action="{{ route('admin.products.index') }}" method="GET" class="space-y-3 sm:space-y-0 sm:flex sm:flex-wrap sm:gap-3">
                    <!-- Search Input -->
                    <div class="flex-1 min-w-full sm:min-w-[200px]">
                        <label class="block text-xs font-medium text-gray-700 mb-1 sm:hidden">Search</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ is_array(request('search')) ? '' : request('search') }}"
                                   class="w-full rounded-md border-gray-300 pl-10 pr-4 py-2 text-sm text-gray-900 placeholder-gray-500 focus:border-indigo-500 focus:ring-indigo-500"
                                   placeholder="Search products...">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div class="flex-1 min-w-full sm:min-w-[180px]">
                        <label class="block text-xs font-medium text-gray-700 mb-1 sm:hidden">Category</label>
                        <select name="category" class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range Filter -->
                    <div class="flex-1 min-w-full sm:min-w-[180px]">
                        <label class="block text-xs font-medium text-gray-700 mb-1 sm:hidden">Price Range</label>
                        <select name="price_range" class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Prices</option>
                            <option value="0-100000" {{ request('price_range') == '0-100000' ? 'selected' : '' }}>0 - 100K</option>
                            <option value="100000-500000" {{ request('price_range') == '100000-500000' ? 'selected' : '' }}>100K - 500K</option>
                            <option value="500000-1000000" {{ request('price_range') == '500000-1000000' ? 'selected' : '' }}>500K - 1M</option>
                            <option value="1000000+" {{ request('price_range') == '1000000+' ? 'selected' : '' }}>> 1M</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="flex-1 min-w-full sm:min-w-[150px]">
                        <label class="block text-xs font-medium text-gray-700 mb-1 sm:hidden">Status</label>
                        <select name="status" class="w-full rounded-md border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 w-full sm:w-auto">
                        <button type="submit" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <span class="hidden sm:inline">Filter</span>
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            <span class="hidden sm:inline">Reset</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Active Filters -->
        @if(request('search') || request('category') || request('price_range') || request('status'))
            <div class="mb-4 sm:mb-6 flex flex-wrap gap-2">
                @if(request('search'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-indigo-100 text-indigo-800">
                        <span class="truncate max-w-[100px] sm:max-w-none">Search: {{ request('search') }}</span>
                        <a href="{{ url()->current() . '?' . http_build_query(request()->except('search')) }}" class="ml-2 text-indigo-600 hover:text-indigo-900">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                @if(request('category'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-green-100 text-green-800">
                        <span class="truncate max-w-[120px] sm:max-w-none">{{ $categories->find(request('category'))->category_name }}</span>
                        <a href="{{ url()->current() . '?' . http_build_query(request()->except('category')) }}" class="ml-2 text-green-600 hover:text-green-900">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                @if(request('status'))
                    <div class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-purple-100 text-purple-800">
                        {{ ucfirst(request('status')) }}
                        <a href="{{ url()->current() . '?' . http_build_query(request()->except('status')) }}" class="ml-2 text-purple-600 hover:text-purple-900">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    </div>
                @endif

                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs sm:text-sm font-medium bg-gray-100 text-gray-800 hover:bg-gray-200">
                    Clear All
                </a>
            </div>
        @endif

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 sm:p-4 mb-4 sm:mb-6 text-sm" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 sm:p-4 mb-4 sm:mb-6 text-sm" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <!-- Desktop Table View (hidden on mobile) -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Final Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                        <tr>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900 max-w-xs line-clamp-2" title="{{ $product->product_name }}">
                                    {{ $product->product_name }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->category->category_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">Rp {{ number_format($product->product_price, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $product->discount_percentage }}%</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">Rp {{ number_format($product->product_price_after_discount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->is_archived)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Archived
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>

                                    @if($product->is_archived)
                                        <form action="{{ route('admin.products.restore', $product) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900"
                                                    onclick="return confirm('Are you sure you want to restore this product?')"
                                                    title="Restore">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.products.archive', $product) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-yellow-600 hover:text-yellow-900"
                                                    onclick="return confirm('Are you sure you want to archive this product?')"
                                                    title="Archive">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                                onclick="return confirm('Are you sure you want to delete this product?')"
                                                title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Produk tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile Card View (hidden on desktop) -->
        <div class="lg:hidden space-y-3">
            @forelse ($products as $product)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                    <!-- Product Name & Status -->
                    <div class="flex items-start justify-between mb-3">
                        <h4 class="text-sm font-semibold text-gray-900 flex-1 pr-2 line-clamp-2">
                            {{ $product->product_name }}
                        </h4>
                        @if($product->is_archived)
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 whitespace-nowrap">
                                Archived
                            </span>
                        @else
                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800 whitespace-nowrap">
                                Active
                            </span>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="space-y-2 text-sm mb-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Category:</span>
                            <span class="text-gray-900 font-medium">{{ $product->category->category_name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Price:</span>
                            <span class="text-gray-900">Rp {{ number_format($product->product_price, 0, ',', '.') }}</span>
                        </div>
                        @if($product->discount_percentage > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Discount:</span>
                                <span class="text-red-600 font-medium">{{ $product->discount_percentage }}%</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Final Price:</span>
                                <span class="text-gray-900 font-bold">Rp {{ number_format($product->product_price_after_discount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-2 pt-3 border-t border-gray-200">
                        <a href="{{ route('admin.products.edit', $product) }}" class="flex-1 inline-flex items-center justify-center px-3 py-2 bg-indigo-600 text-white text-xs font-medium rounded hover:bg-indigo-700">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>

                        @if($product->is_archived)
                            <form action="{{ route('admin.products.restore', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Restore this product?')"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white text-xs font-medium rounded hover:bg-green-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Restore
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.products.archive', $product) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" onclick="return confirm('Archive this product?')"
                                        class="w-full inline-flex items-center justify-center px-3 py-2 bg-yellow-600 text-white text-xs font-medium rounded hover:bg-yellow-700">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    Archive
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete this product permanently?')"
                                    class="inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white text-xs font-medium rounded hover:bg-red-700">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <svg class="w-16 h-16 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">Produk tidak ditemukan.</p>
                    <a href="{{ route('admin.products.index') }}" class="text-indigo-600 text-sm mt-2 inline-block">Silahkan cari produk lainnya ya</a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 sm:mt-6">
            {{ $products->links() }}
        </div>
    </div>
@endsection
