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
        // Update existing 'user' values to 'customer'
        DB::table('users')->where('role', 'user')->update(['role' => 'customer']);
        
        // Change column to enum with new values
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['customer', 'admin', 'developer'])->default('customer')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->change();
        });
    }
};
