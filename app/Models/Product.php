<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'type',
        'category_id',
        'description',
        'composition',
        'stock',
        'images',
        'model_3d',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->images ? asset('storage/' . $this->images) : null;
    }
}
