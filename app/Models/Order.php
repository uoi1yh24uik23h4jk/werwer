<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Вспомогательный метод для получения игр через items
    public function games()
    {
        return $this->belongsToMany(Game::class, 'order_items')
            ->withPivot('quantity', 'price')
            ->withTimestamps();
    }
}