<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contum extends Model
{
    /**
     * Nome da tabela no Banco de Dados.
     *
     * @var string
     */
    protected $table = 'contas';

    /**
    * Obtém a User da Conta.
    *
    * @return User
    */
    public function user()
    {
        return $this->belongsTo('App\User','user_id')->first();
    }

    /**
    * Obtém a Paciente da Conta.
    *
    * @return Paciente
    */
    public function paciente()
    {
        return $this->belongsTo('App\Paciente','paciente_id')->first();
    }
    
}
