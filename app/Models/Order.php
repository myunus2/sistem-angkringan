<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
   protected $fillable = [
    'customer_name',
    'phone',          // Tambahkan ini agar nomor HP tersimpan
    'table_number',
    'notes',          // Tambahkan ini agar catatan opsional tersimpan
    'payment_method',
    'payment_status',
    'total_price',
    'status',
    'order_type',
    'completed_at',
    'proof_of_payment',
    'cash',
    'snap_token',
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
