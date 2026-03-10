<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'genre',
        'release_date',
        'rating',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // НОВЫЙ МЕТОД
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}