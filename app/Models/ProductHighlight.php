<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductHighlight extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'highlight_type_id',
        'priority',
        'start_date',
        'end_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function highlightType()
    {
        return $this->belongsTo(HighlightType::class);
    }
}
