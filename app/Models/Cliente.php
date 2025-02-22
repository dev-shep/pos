<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'clientes'; // Especificamos el nombre correcto de la tabla

    protected $fillable = ['nombre', 'correo', 'contraseña'];

    protected $hidden = ['contraseña'];
}
