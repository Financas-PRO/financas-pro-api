<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $with = ['tipoDeUsuario'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'username',
        'password',
        'email',
        'id_tipoDeUsuario'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        "id_tipoDeUsuario",
        'ativo'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function tipoDeUsuario()
    {
        return $this->hasOne(tipoDeUsuario::class, 'id', 'id_tipoDeUsuario');
    }

    public function findForPassport($username)
    {
        return $this->where('username', $username)->first();
    }
}
