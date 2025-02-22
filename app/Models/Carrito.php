<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Carrito extends Model
{
    //cliente_id
    use HasFactory;

    protected $table = 'carritos'; 

    protected $fillable = ['cliente_id','carrito_id'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_compra')
                    ->withPivot('cantidad',  'carrito_id')
                    ->withTimestamps();
    }

}
