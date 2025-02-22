<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tienda extends Model
{
    use HasFactory;

    protected $table = 'tiendas'; 

    protected $fillable = ['nombre', 'vendedor_id'];

   
}
