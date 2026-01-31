<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('highlight_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('banner_desktop')->nullable();
            $table->string('banner_mobile')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);
            $table->timestamps();
        });

        // Insert default highlight types
        DB::table('highlight_types')->insert([
            [
                'name' => 'Featured',
                'slug' => 'featured',
                'description' => 'Produk unggulan pilihan kami',
                'is_active' => true,
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Best Seller',
                'slug' => 'best_seller',
                'description' => 'Produk terlaris dan paling banyak dibeli',
                'is_active' => true,
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hot Deals',
                'slug' => 'hot_deals',
                'description' => 'Penawaran spesial dengan harga terbaik',
                'is_active' => true,
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'New Series',
                'slug' => 'new_series',
                'description' => 'Koleksi terbaru dari Stiego',
                'is_active' => true,
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlight_types');
    }
};
