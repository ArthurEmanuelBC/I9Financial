<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagador extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'cpf'
    ];

    /**
     * Get the time record associated with the user.
     */
    public function paciente()
    {
        return $this->hasOne('App\Paciente')->first();
    }
}
