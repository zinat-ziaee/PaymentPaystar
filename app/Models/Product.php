<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['amount'];

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_product');
    }
}
