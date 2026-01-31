<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HighlightType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'banner_desktop',
        'banner_mobile',
        'is_active',
        'display_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug from name
        static::creating(function ($highlightType) {
            if (empty($highlightType->slug)) {
                $highlightType->slug = Str::slug($highlightType->name);
            }
        });

        static::updating(function ($highlightType) {
            if ($highlightType->isDirty('name') && empty($highlightType->slug)) {
                $highlightType->slug = Str::slug($highlightType->name);
            }
        });
    }

    public function productHighlights()
    {
        return $this->hasMany(ProductHighlight::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order');
    }
}
