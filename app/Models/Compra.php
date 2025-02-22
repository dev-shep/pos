<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $table = 'compras';

    protected $fillable = ['cliente_id', 'total'];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'producto_compra')
                    ->withPivot('cantidad', 'precio')
                    ->withTimestamps();
    }
}
