<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nome', 'cpf', 'pagador_id'
    ];

    /**
    * Obtém o pagador
    *
    * @return Paciente
    */
    public function pagador()
    {
        return $this->belongsTo('App\Pagador','pagador_id')->first();
    }
}
