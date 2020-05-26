<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
    * ObtÃ©m o Grupo da Conta.
    *
    * @return Grupo
    */
    public function grupo()
    {
        return $this->belongsTo('App\Grupo','grupo_id')->first();
    }
}
