<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Docente extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'nome',
        'titulacao',
        'rg',
        'cpf',
        'id_usuario',
        'telefone'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
