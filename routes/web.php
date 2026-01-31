<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\HighlightTypeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductHighlightController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\TestimonialsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
require __DIR__.'/frontend.php';



Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.dashboard');




Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('admin/categories', App\Http\Controllers\Admin\CategoryController::class)->names('admin.categories');
    Route::resource('admin/products', App\Http\Controllers\Admin\ProductController::class)->names('admin.products');

    // Product Archive/Restore Routes
    Route::post('admin/products/{product}/archive', [App\Http\Controllers\Admin\ProductController::class, 'archive'])
        ->name('admin.products.archive');
    Route::post('admin/products/{product}/restore', [App\Http\Controllers\Admin\ProductController::class, 'restore'])
        ->name('admin.products.restore');

    // API endpoint untuk mendapatkan sub-categories
    Route::get('admin/categories/{parent}/subcategories', [App\Http\Controllers\Admin\ProductController::class, 'getSubCategories'])
        ->name('admin.categories.subcategories');
    
    Route::resource('admin/orders', App\Http\Controllers\Admin\OrderController::class)->names('admin.orders');
    Route::patch('admin/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::delete('admin/products/image/{id}', [ProductImageController::class, 'destroy'])->name('admin.products.image.destroy');
    Route::patch('admin/orders/{order}/status', [App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::resource('admin/testimonials', TestimonialsController::class)->names('admin.testimonials');
    Route::resource('admin/banners', BannerController::class)->names('admin.banners');
    Route::resource('admin/highlights', ProductHighlightController::class)->names('admin.highlights');
    Route::resource('admin/highlight-types', HighlightTypeController::class)->names('admin.highlight-types');
    
    // User Management (Admin can manage customers, Developer can manage all)
    Route::resource('admin/users', App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    
    // Admin Profile Management
    Route::get('admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('admin/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
    Route::patch('admin/profile/password', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('admin.profile.password');
});


// Route::delete('product-images/{id}', [ProductController::class, 'destroyImage'])->name('product-images.destroy');
// Route::delete('/product-images/{id}', [ProductImageController::class, 'destroy'])->name('admin.product-images.destroy');





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
