<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Especificamos el nombre correcto de la tabla

    protected $fillable = ['nombre', 'correo', 'contraseña'];

    protected $hidden = ['contraseña'];
}
