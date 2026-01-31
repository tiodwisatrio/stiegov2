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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('banner_title');
            $table->string('banner_subtitle')->nullable();
            $table->text('banner_description')->nullable();
            $table->enum('banner_type', ['image', 'video'])->default('image');
            $table->string('banner_image')->nullable();
            $table->string('banner_video_url')->nullable();
            $table->string('banner_button_text')->nullable();
            $table->string('banner_button_link')->nullable();
            $table->string('banner_position')->nullable();
            $table->integer('banner_order')->default(0);
            $table->boolean('banner_status')->default(true);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
