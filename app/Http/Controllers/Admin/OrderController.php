<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()->with('items');

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by order number atau customer
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // $q->where('order_number', 'like', "%{$search}%")
                //   ->orWhere('customer_name', 'like', "%{$search}%")
                //   ->orWhere('customer_phone', 'like', "%{$search}%");

                // Jangan pakai order number
                $q->where('order_name', 'like', "%{$search}%")
                  ->orWhere('order_contact', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'items.variant');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
            'tracking_number' => 'nullable|string|max:100'
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pesanan berhasil diperbarui');
    }
}