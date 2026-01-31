<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
    
    
    
    
    
    <link rel="icon" type="image/png" href="{{ asset('images/stiego_icon.png') }}">

    <title>@yield('title', config('app.name', 'Stiego') . ' - Fashion Pria & Wanita')</title>
    <meta name="description" content="@yield('meta_description', 'Stiego menyediakan koleksi pakaian pria dan wanita dengan desain modern, kualitas premium, dan harga terjangkau. Belanja online sekarang!')">
    <meta name="keywords" content="stiego, pakaian pria, pakaian wanita, fashion, baju, celana, jaket, online shop, fashion pria, fashion wanita">
    <meta name="author" content="Stiego Indonesia">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', config('app.name', 'Stiego'))">
    <meta property="og:description" content="@yield('meta_description', 'Stiego menyediakan koleksi pakaian pria dan wanita dengan desain modern, kualitas premium, dan harga terjangkau.')">
    <meta property="og:image" content="{{ asset('images/stiego_logo_large.png') }}">
    <meta property="og:site_name" content="Stiego">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', config('app.name', 'Stiego'))">
    <meta name="twitter:description" content="@yield('meta_description', 'Stiego menyediakan koleksi pakaian pria dan wanita dengan desain modern, kualitas premium, dan harga terjangkau.')">
    <meta name="twitter:image" content="{{ asset('images/stiego_logo_large.png') }}">

    <!-- Structured Data - Organization -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "Organization",
        "name": "Stiego",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/stiego_icon.png') }}",
        "description": "Stiego menyediakan koleksi pakaian pria dan wanita dengan desain modern, kualitas premium, dan harga terjangkau.",
        "sameAs": [
            "https://instagram.com/stiego.id",
            "https://facebook.com/stiego.id"
        ],
        "contactPoint": {
            "@@type": "ContactPoint",
            "contactType": "customer service",
            "availableLanguage": "Indonesian"
        }
    }
    </script>

    <!-- Structured Data - WebSite with SearchAction -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "WebSite",
        "name": "Stiego",
        "url": "{{ url('/') }}",
        "potentialAction": {
            "@@type": "SearchAction",
            "target": "{{ url('/products') }}?search={search_term_string}",
            "query-input": "required name=search_term_string"
        }
    }
    </script>

    <!-- Structured Data - SiteNavigationElement -->
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@@type": "ItemList",
        "itemListElement": [
            {
                "@@type": "SiteNavigationElement",
                "position": 1,
                "name": "Home",
                "url": "{{ url('/') }}"
            },
            {
                "@@type": "SiteNavigationElement",
                "position": 2,
                "name": "Products",
                "url": "{{ url('/products') }}"
            },
            {
                "@@type": "SiteNavigationElement",
                "position": 3,
                "name": "Catalog",
                "url": "{{ url('/catalog') }}"
            },
            {
                "@@type": "SiteNavigationElement",
                "position": 4,
                "name": "About",
                "url": "{{ url('/about') }}"
            },
            {
                "@@type": "SiteNavigationElement",
                "position": 5,
                "name": "Contact",
                "url": "{{ url('/contact') }}"
            }
        ]
    }
    </script>

    @yield('structured_data')

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        @include('layouts.partials.frontend.navbar')
        
        <main class="px-4">
            @yield('content')
        </main>
        
        @include('layouts.partials.frontend.footer')
    </div>
    
    <!-- Toast Notification -->
    @include('components.toast-notification')
    
    @stack('scripts')
</body>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        const swiper = new Swiper('.bannerSwiper', {
            // Opsi konfigurasi
            loop: true, // Membuat slider berputar terus-menerus
            
            // Konfigurasi untuk dots/indikator
            pagination: {
                el: '.swiper-pagination', // Target elemen untuk dots
                clickable: true, // Membuat dots bisa diklik
            },

            // Konfigurasi untuk tombol navigasi (opsional)
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // Konfigurasi autoplay (opsional)
            autoplay: {
                delay: 3000, // Waktu perpindahan slide (dalam milidetik)
                disableOnInteraction: false, // Autoplay tidak berhenti saat user interaksi
            },
        });
    });
</script>
</html>