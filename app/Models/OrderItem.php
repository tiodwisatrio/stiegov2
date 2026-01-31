<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'variant_id',
        'product_name',
        'variant_size',
        'variant_color',
        'product_price',
        'quantity',
        'subtotal',
    ];

    protected $casts = [
        'product_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relasi Many-to-One dengan Order.
     * Banyak item milik satu order.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Relasi Many-to-One dengan Product.
     * Banyak item merujuk ke satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relasi Many-to-One dengan ProductVariant.
     * Banyak item merujuk ke satu varian produk.
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}