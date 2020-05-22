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
    public function paciente_ou_fornecedor()
    {
        if($this->tipo == 1)
            return $this->belongsTo('App\Fornecedor','fornecedor_id')->first();
        else
            return $this->belongsTo('App\Paciente','paciente_id')->first();
    }

    /**
    * Obtém o Medico da Conta.
    *
    * @return Empresa
    */
    public function medico()
    {
        return $this->belongsTo('App\Empresa','empresa_id')->first();
    }

    /**
    * Obtém o Tipo da Conta.
    *
    * @return Tipo
    */
    public function tipo()
    {
        return $this->belongsTo('App\Tipo','tipo_id')->first();
    }

}
