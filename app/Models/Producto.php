<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
class Producto extends Model
{
      use HasFactory;

    protected $table = 'productos';

    protected $fillable = ['nombre', 'precio', 'stock', 'tienda_id'];

    public function tienda()
    {
        return $this->belongsTo(Tienda::class);
    }

    public function carritos()
    {
        return $this->belongsToMany(Carrito::class, 'producto_compra')
                    ->withPivot('cantidad', 'precio', 'carrito_id')
                    ->withTimestamps();
    }
}
