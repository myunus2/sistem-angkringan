<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
    ];

    protected static function booted(): void
    {
        // Normalisasi jika ada payload yang masih memakai key `qty`.
        static::creating(function (self $model) {
            if (array_key_exists('qty', $model->getAttributes()) && !array_key_exists('quantity', $model->getAttributes())) {
                $model->quantity = $model->qty;
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
