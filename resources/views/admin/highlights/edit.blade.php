@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Highlight</h2>
        <a href="{{ route('admin.highlights.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700">
            Back to List
        </a>
    </div>

    <form action="{{ route('admin.highlights.update', $highlight) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div x-data="{
            open: false,
            search: '',
            selectedProduct: @js([
                'id' => $highlight->product->id,
                'name' => $highlight->product->product_name,
                'image' => $highlight->product->images->first() ? Storage::url($highlight->product->images->first()->image_path) : null,
                'category' => $highlight->product->category->category_name ?? ''
            ]),
            products: {{ Js::from($products->map(function($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->product_name,
                    'image' => $p->images->first() ? Storage::url($p->images->first()->image_path) : null,
                    'category' => $p->category->category_name ?? ''
                ];
            })) }},
            get filteredProducts() {
                if (this.search === '') return this.products;
                return this.products.filter(p =>
                    p.name.toLowerCase().includes(this.search.toLowerCase()) ||
                    p.category.toLowerCase().includes(this.search.toLowerCase())
                );
            },
            selectProduct(product) {
                this.selectedProduct = product;
                this.open = false;
                this.search = '';
            }
        }" @click.away="open = false" class="relative">
            <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Product</label>

            <!-- Hidden input for form submission -->
            <input type="hidden" name="product_id" :value="selectedProduct?.id" required>

            <!-- Selected Product Display -->
            <div @click="open = !open" class="cursor-pointer">
                <div x-show="selectedProduct" class="mt-1 flex items-center gap-3 rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm hover:border-indigo-400">
                    <img x-show="selectedProduct?.image" :src="selectedProduct?.image" :alt="selectedProduct?.name" class="w-12 h-12 object-cover rounded">
                    <div x-show="!selectedProduct?.image" class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No img</div>
                    <div class="flex-1">
                        <div class="font-medium text-gray-900" x-text="selectedProduct?.name"></div>
                        <div class="text-xs text-gray-500" x-text="selectedProduct?.category"></div>
                    </div>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                    </svg>
                </div>
            </div>

            <!-- Dropdown -->
            <div x-show="open" x-transition class="absolute z-10 mt-1 w-full bg-white rounded-md border border-gray-300 shadow-lg max-h-96 overflow-hidden">
                <!-- Search Input -->
                <div class="p-2 border-b">
                    <input
                        x-model="search"
                        type="text"
                        placeholder="Search products..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        @click.stop>
                </div>

                <!-- Product List -->
                <div class="overflow-y-auto max-h-80">
                    <template x-for="product in filteredProducts" :key="product.id">
                        <div @click="selectProduct(product)" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 cursor-pointer border-b border-gray-100">
                            <img x-show="product.image" :src="product.image" :alt="product.name" class="w-12 h-12 object-cover rounded">
                            <div x-show="!product.image" class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center text-gray-400 text-xs">No img</div>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900" x-text="product.name"></div>
                                <div class="text-xs text-gray-500" x-text="product.category"></div>
                            </div>
                        </div>
                    </template>

                    <div x-show="filteredProducts.length === 0" class="px-3 py-8 text-center text-gray-500">
                        No products found
                    </div>
                </div>
            </div>
        </div>

        <div>
            <label for="highlight_type_id" class="block text-sm font-medium text-gray-700">Highlight Type</label>
            <select name="highlight_type_id" id="highlight_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">Select Highlight Type</option>
                @foreach($highlightTypes as $type)
                    <option value="{{ $type->id }}" {{ old('highlight_type_id', $highlight->highlight_type_id) == $type->id ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                @endforeach
            </select>
            <p class="mt-1 text-xs text-gray-500">Manage highlight types in <a href="{{ route('admin.highlight-types.index') }}" class="text-indigo-600 hover:underline">Highlight Types</a></p>
        </div>

        <div>
            <label for="priority" class="block text-sm font-medium text-gray-700">Priority (optional)</label>
            <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">Default</option>
                @for ($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}" {{ old('priority', $highlight->priority) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <p class="mt-1 text-xs text-gray-500">1 = tampil paling atas di katalog.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $highlight->start_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $highlight->end_date) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700">
                Update Highlight
            </button>
        </div>
    </form>
</div>
@endsection
