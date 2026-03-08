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
        'total_price',
        'status',
        'proof_of_payment'
    ];

    // Eager load relations by default
    protected $with = ['items.product'];

    /**
     * Get the order items for this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
