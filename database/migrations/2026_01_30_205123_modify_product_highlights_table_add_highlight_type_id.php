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
        // Add temporary column first
        Schema::table('product_highlights', function (Blueprint $table) {
            $table->unsignedBigInteger('highlight_type_id')->nullable()->after('product_id');
        });

        // Migrate existing data from ENUM to foreign key
        $highlightTypeMap = [
            'featured' => 1,
            'best_seller' => 2,
            'hot_deals' => 3,
            'new_series' => 4,
        ];

        foreach ($highlightTypeMap as $enumValue => $typeId) {
            DB::table('product_highlights')
                ->where('highlight_type', $enumValue)
                ->update(['highlight_type_id' => $typeId]);
        }

        // Drop old ENUM column and add foreign key constraint
        Schema::table('product_highlights', function (Blueprint $table) {
            $table->dropColumn('highlight_type');
            $table->foreign('highlight_type_id')
                  ->references('id')
                  ->on('highlight_types')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_highlights', function (Blueprint $table) {
            $table->dropForeign(['highlight_type_id']);
            $table->enum('highlight_type', ['featured', 'best_seller', 'hot_deals', 'new_series'])->after('product_id');
        });

        // Migrate data back
        $highlightTypeMap = [
            1 => 'featured',
            2 => 'best_seller',
            3 => 'hot_deals',
            4 => 'new_series',
        ];

        foreach ($highlightTypeMap as $typeId => $enumValue) {
            DB::table('product_highlights')
                ->where('highlight_type_id', $typeId)
                ->update(['highlight_type' => $enumValue]);
        }

        Schema::table('product_highlights', function (Blueprint $table) {
            $table->dropColumn('highlight_type_id');
        });
    }
};
