<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_name',
        'order_contact',
        'order_email',
        'order_province',
        'order_city',
        'order_address',
        'order_post_code',
        'total_price',
        'status',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Relasi One-to-Many dengan OrderItem.
     * Satu order bisa memiliki banyak item.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}