<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        // Get products to use in orders
        $products = Product::all();
        
        // Order 1 - Pending Order
        $order1 = Order::create([
            'order_name' => 'Ahmad Sofyan',
            'order_contact' => '081234567890',
            'order_email' => 'ahmad.sofyan@email.com',
            'order_province' => 'DKI Jakarta',
            'order_city' => 'Jakarta Selatan',
            'order_address' => 'Jl. Merdeka No. 123',
            'order_post_code' => '12345',
            'total_price' => 0,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        // Order 1 Items
        $product1 = Product::find(3); // BajuPP
        if ($product1) {
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $product1->id,
                'variant_id' => 11, // XL Red
                'variant_size' => 'XL',
                'variant_color' => 'red',
                'product_name' => $product1->product_name,
                'product_price' => $product1->product_price,
                'quantity' => 2,
                'subtotal' => $product1->product_price * 2
            ]);
            $order1->update(['total_price' => $product1->product_price * 2]);
        }

        // Order 2 - Processing Order
        $order2 = Order::create([
            'order_name' => 'Siti Aminah',
            'order_contact' => '087812345678',
            'order_email' => 'siti.aminah@email.com',
            'order_province' => 'Jawa Barat',
            'order_city' => 'Bandung',
            'order_address' => 'Jl. Sudirman No. 45',
            'order_post_code' => '40115',
            'total_price' => 0,
            'status' => 'processing',
            'created_at' => now()->subDays(1),
        ]);

        // Order 2 Items
        $product2 = Product::find(8); // Baju Muslimah
        if ($product2) {
            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $product2->id,
                'variant_id' => 18, // L Merah
                'variant_size' => 'L',
                'variant_color' => 'merah',
                'product_name' => $product2->product_name,
                'product_price' => $product2->product_price,
                'quantity' => 1,
                'subtotal' => $product2->product_price
            ]);
            $order2->update(['total_price' => $product2->product_price]);
        }

        // Order 3 - Delivered Order
        $order3 = Order::create([
            'order_name' => 'Budi Santoso',
            'order_contact' => '089876543210',
            'order_email' => 'budi.santoso@email.com',
            'order_province' => 'Jawa Timur',
            'order_city' => 'Surabaya',
            'order_address' => 'Jl. Diponegoro No. 78',
            'order_post_code' => '60175',
            'total_price' => 0,
            'status' => 'completed',
            'created_at' => now()->subDays(5),
        ]);

        // Order 3 Items - Multiple items
        $product3 = Product::find(9); // Baju Islop ajg
        $product4 = Product::find(11); // Baju Rocok
        
        if ($product3 && $product4) {
            $items3 = [
                [
                    'product' => $product3,
                    'variant_id' => 18, // L Merah
                    'variant_size' => 'L',
                    'variant_color' => 'merah',
                    'quantity' => 1
                ],
                [
                    'product' => $product4,
                    'variant_id' => 20, // M Hijau
                    'variant_size' => 'M',
                    'variant_color' => 'hijau',
                    'quantity' => 2
                ]
            ];

            $totalAmount3 = 0;
            foreach ($items3 as $item) {
                $subtotal = $item['product']->product_price * $item['quantity'];
                $totalAmount3 += $subtotal;
                
                OrderItem::create([
                    'order_id' => $order3->id,
                    'product_id' => $item['product']->id,
                    'variant_id' => $item['variant_id'],
                    'variant_size' => $item['variant_size'],
                    'variant_color' => $item['variant_color'],
                    'product_name' => $item['product']->product_name,
                    'product_price' => $item['product']->product_price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal
                ]);
            }
            $order3->update(['total_price' => $totalAmount3]);
        }
    }
}