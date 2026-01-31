<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'variant_size',
        'variant_color',
        'stock',
        'price_override',
    ];

    protected $casts = [
        'price_override' => 'decimal:2',
    ];

    /**
     * Relasi Many-to-One dengan Product.
     * Banyak varian milik satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}