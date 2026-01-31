<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display shopping cart
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = Product::with('images')->find($item['product_id']);
            
            if ($product) {
                // Use variant price if exists, otherwise use base price
                $basePrice = $item['variant_price'] ?? $product->product_price;
                
                // Apply discount to the base price
                $price = $basePrice;
                if ($product->product_discount > 0) {
                    if ($product->discount_type === 'percentage') {
                        $price = $basePrice - ($basePrice * $product->product_discount / 100);
                    } else {
                        // Fixed discount
                        $price = max(0, $basePrice - $product->product_discount);
                    }
                }
                
                $subtotal = $price * $item['quantity'];
                $total += $subtotal;
                
                $cartItems[] = [
                    'id' => $id,
                    'product' => $product,
                    'variant_id' => $item['variant_id'] ?? null,
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $variant = null;
        $variantPrice = null;

        // Check if variant selected
        if ($request->variant_id) {
            $variant = ProductVariant::findOrFail($request->variant_id);
            
            // Check stock
            if ($variant->stock < $request->quantity) {
                return back()->with('error', '❌ Stok tidak cukup! Stok tersedia: ' . $variant->stock . ' item');
            }
            
            // Use variant price if exists
            $variantPrice = $variant->price_override ?? $product->product_price;
        } else {
            // If no variant selected but product has variants, show error
            $hasVariants = ProductVariant::where('product_id', $request->product_id)->exists();
            if ($hasVariants) {
                return back()->with('error', '⚠️ Silakan pilih ukuran dan warna terlebih dahulu!');
            }
        }

        // Create unique cart ID (product_id + variant_id if exists)
        $cartId = $request->product_id . '-' . ($request->variant_id ?? 'default');

        // Get cart from session
        $cart = session()->get('cart', []);

        // If item already exists in cart, update quantity
        if (isset($cart[$cartId])) {
            $cart[$cartId]['quantity'] += $request->quantity;
            $message = '✅ Produk berhasil ditambahkan! Jumlah di keranjang: ' . $cart[$cartId]['quantity'];
        } else {
            // Add new item to cart
            $cart[$cartId] = [
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'size' => $request->size,
                'color' => $request->color,
                'quantity' => $request->quantity,
                'variant_price' => $variantPrice,
            ];
            $message = '✅ Produk berhasil ditambahkan ke keranjang!';
        }

        // Save cart to session
        session()->put('cart', $cart);
        session()->save(); // Force save session before redirect

        return redirect()->route('frontend.cart.index')->with('success', $message);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            // Check stock if variant exists
            if ($cart[$id]['variant_id']) {
                $variant = ProductVariant::find($cart[$id]['variant_id']);
                if ($variant && $variant->stock < $request->quantity) {
                    return back()->with('error', '❌ Stok tidak cukup! Stok tersedia: ' . $variant->stock . ' item');
                }
            }

            $cart[$id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);
            session()->save(); // Force save session

            return back()->with('success', '✅ Jumlah produk berhasil diupdate!');
        }

        return back()->with('error', '❌ Produk tidak ditemukan di keranjang!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            session()->save(); // Force save session

            return back()->with('success', '✅ Produk berhasil dihapus dari keranjang!');
        }

        return back()->with('error', '❌ Produk tidak ditemukan di keranjang!');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', '✅ Keranjang berhasil dikosongkan!');
    }

    /**
     * Get cart count (for navbar badge)
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));
        
        return response()->json(['count' => $count]);
    }
}
