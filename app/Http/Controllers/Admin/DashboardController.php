<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all orders for status counting
        $orders = Order::all();
        
        $stats = [
            'total_products' => Product::count(),
            'total_categories' => Category::count(),
            'total_orders' => $orders->count(),
            'pending_orders' => $orders->where('status', 'pending')->count(),
            'processing_orders' => $orders->where('status', 'processing')->count(),
            'completed_orders' => $orders->where('status', 'completed')->count(),
            'total_revenue' => $orders->sum('total_price'),
            'recent_orders' => Order::with('items')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats', 'orders'));
    }
}