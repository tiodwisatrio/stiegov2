<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_discount',
        'discount_type',
        'category_id',
        'is_archived',
        'archived_at',
    ];

    // Casting untuk memastikan tipe data benar
    protected $casts = [
        'product_price' => 'decimal:2',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    /**
     * Relasi Many-to-One dengan Category.
     * Banyak produk milik satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi One-to-Many dengan ProductVariant.
     * Satu produk bisa memiliki banyak varian.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Relasi One-to-Many dengan ProductImage.
     * Satu produk bisa memiliki banyak gambar.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Accessor untuk menghitung harga setelah diskon.
     * Mendukung diskon persentase (%) dan diskon nominal (Rp).
     */
    public function getProductPriceAfterDiscountAttribute()
    {
        if ($this->product_discount > 0) {
            if ($this->discount_type === 'percentage') {
                // Diskon persentase
                return $this->product_price - ($this->product_price * $this->product_discount / 100);
            } else {
                // Diskon fixed/nominal
                return max(0, $this->product_price - $this->product_discount);
            }
        }
        return $this->product_price;
    }

    /**
     * Accessor untuk mendapatkan persentase diskon.
     * Jika discount_type adalah 'percentage', return nilai discount.
     * Jika discount_type adalah 'fixed', hitung persentase dari nominal discount.
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->product_discount <= 0 || $this->product_price <= 0) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return round($this->product_discount, 0);
        } else {
            // Hitung persentase dari nominal discount
            $percentage = ($this->product_discount / $this->product_price) * 100;
            return round($percentage, 0);
        }
    }



    // Product Highlights relationship
    public function highlights()
    {
        return $this->hasMany(ProductHighlight::class);
    }

    public function activeHighlights()
    {
        return $this->hasMany(ProductHighlight::class)
                    ->where(function ($q) {
                        $q->whereNull('end_date')->orWhere('end_date', '>=', now());
                    });
    }

    /**
     * Scope untuk filter hanya produk yang aktif (tidak diarsip)
     */
    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    /**
     * Scope untuk filter hanya produk yang diarsip
     */
    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    /**
     * Arsipkan product
     */
    public function archive()
    {
        $this->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);
    }

    /**
     * Restore product dari arsip
     */
    public function restore()
    {
        $this->update([
            'is_archived' => false,
            'archived_at' => null,
        ]);
    }

    /**
     * Check apakah product diarsip
     */
    public function isArchived()
    {
        return $this->is_archived;
    }

    /**
     * Get total stock dari semua variants
     */
    public function getTotalStock()
    {
        return $this->variants()->sum('stock');
    }

    /**
     * Check apakah semua variant stock habis
     */
    public function isOutOfStock()
    {
        // Jika tidak ada variant sama sekali, anggap tidak out of stock
        if ($this->variants()->count() === 0) {
            return false;
        }

        // Cek apakah total stock = 0
        return $this->getTotalStock() === 0;
    }

    /**
     * Auto-archive product jika semua stock habis
     */
    public function autoArchiveIfOutOfStock()
    {
        if ($this->isOutOfStock() && !$this->is_archived) {
            $this->archive();
            return true;
        }
        return false;
    }

    /**
     * Auto-restore product jika ada stock lagi
     */
    public function autoRestoreIfHasStock()
    {
        if (!$this->isOutOfStock() && $this->is_archived) {
            $this->restore();
            return true;
        }
        return false;
    }
}