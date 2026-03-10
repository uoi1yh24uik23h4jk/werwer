<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartItemsTable extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 8, 2); // цена на момент добавления
            $table->timestamps();
            
            // Уникальность - один товар может быть в корзине только один раз
            $table->unique(['user_id', 'game_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
}