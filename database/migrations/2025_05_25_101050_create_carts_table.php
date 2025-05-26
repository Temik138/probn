<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Связь с пользователями
            $table->string('session_id')->nullable()->unique(); // Для анонимных корзин
            $table->timestamps();

            $table->unique(['user_id']); // У каждого пользователя может быть только одна корзина
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};