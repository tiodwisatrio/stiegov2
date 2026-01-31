<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('images/stiego_icon.png') }}">
    <title>{{ config('app.name', 'Stiego') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50">

    <div class="min-h-screen flex flex-col sm:justify-center items-center px-4">
        <!-- Ganti logo Laravel -->
        <div class="mb-6">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo_stiego.png') }}" alt="Logo Stiego" class="w-24 h-auto mx-auto">
            </a>
        </div>

        <!-- Konten halaman (login/register/forgot password) -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-md overflow-hidden rounded-2xl">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
