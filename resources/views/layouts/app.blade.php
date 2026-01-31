<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
      <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/stiego_icon.png') }}">
    
    <!-- TAMBAHKAN INI UNTUK GOOGLE SEARCH RESULTS -->
    <meta name="description" content="Ingin tampil stylish dengan pakaian yang trendy & kekinian? ; Pilih Produk Favoritmu. Telusuri koleksi kami dan pilih model, ukuran, serta warna yang kamu suka.">
    
    <!-- Open Graph Tags -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:description" content="Ingin tampil stylish dengan pakaian yang trendy & kekinian? ; Pilih Produk Favoritmu. Telusuri koleksi kami dan pilih model, ukuran, serta warna yang kamu suka.">
    <meta property="og:image" content="{{ asset('images/stiego_logo_large.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    
    <!-- Structured Data for Organization -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "{{ config('app.name') }}",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('images/stiego_icon.png') }}",
        "description": "Ingin tampil stylish dengan pakaian yang trendy & kekinian? ; Pilih Produk Favoritmu. Telusuri koleksi kami dan pilih model, ukuran, serta warna yang kamu suka."
    }
    </script>

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        {{-- Navbar --}}
        @include('layouts.partials.navbar')

        {{-- Page Heading --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')
    </div>
</body>
</html>
