<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Aluno extends Model
{
    protected $with = ['user'];

    protected $fillable = [
        'nome',
        'ra',
        'id_usuario'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
