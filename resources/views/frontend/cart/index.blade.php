@extends('layouts.frontend')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Shopping Cart</h1>
        </div>

        @if(count($cartItems) > 0)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

  <!-- Cart Items - Kiri -->
  <div class="space-y-3 sm:space-y-4">
    <h2 class="text-base sm:text-lg font-semibold text-gray-800">
      {{ count($cartItems) }} Produk di Keranjang
    </h2>

    @foreach ($cartItems as $item)
    <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between bg-white p-3 sm:p-4 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition">
      
      <!-- Remove Button X - Pojok Kanan Atas -->
      <form action="{{ route('frontend.cart.remove', $item['id']) }}" method="POST" 
            onsubmit="return confirm('Hapus item ini dari keranjang?')"
            class="absolute top-2 right-2 z-10">
        @csrf
        @method('DELETE')
        <button type="submit" class="w-5 h-5 sm:w-6 sm:h-6 flex items-center justify-center rounded-full hover:bg-red-100 text-gray-500 hover:text-red-600 transition text-sm sm:text-base">
          ✕
        </button>
      </form>

      <!-- Product Info -->
      <div class="flex items-start gap-3 sm:gap-4 pr-6 sm:pr-8 flex-1">
        <!-- Product Image -->
        <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-28 lg:h-28 rounded-md overflow-hidden bg-gray-100 flex-shrink-0">
          @if ($item['product']->images->first())
            <img 
              src="{{ Storage::url($item['product']->images->first()->image_path) }}" 
              alt="{{ $item['product']->product_name }}" 
              class="w-full h-full object-cover">
          @else
            <img src="/placeholder.png" class="w-full h-full object-cover" alt="No image">
          @endif
        </div>

        <!-- Product Details -->
        <div class="flex flex-col flex-1 min-w-0">
          <h3 class="font-semibold text-gray-900 text-sm sm:text-base line-clamp-2" 
              style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">
            {{ $item['product']->product_name }}
          </h3>
          @if($item['color'])
          <p class="text-xs sm:text-sm text-gray-500 mt-1">Warna: {{ ucfirst($item['color']) }}</p>
          @endif
          @if($item['size'])
          <p class="text-xs sm:text-sm text-gray-500">Ukuran: {{ strtoupper($item['size']) }}</p>
          @endif

          <!-- Quantity Selector -->
          <form action="{{ route('frontend.cart.update', $item['id']) }}" method="POST" class="flex items-center mt-2 sm:mt-3">
            @csrf
            @method('PUT')
            <button type="button" onclick="updateQuantity(this, 'decrease')" 
                    class="px-2 sm:px-3 py-0.5 sm:py-1 border border-gray-400 text-gray-900 rounded font-bold text-sm sm:text-base" 
                    style="flex-shrink: 0;">−</button>
            <input type="text" name="quantity" value="{{ $item['quantity'] }}" min="1" readonly 
                   class="text-center text-sm sm:text-base font-semibold text-gray-900" 
                   style="border: none; outline: none; width: 32px; background: transparent; -moz-appearance: textfield;">
            <button type="button" onclick="updateQuantity(this, 'increase')" 
                    class="px-2 sm:px-3 py-0.5 sm:py-1 border border-gray-400 text-gray-900 rounded font-bold text-sm sm:text-base" 
                    style="flex-shrink: 0;">+</button>
          </form>
        </div>
      </div>

      <!-- Price (Right Side on Desktop, Below on Mobile) -->
      <div class="flex items-center justify-between sm:justify-end mt-3 sm:mt-0 sm:ml-4 sm:flex-col sm:items-end">
        <div class="text-right">
          <span class="text-xs sm:text-sm text-gray-500 sm:hidden">Total: </span>
          <span class="font-semibold text-gray-800 text-base sm:text-lg lg:text-xl">
            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
          </span>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Summary - Kanan -->
  <div>
    <div class="bg-white p-4 sm:p-5 lg:p-6 rounded-xl shadow-sm border border-gray-200 lg:sticky lg:top-6">
      <h2 class="text-lg sm:text-xl font-bold text-gray-900 mb-4 sm:mb-6">Ringkasan Pesanan</h2>

      <div class="border-t border-gray-200 pt-3 sm:pt-4">
        <div class="flex justify-between items-center mb-2">
          <span class="text-sm sm:text-base text-gray-600">Total Item</span>
          <span class="text-sm sm:text-base font-medium">{{ count($cartItems) }}</span>
        </div>
        <div class="flex justify-between items-center">
          <span class="text-base sm:text-lg font-semibold text-gray-900">Total Harga</span>
          <span class="text-lg sm:text-xl font-bold text-red-600">
            Rp {{ number_format($total, 0, ',', '.') }}
          </span>
        </div>
      </div>

      <form action="{{ route('frontend.checkout.whatsapp') }}" method="POST" class="mt-4 sm:mt-6 space-y-3 sm:space-y-4">
        @csrf

        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Nama</label>
          <input type="text" name="name" required placeholder="Nama lengkap"
                 class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
        </div>

        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Contact / WhatsApp</label>
          <input type="text" name="phone" required placeholder="08xxx"
                 class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
        </div>

        <div class="grid grid-cols-2 gap-2 sm:gap-3">
          <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Provinsi</label>
            <input type="text" name="province" required placeholder="Provinsi"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
          </div>
          <div>
            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kota</label>
            <input type="text" name="city" required placeholder="Kota"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
          </div>
        </div>

        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
          <textarea name="address" required rows="3" placeholder="Alamat lengkap untuk pengiriman"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm"></textarea>
        </div>

        <div>
          <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
          <input type="text" name="postal_code" required placeholder="Kode Pos"
                 class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-red-500 focus:border-transparent text-sm">
        </div>

        <button type="submit"
                class="w-full py-2.5 sm:py-3 bg-red-600 text-white text-sm sm:text-base font-semibold rounded-md hover:bg-red-700 transition mt-3 sm:mt-4">
          Checkout
        </button>
      </form>

      <a href="{{ route('frontend.products.index') }}" class="block text-center mt-3 sm:mt-4 text-xs sm:text-sm text-gray-600 hover:text-red-600">
        ← Lanjut Belanja
      </a>
    </div>
  </div>

</div>
@else
<div class="text-center py-12 sm:py-16 text-gray-600">
  <h2 class="font-semibold text-3xl sm:text-4xl text-gray-900 mb-4">Ooops!</h2>
  <p class="text-sm sm:text-base mb-6">Keranjang masih kosong nih,<br /> yuk, belanja sekarang!</p>
  <a href="{{ route('frontend.products.index') }}" 
     class="inline-block text-white rounded-md px-5 sm:px-6 py-2 sm:py-2.5 bg-red-600 hover:bg-red-700 font-medium text-sm sm:text-base transition">
     Mulai Belanja →
  </a>
</div>
@endif

</div>
</div>

@push('scripts')
<script>
function updateQuantity(button, action) {
    const form = button.closest('form');
    const input = form.querySelector('input[name="quantity"]');
    let value = parseInt(input.value);
    
    if (action === 'increase') value++;
    else if (action === 'decrease' && value > 1) value--;
    
    input.value = value;
    form.submit();
}
</script>
@endpush
@endsection
