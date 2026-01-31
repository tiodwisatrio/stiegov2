<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
    ];

    protected $appends = ['url'];

    /**
     * Relasi Many-to-One dengan Product.
     * Banyak gambar milik satu produk.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the URL for the image
     */
    public function getUrlAttribute()
    {
        return $this->image_path ? Storage::url($this->image_path) : null;
    }

    /**
     * Delete the image file from storage when model is deleted
     */
    protected static function booted()
    {
        static::deleting(function ($image) {
            if ($image->image_path) {
                Storage::delete($image->image_path);
            }
        });
    }
}