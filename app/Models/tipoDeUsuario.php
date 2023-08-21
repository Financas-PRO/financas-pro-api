<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tipoDeUsuario extends Model
{
    protected $fillable = [
        'papel'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'ativo'
    ];

}
