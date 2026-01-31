@extends('layouts.frontend')

@section('title', $highlightType->name . ' - Catalog')

@section('content')
<!-- Banner Section -->
@if($highlightType->banner_desktop || $highlightType->banner_mobile)
<section class="mb-6 md:mb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($highlightType->banner_desktop)
        <img src="{{ Storage::url($highlightType->banner_desktop) }}"
             alt="{{ $highlightType->name }} Banner"
             class="hidden md:block w-full h-auto rounded-lg shadow-md">
        @endif
        @if($highlightType->banner_mobile)
        <img src="{{ Storage::url($highlightType->banner_mobile) }}"
             alt="{{ $highlightType->name }} Banner"
             class="block md:hidden w-full h-auto rounded-lg shadow-md">
        @endif
    </div>
</section>
@endif

<!-- Catalog Header -->
<div class="text-white py-8 sm:py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-3 text-gray-900">{{ $highlightType->name }}</h1>
        @if($highlightType->description)
        <p class="text-base sm:text-lg text-gray-600">
            {{ $highlightType->description }}
        </p>
        @endif
    </div>
</div>

<!-- Filter Tabs -->
<div class="sticky top-14 z-10 bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex space-x-4 sm:space-x-8 overflow-x-auto py-4 scrollbar-hide">
            <a href="{{ route('frontend.catalog.index') }}"
               class="whitespace-nowrap px-4 py-2 text-sm sm:text-base font-medium rounded-full transition
                      text-gray-600 hover:text-red-600 hover:bg-red-50">
                All Highlights
            </a>
            @foreach($highlightTypes as $type)
            <a href="{{ route('frontend.catalog.slug', $type->slug) }}"
               class="whitespace-nowrap px-4 py-2 text-sm sm:text-base font-medium rounded-full transition
                      {{ $type->id == $highlightType->id ? 'bg-red-600 text-white' : 'text-gray-600 hover:text-red-600 hover:bg-red-50' }}">
                {{ $type->name }}
            </a>
            @endforeach
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    
    @if($highlights->isEmpty())
        <!-- Empty State -->
        <div class="text-center py-16">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Produk katalog tidak ada</h3>
            <p class="mt-2 text-sm text-gray-500">Silahkan cari produk lainnya</p>
            <div class="mt-6">
                <a href="{{ route('frontend.catalog.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    Browse All Products
                </a>
            </div>
        </div>
    @else
        <!-- Products Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 items-stretch">
            @foreach($highlights as $highlight)
                <div class="h-full">
                    @include('frontend.catalog.partials.product-card', ['product' => $highlight->product])
                </div>
            @endforeach
        </div>
    @endif

</div>
@endsection
