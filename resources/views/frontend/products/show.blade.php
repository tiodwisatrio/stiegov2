@extends('layouts.frontend')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Product Details Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12" x-data="productDetail()">
            
            <!-- Left Column: Image Gallery -->
            <div class="space-y-4">
                <!-- Main Image -->
                <div class="relative bg-gray-100 rounded-lg overflow-hidden" style="padding-bottom: 100%;">
                    @if($product->images->isNotEmpty())
                        <img :src="mainImage" 
                             alt="{{ $product->product_name }}"
                             class="absolute inset-0 w-full h-full object-cover">
                    @else
                        <div class="absolute inset-0 flex items-center justify-center bg-gray-200">
                            <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    @endif

                    <!-- Discount Badge -->
                    @if($product->product_discount > 0)
                        <div class="absolute bg-red-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg z-10" style="top: 16px; left: 16px;">
                            Save {{ $product->discount_percentage }}%
                        </div>
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($product->images as $image)
                            <button type="button"
                                    @click="selectImage('{{ Storage::url($image->image_path) }}')"
                                    :class="mainImage === '{{ Storage::url($image->image_path) }}' ? 'ring-2 ring-red-600' : 'ring-1 ring-gray-300'"
                                    class="relative bg-gray-100 rounded-lg overflow-hidden hover:ring-red-600 transition cursor-pointer"
                                    style="padding-bottom: 100%;">
                                <img src="{{ Storage::url($image->image_path) }}" 
                                     alt="{{ $product->product_name }}"
                                     class="absolute inset-0 w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Right Column: Product Info -->
            <div class="space-y-6">
                <!-- Product Title -->
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight">
                        {{ $product->product_name }}
                    </h1>
                    
                    <!-- Category Badge -->
                    @if($product->category)
                        <div class="mt-3 flex items-center gap-2 text-sm text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            @if($product->category->parent)
                                <span>{{ $product->category->parent->category_name }} • </span>
                            @endif
                            <span class="font-medium">{{ $product->category->category_name }}</span>
                        </div>
                    @endif
                </div>

                <!-- Price Section -->
                <div class="border-t border-b border-gray-200 py-4">
                    @php
                        $finalPrice = $product->product_price_after_discount;
                        $hasDiscount = $product->product_discount > 0;
                    @endphp

                    @if($hasDiscount)
                        <div class="flex items-baseline gap-3">
                            <span class="text-3xl sm:text-4xl font-bold text-red-600">
                                Rp {{ number_format($finalPrice, 0, ',', '.') }}
                            </span>
                            <span class="text-xl text-gray-400 line-through" style="text-decoration: line-through;">
                                Rp {{ number_format($product->product_price, 0, ',', '.') }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-green-600 font-medium">
                            Kamu hemat Rp {{ number_format($product->product_price - $finalPrice, 0, ',', '.') }} ({{ $product->discount_percentage }}%)
                        </p>
                    @else
                        <span class="text-3xl sm:text-4xl font-bold text-gray-900">
                            Rp {{ number_format($product->product_price, 0, ',', '.') }}
                        </span>
                    @endif
                </div>

                <!-- Variants Selection -->
                @if($product->variants->isNotEmpty())
                    @php
                        $sizes = $product->variants->pluck('variant_size')->unique();
                        $colors = $product->variants->pluck('variant_color')->unique();
                    @endphp

                    <!-- Size Selection -->
                    @if($sizes->count() > 0)
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-3">
                                Ukuran: <span x-text="selectedSize || 'Pilih ukuran'" class="text-red-600"></span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($sizes as $size)
                                    <button type="button"
                                            @click="selectSize('{{ $size }}')"
                                            :disabled="!isSizeAvailable('{{ $size }}')"
                                            :class="{
                                                'bg-red-600 text-white border-red-600': selectedSize === '{{ $size }}',
                                                'bg-white text-gray-900 border-gray-300 hover:border-red-600': selectedSize !== '{{ $size }}' && isSizeAvailable('{{ $size }}'),
                                                'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed': !isSizeAvailable('{{ $size }}')
                                            }"
                                            class="px-6 py-2.5 border-2 rounded-lg font-medium transition-colors">
                                        {{ strtoupper($size) }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Color Selection -->
                    @if($colors->count() > 0)
                        <div>
                            <label class="block text-sm font-semibold text-gray-900 mb-3">
                                Warna: <span x-text="selectedColor || 'Pilih warna'" class="text-red-600"></span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($colors as $color)
                                    <button type="button"
                                            @click="selectColor('{{ $color }}')"
                                            :disabled="!isColorAvailable('{{ $color }}')"
                                            :class="{
                                                'bg-red-600 text-white border-red-600': selectedColor === '{{ $color }}',
                                                'bg-white text-gray-900 border-gray-300 hover:border-red-600': selectedColor !== '{{ $color }}' && isColorAvailable('{{ $color }}'),
                                                'bg-gray-100 text-gray-400 border-gray-200 cursor-not-allowed': !isColorAvailable('{{ $color }}')
                                            }"
                                            class="px-6 py-2.5 border-2 rounded-lg font-medium transition-colors capitalize">
                                        {{ $color }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Stock Info for Selected Variant -->
                    <div x-show="selectedVariant" class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-gray-700">Stock tersedia:</span>
                            <span x-text="availableStock + ' pcs'" class="text-sm font-bold" :class="availableStock > 0 ? 'text-green-600' : 'text-red-600'"></span>
                        </div>
                    </div>
                @endif

                <!-- Quantity Selector -->
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-3">Jumlah</label>
                    <div class="flex items-center gap-3">
                        <button type="button"
                                @click="decreaseQuantity()"
                                class="w-10 h-10 flex items-center justify-center text-gray-900 bg-gray-200 hover:bg-gray-300 rounded-lg transition px-5 py-2.5">
                            -
                        </button>
                        <input type="number" 
                               x-model="quantity"
                               min="1"
                               :max="availableStock"
                               class="w-20 text-center text-lg font-semibold border-2 border-gray-300 rounded-lg py-2 focus:border-red-600 focus:ring-0">
                        <button type="button"
                                @click="increaseQuantity()"
                                class="w-10 h-10 flex items-center justify-center bg-red-600 hover:bg-red-700 text-white rounded-lg transition px-5 py-2.5">
                            +
                        </button>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 pt-4">
                    <button type="button"
                            @click="addToCart()"
                            :disabled="!canAddToCart()"
                            :class="canAddToCart() ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-400 cursor-not-allowed'"
                            class="flex-1 py-4 px-6 rounded-lg text-white font-semibold text-lg transition flex items-center justify-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <span>Add to Cart</span>
                    </button>
                    
                    <!-- Button chat -->
                      <a href="https://wa.me/6289527668283?text=Saya%20tertarik%20dengan%20produk%20{{ urlencode($product->product_name) }}" 
                       target="_blank"
                          class="w-16 h-16 flex items-center justify-center bg-green-500 hover:bg-green-600 text-white rounded-lg transition px-5 py-2.5">
                            <!-- <img src="{{ asset('images/whatsapp_icon.svg') }}" alt="whatsapp" class="w-8 h-8 text-white"> -->
                             <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="100" height="100" viewBox="0,0,256,256">
                                <g fill="#ffffff" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M25,2c-12.682,0 -23,10.318 -23,23c0,3.96 1.023,7.854 2.963,11.29l-2.926,10.44c-0.096,0.343 -0.003,0.711 0.245,0.966c0.191,0.197 0.451,0.304 0.718,0.304c0.08,0 0.161,-0.01 0.24,-0.029l10.896,-2.699c3.327,1.786 7.074,2.728 10.864,2.728c12.682,0 23,-10.318 23,-23c0,-12.682 -10.318,-23 -23,-23zM36.57,33.116c-0.492,1.362 -2.852,2.605 -3.986,2.772c-1.018,0.149 -2.306,0.213 -3.72,-0.231c-0.857,-0.27 -1.957,-0.628 -3.366,-1.229c-5.923,-2.526 -9.791,-8.415 -10.087,-8.804c-0.295,-0.389 -2.411,-3.161 -2.411,-6.03c0,-2.869 1.525,-4.28 2.067,-4.864c0.542,-0.584 1.181,-0.73 1.575,-0.73c0.394,0 0.787,0.005 1.132,0.021c0.363,0.018 0.85,-0.137 1.329,1.001c0.492,1.168 1.673,4.037 1.819,4.33c0.148,0.292 0.246,0.633 0.05,1.022c-0.196,0.389 -0.294,0.632 -0.59,0.973c-0.296,0.341 -0.62,0.76 -0.886,1.022c-0.296,0.291 -0.603,0.606 -0.259,1.19c0.344,0.584 1.529,2.493 3.285,4.039c2.255,1.986 4.158,2.602 4.748,2.894c0.59,0.292 0.935,0.243 1.279,-0.146c0.344,-0.39 1.476,-1.703 1.869,-2.286c0.393,-0.583 0.787,-0.487 1.329,-0.292c0.542,0.194 3.445,1.604 4.035,1.896c0.59,0.292 0.984,0.438 1.132,0.681c0.148,0.242 0.148,1.41 -0.344,2.771z"></path></g></g>
                                </svg>
                             
                        </a>
                </div>

                <!-- Product Description -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi Produk</h3>
                    <div class="prose prose-sm text-gray-600 leading-relaxed">
                        <!--{{ $product->product_description }}-->
                            {!! nl2br(e($product->product_description)) !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function productDetail() {
    return {
        mainImage: '{{ $product->images->first() ? Storage::url($product->images->first()->image_path) : "" }}',
        selectedSize: '',
        selectedColor: '',
        selectedVariant: null,
        availableStock: 0,
        quantity: 1,
        variants: @json($product->variants),

        selectImage(imageUrl) {
            this.mainImage = imageUrl;
        },

        selectSize(size) {
            // Toggle: Jika klik ukuran yang sama, deselect (reset ke default)
            if (this.selectedSize === size) {
                this.selectedSize = '';
                this.selectedVariant = null;
                this.availableStock = 0;
                return;
            }
            
            this.selectedSize = size;
            
            // Jika warna sudah dipilih tapi tidak ada kombinasi dengan size ini, reset warna
            if (this.selectedColor && !this.isColorAvailable(this.selectedColor)) {
                this.selectedColor = '';
                this.selectedVariant = null;
                this.availableStock = 0;
            }
            
            this.updateVariant();
        },

        selectColor(color) {
            // Toggle: Jika klik warna yang sama, deselect (reset ke default)
            if (this.selectedColor === color) {
                this.selectedColor = '';
                this.selectedVariant = null;
                this.availableStock = 0;
                return;
            }
            
            this.selectedColor = color;
            
            // Jika size sudah dipilih tapi tidak ada kombinasi dengan color ini, reset size
            if (this.selectedSize && !this.isSizeAvailable(this.selectedSize)) {
                this.selectedSize = '';
                this.selectedVariant = null;
                this.availableStock = 0;
            }
            
            this.updateVariant();
        },

        // Cek apakah ukuran tersedia berdasarkan warna yang dipilih
        isSizeAvailable(size) {
            // Jika belum pilih warna, semua ukuran tersedia
            if (!this.selectedColor) {
                return true;
            }
            
            // Cek apakah ada variant dengan size ini dan warna yang dipilih
            return this.variants.some(v => 
                v.variant_size === size && 
                v.variant_color === this.selectedColor &&
                v.stock > 0
            );
        },

        // Cek apakah warna tersedia berdasarkan ukuran yang dipilih
        isColorAvailable(color) {
            // Jika belum pilih ukuran, semua warna tersedia
            if (!this.selectedSize) {
                return true;
            }
            
            // Cek apakah ada variant dengan warna ini dan ukuran yang dipilih
            return this.variants.some(v => 
                v.variant_color === color && 
                v.variant_size === this.selectedSize &&
                v.stock > 0
            );
        },

        updateVariant() {
            if (this.selectedSize && this.selectedColor) {
                this.selectedVariant = this.variants.find(v => 
                    v.variant_size === this.selectedSize && 
                    v.variant_color === this.selectedColor
                );
                
                if (this.selectedVariant) {
                    this.availableStock = this.selectedVariant.stock;
                    this.quantity = 1;
                } else {
                    this.availableStock = 0;
                    this.selectedVariant = null;
                }
            }
        },

        increaseQuantity() {
            if (this.quantity < this.availableStock) {
                this.quantity++;
            }
        },

        decreaseQuantity() {
            if (this.quantity > 1) {
                this.quantity--;
            }
        },

        canAddToCart() {
            // Jika ada variants, harus pilih size dan color
            if (this.variants.length > 0) {
                return this.selectedVariant && this.availableStock > 0 && this.quantity > 0;
            }
            // Jika tidak ada variants, bisa langsung add
            return true;
        },

        addToCart() {
            if (!this.canAddToCart()) {
                if (!this.selectedSize) {
                    alert('Pilih ukuran terlebih dahulu');
                } else if (!this.selectedColor) {
                    alert('Pilih warna terlebih dahulu');
                } else if (this.availableStock <= 0) {
                    alert('Stock tidak tersedia');
                }
                return;
            }

            // Submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("frontend.cart.add") }}';
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            const productInput = document.createElement('input');
            productInput.type = 'hidden';
            productInput.name = 'product_id';
            productInput.value = {{ $product->id }};
            form.appendChild(productInput);

            if (this.selectedVariant) {
                const variantInput = document.createElement('input');
                variantInput.type = 'hidden';
                variantInput.name = 'variant_id';
                variantInput.value = this.selectedVariant.id;
                form.appendChild(variantInput);
            }

            const sizeInput = document.createElement('input');
            sizeInput.type = 'hidden';
            sizeInput.name = 'size';
            sizeInput.value = this.selectedSize;
            form.appendChild(sizeInput);

            const colorInput = document.createElement('input');
            colorInput.type = 'hidden';
            colorInput.name = 'color';
            colorInput.value = this.selectedColor;
            form.appendChild(colorInput);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = this.quantity;
            form.appendChild(quantityInput);

            document.body.appendChild(form);
            form.submit();

        }
    }
}
</script>
@endpush
@endsection