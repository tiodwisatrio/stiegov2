<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function whatsapp(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ]);

        // Get cart from session
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('frontend.cart.index')
                ->with('error', 'Your cart is empty');
        }

        // Calculate total and prepare items
        $total = 0;
        $items = [];
        $orderItemsData = [];
        
        foreach ($cart as $id => $item) {
            $product = Product::find($item['product_id']);
            if (!$product) continue;

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

            // For WhatsApp message
            $items[] = [
                'name' => $product->product_name,
                'size' => $item['size'] ?? '-',
                'color' => $item['color'] ?? '-',
                'quantity' => $item['quantity'],
                'price' => $price,
                'subtotal' => $subtotal,
            ];

            // For database
            $orderItemsData[] = [
                'product_id' => $product->id,
                'variant_id' => $item['variant_id'] ?? null,
                'product_name' => $product->product_name,
                'variant_size' => $item['size'] ?? null,
                'variant_color' => $item['color'] ?? null,
                'product_price' => $price,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal,
            ];
        }

        // Save order to database using transaction
        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'order_name' => $validated['name'],
                'order_contact' => $validated['phone'],
                'order_email' => null, // Optional, bisa ditambahkan ke form jika perlu
                'order_province' => $validated['province'],
                'order_city' => $validated['city'],
                'order_address' => $validated['address'],
                'order_post_code' => $validated['postal_code'],
                'total_price' => $total,
                'status' => 'pending', // Status awal: pending
            ]);

            // Create order items
            foreach ($orderItemsData as $itemData) {
                $order->items()->create($itemData);
            }

            // Update stock (reduce)
            foreach ($cart as $item) {
                if (isset($item['variant_id'])) {
                    $variant = ProductVariant::find($item['variant_id']);
                    if ($variant) {
                        $variant->decrement('stock', $item['quantity']);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('frontend.cart.index')
                ->with('error', 'Gagal menyimpan pesanan: ' . $e->getMessage());
        }

        // Generate WhatsApp message
        $orderNumber = str_pad($order->id, 6, '0', STR_PAD_LEFT);
        $message = "*PEMESANAN BARU #$orderNumber*\n\n";
        $message .= "*Data Customer:*\n";
        $message .= "Nama: {$validated['name']}\n";
        $message .= "No. HP/WhatsApp: {$validated['phone']}\n";
        $message .= "Provinsi: {$validated['province']}\n";
        $message .= "Kota: {$validated['city']}\n";
        $message .= "Alamat: {$validated['address']}\n";
        $message .= "Kode Pos: {$validated['postal_code']}\n\n";
        
        $message .= "*Detail Pesanan:*\n";
        foreach ($items as $index => $item) {
            $message .= ($index + 1) . ". {$item['name']}\n";
            $message .= "   Ukuran: {$item['size']}\n";
            $message .= "   Warna: {$item['color']}\n";
            $message .= "   Qty: {$item['quantity']} x Rp " . number_format($item['price'], 0, ',', '.') . "\n";
            $message .= "   Subtotal: Rp " . number_format($item['subtotal'], 0, ',', '.') . "\n\n";
        }
        
        $message .= "*Total: Rp " . number_format($total, 0, ',', '.') . "*\n\n";
        $message .= "Mohon konfirmasi pesanan ini. Terima kasih! 🙏";

        // WhatsApp business number (change this to your actual number)
        // $whatsappNumber = '6289527668283'; 
        $whatsappNumber = '6288972061745'; 
        
        // URL encode the message
        $encodedMessage = urlencode($message);
        
        // Generate WhatsApp URL
        $whatsappUrl = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";

        // Clear cart after checkout
        session()->forget('cart');

        // Redirect to WhatsApp with success message in session
        return redirect()->away($whatsappUrl);
    }
}
