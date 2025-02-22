<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Vendedor extends Model
{
    use  HasFactory;

    protected $table = 'vendedores';

    protected $fillable = ['nombre', 'correo', 'contraseña'];

    protected $hidden = ['contraseña'];
}
