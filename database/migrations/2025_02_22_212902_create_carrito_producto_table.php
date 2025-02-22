<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carrito_producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrito_id')->constrained('carritos');  // Relación con la tabla 'carritos'
            $table->foreignId('producto_id')->constrained('productos');  // Relación con la tabla 'productos'
            $table->integer('cantidad')->default(1);  // Cantidad del producto en el carrito
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrito_producto');
    }
};
