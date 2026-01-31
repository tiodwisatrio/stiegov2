<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\CatalogController;
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('frontend.home');
Route::get('/about', [AboutController::class, 'index'])->name('frontend.about');
Route::get('/catalog', [CatalogController::class, 'index'])->name('frontend.catalog.index');
Route::get('/catalog/{slug}', [CatalogController::class, 'bySlug'])->name('frontend.catalog.slug');
Route::get('/products', [ProductController::class, 'index'])->name('frontend.products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('frontend.products.show');
Route::get('/contact', [ContactController::class, 'index'])->name('frontend.contact');
Route::post('/contact', [ContactController::class, 'store'])->name('frontend.contact.store');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('frontend.cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('frontend.cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('frontend.cart.clear');
Route::get('/cart/count', [CartController::class, 'count'])->name('frontend.cart.count');

// Checkout Routes
Route::post('/checkout/whatsapp', [CheckoutController::class, 'whatsapp'])->name('frontend.checkout.whatsapp');