@extends('layouts.frontend')

@section('content')
<!-- Main Container -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <!-- Hero Section -->
    <section class="flex flex-col lg:flex-row items-center justify-between gap-8 py-8 lg:py-16" aria-label="Hero Section">
        <!-- Left Content -->
        <div class="w-full lg:w-5/12 space-y-6 text-center lg:text-left">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                Ingin tampil stylish dengan pakaian yang trendy & kekinian?
            </h1>
            <p class="text-lg text-gray-600">
                Kami punya solusinya! Tunjukan karakter kamu lewat outfit dari Stiego dan style yang nunjukin gaya kamu.
            </p>
            <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4 pt-6">
                <a href="{{ route('frontend.products.index') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-full bg-red-700 hover:bg-red-800 text-white font-medium transition-colors text-center focus:outline-none focus:ring-4 focus:ring-red-300"
                   aria-label="Belanja Sekarang">
                    Belanja Sekarang
                </a>
                <a href="{{ route('frontend.catalog.index') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-full border-2 border-red-700 text-red-700 font-medium hover:bg-red-700 hover:text-white transition-colors text-center focus:outline-none focus:ring-4 focus:ring-red-200"
                   aria-label="Lihat catalog">
                    Lihat Catalog
                </a>
            </div>
        </div>

        <!-- Right Image Grid -->
        <div class="w-full lg:w-7/12 mt-8 lg:mt-0">
            <div class="grid grid-cols-4 gap-3 md:gap-4">
                <!-- Main large image -->
                <div class="col-span-3">
                    <img src="{{ asset('images/home_1_image_new_compress.webp') }}" 
                         alt="Outfit utama Stiego" loading="lazy"
                         class="w-full h-[250px] sm:h-[300px] md:h-[350px] lg:h-[400px] object-cover rounded-lg shadow-lg object-contain">
                </div>
                <!-- Two smaller images -->
                <div class="space-y-3 md:space-y-4">
                    <img src="{{ asset('images/image_stiego_2_compress.webp') }}"
                         alt="Outfit tambahan 1" loading="lazy"
                         class="w-full h-[120px] sm:h-[145px] md:h-[170px] lg:h-[190px] object-cover rounded-lg shadow-md object-contain">
                    <img src="{{ asset('images/home_3_image_new_compress.webp') }}"
                         alt="Outfit tambahan 2" loading="lazy"
                         class="w-full h-[120px] sm:h-[145px] md:h-[170px] lg:h-[190px] object-cover rounded-lg shadow-md object-contain">
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Slider Section -->
    <div id="banner-slider" class="relative md:py-4"
         x-data="{ 
            currentIndex: 0, 
            banners: {{ json_encode($banners) }},
            autoplayInterval: null,
            startX: 0,
            endX: 0,
            isDragging: false,
            startAutoplay() { this.autoplayInterval = setInterval(() => this.next(), 5000) },
            stopAutoplay() { clearInterval(this.autoplayInterval) },
            next() { this.currentIndex = (this.currentIndex + 1) % this.banners.length },
            prev() { this.currentIndex = (this.currentIndex - 1 + this.banners.length) % this.banners.length },
            handleStart(e) { this.stopAutoplay(); this.isDragging = true; this.startX = e.touches ? e.touches[0].clientX : e.clientX },
            handleMove(e) { if (!this.isDragging) return; this.endX = e.touches ? e.touches[0].clientX : e.clientX },
            handleEnd() { if (!this.isDragging) return; const d = this.endX - this.startX; if (Math.abs(d) > 50) { d < 0 ? this.next() : this.prev() } this.isDragging = false; this.startAutoplay() }
         }"
         x-init="startAutoplay()"
         @mouseenter="stopAutoplay()"
         @mouseleave="startAutoplay()">

        <div class="overflow-hidden rounded-lg relative w-full">
            <!-- Slides -->
            <div class="flex transition-transform duration-500 ease-in-out w-full select-none"
                 :style="`transform: translateX(-${currentIndex * 100}%);`"
                 @mousedown="handleStart($event)"
                 @mousemove="handleMove($event)"
                 @mouseup="handleEnd()"
                 @mouseleave="isDragging && handleEnd()"
                 @touchstart="handleStart($event)"
                 @touchmove="handleMove($event)"
                 @touchend="handleEnd()">

                @foreach ($banners as $index => $banner)
                <div class="flex-shrink-0 w-full">
                    <div class="w-full aspect-[16/9] sm:aspect-[16/7] md:aspect-[16/6] lg:aspect-[16/5]">
                        <img src="{{ Storage::url($banner->banner_image) }}" 
                             alt="{{ $banner->banner_title }}" loading="lazy"
                             class="w-full h-full object-contain rounded-lg pointer-events-none">
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navigation -->
            <button @click.prevent="prev()" aria-label="Sebelumnya"
                    class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-1 sm:p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-white">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click.prevent="next()" aria-label="Berikutnya"
                    class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-black/30 hover:bg-black/50 text-white p-1 sm:p-2 rounded-full focus:outline-none focus:ring-2 focus:ring-white">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>

        <!-- Dots -->
        <div class="absolute left-1/2 transform -translate-x-1/2 flex space-x-2 py-6" style="margin-top: -10px;">
            @foreach ($banners as $index => $banner)
            <button aria-label="sekarang" @click="currentIndex = {{ $index }}" 
                    :aria-current="currentIndex === {{ $index }} ? 'true' : 'false'"
                    :class="{'bg-[#B62127]': currentIndex === {{ $index }}, 'bg-gray-400': currentIndex !== {{ $index }}}"
                    class="w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full focus:outline-none focus:ring-2 focus:ring-red-400 transition-colors">
            </button>
            @endforeach
        </div>
    </div>

    <!-- Dynamic Highlight Sections -->
    @foreach($highlightSections as $section)
    <section id="{{ $section['type']->slug }}" class="py-8 md:py-12" aria-labelledby="{{ $section['type']->slug }}-heading">
        <!-- Banner Section for each highlight type -->
        @if($section['type']->banner_desktop || $section['type']->banner_mobile)
        <a href="{{ route('frontend.catalog.slug', $section['type']->slug) }}" class="block mb-6 md:mb-8 group">
            @if($section['type']->banner_desktop)
            <img src="{{ Storage::url($section['type']->banner_desktop) }}"
                 alt="{{ $section['type']->name }} Banner"
                 loading="lazy"
                 class="hidden md:block w-full h-auto rounded-lg shadow-md transition-transform duration-300">
            @endif
            @if($section['type']->banner_mobile)
            <img src="{{ Storage::url($section['type']->banner_mobile) }}"
                 alt="{{ $section['type']->name }} Banner"
                 loading="lazy"
                 class="block md:hidden w-full h-auto rounded-lg shadow-md transition-transform duration-300 group-hover:scale-[1.02]">
            @endif
        </a>
        @endif

        <div class="flex flex-row items-center justify-between mb-4">
            <h2 id="{{ $section['type']->slug }}-heading" class="text-2xl md:text-3xl font-bold text-gray-900">
                {{ $section['type']->name }}
            </h2>
            <a href="{{ route('frontend.catalog.slug', $section['type']->slug) }}"
               class="text-sm text-red-600 hover:text-red-700 font-medium focus:outline-none focus:underline">
               View All →
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6 items-stretch">
            @foreach($section['products'] as $product)
                <div class="h-full">
                    @include('frontend.catalog.partials.product-card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </section>
    @endforeach

    <!-- Cara Order -->
    <section class="py-12" aria-labelledby="caraorder-heading">
        <div class="container mx-auto">
            <h2 id="caraorder-heading" class="text-2xl md:text-3xl font-bold text-center mb-6">Cara Order</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="border rounded-xl p-6 shadow-sm hover:shadow-md transition focus-within:ring-2 focus-within:ring-red-300">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-red-700 text-white font-bold rounded-full">1</div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Pilih Produk Favoritmu</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Telusuri koleksi kami dan pilih model, ukuran, serta warna yang kamu suka. 
                        Klik tombol “Tambah ke Keranjang” atau langsung “Beli Sekarang”.
                    </p>
                </div>

                <div class="border rounded-xl p-6 shadow-sm hover:shadow-md transition focus-within:ring-2 focus-within:ring-red-300">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-red-700 text-white font-bold rounded-full">2</div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Isi Data & Checkout</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Masukkan nama, alamat pengiriman, dan metode pembayaran di halaman checkout. 
                        Pastikan semua data sudah benar agar pesananmu diproses dengan cepat.
                    </p>
                </div>

                <div class="border rounded-xl p-6 shadow-sm hover:shadow-md transition focus-within:ring-2 focus-within:ring-red-300">
                    <div class="flex items-center mb-4">
                        <div class="w-8 h-8 flex items-center justify-center bg-red-700 text-white font-bold rounded-full">3</div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Konfirmasi via WhatsApp</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Setelah klik “Pesan via WhatsApp”, tim kami akan segera mengonfirmasi dan memproses pesananmu.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    @if(count($testimonials) > 0)
    <section class="py-16"
             x-data="testimonialMarquee({{ json_encode($testimonials) }})"
             x-init="startAutoplay()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl md:text-3xl font-bold text-center mb-10">Testimonials</h2>
            
            <!-- Marquee Container -->
            <div class="relative overflow-hidden">
                <!-- Testimonial Track -->
                <div class="flex gap-4 sm:gap-6" 
                     :style="`transform: translateX(-${offset}px); transition: transform 0.1s linear;`"
                     @mouseenter="pause()" 
                     @mouseleave="resume()"
                     @touchstart="pause()"
                     @touchend="resume()">
                    
                    <!-- Loop testimonial cards (duplicated for seamless loop) -->
                    <template x-for="(item, index) in [...testimonials, ...testimonials]" :key="index">
                        <div class="flex-shrink-0 w-[280px] sm:w-[350px] lg:w-[400px]">
                            <div class="bg-teal-800 text-white rounded-xl p-4 sm:p-5 flex flex-col gap-3 sm:gap-4 h-full min-h-[180px] sm:min-h-[200px]">
                                <!-- User Info & Rating -->
                                <div class="flex gap-3">
                                    <img :src="item.image" 
                                         :alt="item.name" 
                                         class="w-12 h-12 sm:w-14 sm:h-14 rounded-md object-cover flex-shrink-0">
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-sm md:text-base truncate" x-text="item.name"></h3>
                                        
                                        <!-- Rating Stars -->
                                        <div class="flex space-x-1 mt-1">
                                            <template x-for="star in 5" :key="star">
                                                <svg xmlns="http://www.w3.org/2000/svg" 
                                                     viewBox="0 0 20 20" 
                                                     fill="currentColor"
                                                     :class="star <= item.rating ? 'text-yellow-400' : 'text-gray-400'" 
                                                     class="w-3.5 h-3.5 sm:w-4 sm:h-4">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.785.57-1.84-.197-1.54-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z" />
                                                </svg>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Testimonial Message -->
                                <p class="testi_message text-xs sm:text-sm leading-relaxed text-left opacity-90 line-clamp-4"  
                                   x-text="item.message"></p>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Alpine.js Script for Testimonial Marquee -->
    <script>
        function testimonialMarquee(testimonialData) {
            return {
                offset: 0,
                speed: 1,
                paused: false,
                testimonials: testimonialData,
                cardWidth: 280, // Default mobile width
                
                init() {
                    this.updateCardWidth();
                    window.addEventListener('resize', () => this.updateCardWidth());
                },
                
                updateCardWidth() {
                    // Responsive card width based on screen size
                    if (window.innerWidth >= 1024) {
                        this.cardWidth = 400; // lg
                    } else if (window.innerWidth >= 640) {
                        this.cardWidth = 350; // sm
                    } else {
                        this.cardWidth = 280; // mobile
                    }
                },
                
                startAutoplay() {
                    const step = () => {
                        if (!this.paused) {
                            this.offset += this.speed;
                            const gap = window.innerWidth >= 640 ? 24 : 16; // gap-6 or gap-4
                            const totalWidth = this.testimonials.length * (this.cardWidth + gap);
                            
                            if (this.offset >= totalWidth) {
                                this.offset = 0;
                            }
                        }
                        requestAnimationFrame(step);
                    };
                    requestAnimationFrame(step);
                },
                
                pause() {
                    this.paused = true;
                },
                
                resume() {
                    this.paused = false;
                }
            };
        }
    </script> 
    </main>
@endsection