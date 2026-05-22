<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'table_number',
        'payment_method',
        'payment_status',
        'total_price',
        'status',
        'completed_at',
        'proof_of_payment',
        'cash',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'total_price' => 'decimal:2',
        'cash' => 'integer',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
