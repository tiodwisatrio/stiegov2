@extends('layouts.admin')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Create Product</h2>
            <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Back to List
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Product Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="product_name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="product_name" id="product_name" value="{{ old('product_name') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                    @error('product_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category Selection (2-level dropdown) -->
                <div x-data="categorySelector()">
                    <label for="parent_category" class="block text-sm font-medium text-gray-700">Parent Category</label>
                    <select id="parent_category" 
                            x-model="selectedParent" 
                            @change="loadSubCategories()"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                            required>
                        <option value="">Select Parent Category</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->category_name }}</option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Pilih kategori utama terlebih dahulu</p>

                    <!-- Sub Category Dropdown (Muncul setelah parent dipilih) -->
                    <div x-show="selectedParent && subCategories.length > 0" class="mt-4">
                        <label for="category_id" class="block text-sm font-medium text-gray-700">Sub Category</label>
                        <select name="category_id" 
                                id="category_id" 
                                x-model="selectedSub"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                required>
                            <option value="">Select Sub Category</option>
                            <template x-for="sub in subCategories" :key="sub.id">
                                <option :value="sub.id" x-text="sub.category_name"></option>
                            </template>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Product akan disimpan di sub-kategori ini</p>
                    </div>

                    <!-- Loading State -->
                    <div x-show="loading" class="mt-4">
                        <p class="text-sm text-gray-500">Loading sub-categories...</p>
                    </div>

                    <!-- No Sub Categories Warning -->
                    <div x-show="selectedParent && !loading && subCategories.length === 0" class="mt-4">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Kategori ini belum memiliki sub-kategori. Silakan tambahkan sub-kategori terlebih dahulu di menu Categories.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Price Information -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label for="product_price" class="block text-sm font-medium text-gray-700">Base Price (Rp)</label>
                    <input type="number" name="product_price" id="product_price" value="{{ old('product_price') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <p class="mt-1 text-xs text-gray-500">Harga dasar produk. Setiap varian bisa memiliki harga berbeda.</p>
                    @error('product_price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="discount_type" class="block text-sm font-medium text-gray-700">Discount Type</label>
                    <select name="discount_type" id="discount_type" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        onchange="updateDiscountLabel()">
                        <option value="percentage" {{ old('discount_type') == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                        <option value="fixed" {{ old('discount_type') == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Pilih jenis diskon yang ingin diterapkan.</p>
                </div>

                <div>
                    <label for="product_discount" class="block text-sm font-medium text-gray-700">
                        <span id="discount_label">Discount (%)</span>
                    </label>
                    <input type="number" name="product_discount" id="product_discount" value="{{ old('product_discount', 0) }}" min="0"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <p class="mt-1 text-xs text-gray-500" id="discount_hint">Diskon akan berlaku untuk semua varian kecuali yang memiliki harga khusus.</p>
                </div>
            </div>

            <!-- Product Variants -->
            <div class="border rounded-lg p-4 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Product Variants</h3>
                    <button type="button" id="addVariant" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Add Variant
                    </button>
                </div>

                <div id="variants-container" class="space-y-4">
                    <p id="no-variants" class="text-sm text-gray-500 text-center py-4">No variants added yet. Click "Add Variant" to add product variations.</p>
                </div>
            </div>

            <!-- Product Description -->
            <div>
                <label for="product_description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="product_description" id="product_description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('product_description') }}</textarea>
            </div>

            <!-- Product Images -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Images</label>
                <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>

                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500">
                                <span>Upload files</span>
                                <input id="images" name="images[]" type="file" class="sr-only" multiple accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                    </div>
                </div>
                <!-- <div id="imagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div> -->
            </div>

            <!-- Submit -->
            <div class="flex justify-end">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-xs font-semibold uppercase rounded-md hover:bg-indigo-700">
                    Create Product
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
    // Update discount label based on discount type
    function updateDiscountLabel() {
        const discountType = document.getElementById('discount_type').value;
        const discountLabel = document.getElementById('discount_label');
        const discountInput = document.getElementById('product_discount');
        const discountHint = document.getElementById('discount_hint');
        
        if (discountType === 'percentage') {
            discountLabel.textContent = 'Discount (%)';
            discountInput.setAttribute('max', '100');
            discountHint.textContent = 'Masukkan nilai persentase diskon (0-100%).';
        } else {
            discountLabel.textContent = 'Discount (Rp)';
            discountInput.removeAttribute('max');
            discountHint.textContent = 'Masukkan nilai nominal diskon dalam Rupiah.';
        }
    }

    // Alpine.js Component untuk Category Selector
    function categorySelector() {
        return {
            selectedParent: '{{ old("parent_category") }}',
            selectedSub: '{{ old("category_id") }}',
            subCategories: [],
            loading: false,

            async loadSubCategories() {
                if (!this.selectedParent) {
                    this.subCategories = [];
                    this.selectedSub = '';
                    return;
                }

                this.loading = true;
                try {
                    const response = await fetch(`/admin/categories/${this.selectedParent}/subcategories`);
                    this.subCategories = await response.json();
                    
                    // Reset selected sub-category jika parent berubah
                    this.selectedSub = '';
                } catch (error) {
                    console.error('Error loading sub-categories:', error);
                    this.subCategories = [];
                } finally {
                    this.loading = false;
                }
            }
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Initialize discount label on page load
        updateDiscountLabel();

        const variantsContainer = document.getElementById('variants-container');
        const noVariantsText = document.getElementById('no-variants');
        const addVariantBtn = document.getElementById('addVariant');
        let variantIndex = 0;

        addVariantBtn.addEventListener('click', () => {
            noVariantsText.style.display = 'none';
            const variant = document.createElement('div');
            variant.classList.add('grid', 'grid-cols-1', 'md:grid-cols-5', 'gap-3', 'border', 'rounded-lg', 'p-3', 'relative');
            variant.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700">Size</label>
                    <input type="text" name="variant_size[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Color</label>
                    <input type="text" name="variant_color[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Stock</label>
                    <input type="number" name="variant_stock[]" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
             
                <button type="button" class="absolute top-2 right-2 text-red-600 hover:text-red-800" onclick="this.parentElement.remove(); if(!variantsContainer.children.length){noVariantsText.style.display='block';}">
                    ✕
                </button>
            `;
            variantsContainer.appendChild(variant);
        });

        // Gambar preview
        const input = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        input.addEventListener('change', () => {
            previewContainer.innerHTML = '';
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'relative group border rounded-lg overflow-hidden';
                    div.style.paddingBottom = '100%';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="absolute inset-0 w-full h-full object-cover">
                        <button type="button" class="absolute top-2 right-2 bg-red-600 text-white rounded-full p-1 opacity-0 group-hover:opacity-100" onclick="this.parentElement.remove()">
                            ✕
                        </button>`;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        });
    });
    </script>
    @endpush
@endsection
