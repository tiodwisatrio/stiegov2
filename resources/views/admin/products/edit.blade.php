@extends('layouts.admin')

@section('content')
<div class="bg-white p-6 rounded-lg shadow">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Edit Product</h2>
        <a href="{{ route('admin.products.index') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
            ← Back to List
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productEditForm" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Product Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Product Name</label>
                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>

            <!-- Category Selection (2-level dropdown) -->
            <div x-data="categorySelector({{ $selectedParentId }}, {{ $product->category_id }}, {{ json_encode($subCategories) }})">
                <label for="parent_category" class="block text-sm font-medium text-gray-700">Parent Category</label>
                <select id="parent_category" 
                        x-model="selectedParent" 
                        @change="loadSubCategories()"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                        required>
                    <option value="">Select Parent Category</option>
                    @foreach($parentCategories as $parent)
                        <option value="{{ $parent->id }}" {{ $selectedParentId == $parent->id ? 'selected' : '' }}>
                            {{ $parent->category_name }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Pilih kategori utama terlebih dahulu</p>

                <!-- Sub Category Dropdown -->
                <div x-show="selectedParent && subCategories.length > 0" class="mt-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Sub Category</label>
                    <select name="category_id" 
                            id="category_id" 
                            x-model="selectedSub"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                            required>
                        <option value="">Select Sub Category</option>
                        <template x-for="sub in subCategories" :key="sub.id">
                            <option :value="sub.id" x-text="sub.category_name" :selected="sub.id == selectedSub"></option>
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

        <!-- Price Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700">Base Price (Rp)</label>
                <input type="number" name="product_price" value="{{ old('product_price', $product->product_price) }}"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
            </div>
            
            <div>
                <label for="discount_type" class="block text-sm font-medium text-gray-700">Discount Type</label>
                <select name="discount_type" id="discount_type" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    onchange="updateDiscountLabel()">
                    <option value="percentage" {{ old('discount_type', $product->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                    <option value="fixed" {{ old('discount_type', $product->discount_type) == 'fixed' ? 'selected' : '' }}>Fixed Amount (Rp)</option>
                </select>
                <p class="mt-1 text-xs text-gray-500">Pilih jenis diskon yang ingin diterapkan.</p>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    <span id="discount_label">Discount</span>
                </label>
                <input type="number" name="product_discount" id="product_discount" value="{{ old('product_discount', $product->product_discount) }}"
                       min="0"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-1 text-xs text-gray-500" id="discount_hint"></p>
            </div>
        </div>

        <!-- Variants -->
        <div class="border rounded-lg p-4 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Product Variants</h3>
                <button type="button" onclick="addVariant()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    + Add Variant
                </button>
            </div>

            <div id="variants-container" class="space-y-4">
                @foreach($product->variants as $variant)
                    <div class="grid grid-cols-4 gap-4 items-end variant-item">
                        <div>
                            <label class="block text-sm text-gray-700">Size</label>
                            <input type="text" name="variant_size[]" value="{{ $variant->variant_size }}" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Color</label>
                            <input type="text" name="variant_color[]" value="{{ $variant->variant_color }}" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Stock</label>
                            <input type="number" name="variant_stock[]" value="{{ $variant->stock }}" class="w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-700">Price Override</label>
                            <div class="flex items-center gap-2">
                                <input type="number" name="variant_price_override[]" value="{{ $variant->price_override }}" class="w-full rounded-md border-gray-300 shadow-sm">
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="this.closest('.variant-item').remove()">✕</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="product_description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('product_description', $product->product_description) }}</textarea>
        </div>

        <!-- Image Upload -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Product Images</label>

            <div id="existingImages" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                @foreach($product->images as $image)
                    <div class="relative border rounded-lg overflow-hidden group" data-image-id="{{ $image->id }}" style="padding-bottom: 100%;">
                        <img src="{{ Storage::url($image->image_path) }}" class="absolute inset-0 w-full h-full object-cover" alt="">
                        <button type="button" class="absolute top-2 right-2 bg-black bg-opacity-50 text-white rounded-full p-1 hover:bg-opacity-75" onclick="deleteImage({{ $image->id }}, this)">✕</button>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                <label class="cursor-pointer text-indigo-600 hover:text-indigo-800">
                    <span>Upload New Images</span>
                    <input id="new_images" name="new_images[]" type="file" class="sr-only" multiple accept="image/*">
                </label>
                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB each</p>
            </div>

            <div id="newImagePreviewContainer" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4"></div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Update Product
            </button>
        </div>
    </form>
</div>
@endsection

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

// Alpine.js Component untuk Category Selector (Edit Mode)
function categorySelector(initialParent, initialSub, initialSubCategories) {
    return {
        selectedParent: initialParent,
        selectedSub: initialSub,
        subCategories: initialSubCategories || [],
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
                
                // Reset selected sub jika parent berubah (kecuali saat init)
                if (this.selectedParent != initialParent) {
                    this.selectedSub = '';
                }
            } catch (error) {
                console.error('Error loading sub-categories:', error);
                this.subCategories = [];
            } finally {
                this.loading = false;
            }
        }
    }
}

// Initialize discount label on page load
document.addEventListener('DOMContentLoaded', () => {
    updateDiscountLabel();
});

function addVariant(size = '', color = '', stock = '', price = '') {
    const container = document.getElementById('variants-container');
    const div = document.createElement('div');
    div.className = 'grid grid-cols-4 gap-4 items-end variant-item';
    div.innerHTML = `
        <div><label class="block text-sm text-gray-700">Size</label><input type="text" name="variant_size[]" value="${size}" class="w-full rounded-md border-gray-300 shadow-sm"></div>
        <div><label class="block text-sm text-gray-700">Color</label><input type="text" name="variant_color[]" value="${color}" class="w-full rounded-md border-gray-300 shadow-sm"></div>
        <div><label class="block text-sm text-gray-700">Stock</label><input type="number" name="variant_stock[]" value="${stock}" class="w-full rounded-md border-gray-300 shadow-sm"></div>
        <div><label class="block text-sm text-gray-700">Price Override</label><div class="flex items-center gap-2"><input type="number" name="variant_price_override[]" value="${price}" class="w-full rounded-md border-gray-300 shadow-sm"><button type="button" class="text-red-600 hover:text-red-800" onclick="this.closest('.variant-item').remove()">✕</button></div></div>
    `;
    container.appendChild(div);
}

// Multi image preview
document.getElementById('new_images').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('newImagePreviewContainer');
    previewContainer.innerHTML = ''; // reset preview
    const files = Array.from(e.target.files);
    files.forEach(file => {
        const reader = new FileReader();
        reader.onload = ev => {
            const wrapper = document.createElement('div');
            wrapper.className = 'relative border rounded-lg overflow-hidden group';
            wrapper.style.paddingBottom = '100%';
            wrapper.innerHTML = `
                <img src="${ev.target.result}" class="absolute inset-0 w-full h-full object-cover" alt="">
                <button type="button" class="absolute top-2 right-2 bg-black bg-opacity-50 text-white rounded-full p-1 hover:bg-opacity-75" onclick="this.closest('.group').remove()">✕</button>
            `;
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });
});

// AJAX Delete Image
async function deleteImage(imageId, button) {
    if (!confirm('Yakin hapus gambar ini?')) return;

    const response = await fetch(`/admin/products/image/${imageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    });

    if (response.ok) {
        button.closest('[data-image-id]').remove();
    } else {
        alert('Gagal menghapus gambar!');
    }
}
</script>
@endpush
