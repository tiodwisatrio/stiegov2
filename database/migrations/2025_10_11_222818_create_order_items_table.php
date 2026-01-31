<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Relasi ke tabel products
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Relasi ke tabel product_variants. Bisa null jika suatu saat produk tidak punya varian.
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
            
            // Data historis untuk mencegah perubahan data produk memengaruhi record lama
            $table->string('product_name');
            $table->string('variant_size')->nullable();
            $table->string('variant_color')->nullable();
            $table->decimal('product_price', 10, 2);
            
            $table->integer('quantity');
            $table->decimal('subtotal', 10, 2);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};