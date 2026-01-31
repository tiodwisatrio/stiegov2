@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Order Details</h2>
        <a href="{{ route('admin.orders.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
            Back to Orders
        </a>
    </div>

    <!-- Order Info & Actions -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-wrap justify-between items-start">
            <div>
                <h3 class="text-lg font-medium">Order #{{ $order->order_number }}</h3>
                <p class="text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
            </div>
            
            <!-- Status Update Form -->
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-4">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Update Status
                </button>
            </form>
        </div>

        <!-- Tracking Number (if shipped) -->
        @if($order->status == 'shipped')
        <div class="mt-4">
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="flex gap-4">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="shipped">
                <input type="text" name="tracking_number" 
                    value="{{ $order->tracking_number }}"
                    placeholder="Enter tracking number"
                    class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                    Update Tracking
                </button>
            </form>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Customer Details -->
        <div class="md:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium mb-4">Customer Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600">Name</p>
                        <p class="font-medium">{{ $order->order_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Phone</p>
                        <p class="font-medium">{{ $order->order_contact }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">Email</p>
                        <p class="font-medium">{{ $order->order_email }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">Shipping Address</p>
                        <p class="font-medium">{{ $order->order_address }}</p>
                        <p class="font-medium">{{ $order->order_city }}</p>
                        <p class="font-medium">{{ $order->order_province }}</p>
                        <p class="font-medium">{{ $order->order_post_code }}</p>
                    </div>
                    @if($order->notes)
                    <div class="col-span-2">
                        <p class="text-sm text-gray-600">Notes</p>
                        <p class="font-medium">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-medium mb-4">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">Free</span>
                    </div>
                    <div class="pt-2 border-t flex justify-between">
                        <span class="font-medium">Total</span>
                        <span class="font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="mt-6 bg-white rounded-lg shadow-md overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                            @if($item->variant_info)
                                <div class="text-sm text-gray-500">{{ $item->variant_info }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($item->product_price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection