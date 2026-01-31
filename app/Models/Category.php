<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_slug',
        'parent_id',
    ];

    /**
     * Relasi One-to-Many dengan Product.
     * Satu kategori bisa memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Relasi ke parent category (kategori induk)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Relasi ke sub-categories (anak kategori)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Scope untuk hanya kategori utama (tanpa parent)
     */
    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Check apakah kategori ini adalah parent
     */
    public function isParent()
    {
        return $this->parent_id === null;
    }

    /**
     * Get semua sub-categories secara recursive
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }
}