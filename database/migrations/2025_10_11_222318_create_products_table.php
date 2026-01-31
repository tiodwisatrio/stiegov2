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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('product_description');
            $table->decimal('product_price', 10, 2); // 10 digit total, 2 digit di belakang koma
            $table->integer('product_discount')->default(0); // Diskon dalam persen
            // $table->integer('product_stock')->default(0);
            
            // Kolom ini bisa dihapus harganya dihitung di Model (Accessor)
            $table->decimal('product_price_after_discount', 10, 2)->nullable(); 
            
            // Relasi ke tabel categories
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};