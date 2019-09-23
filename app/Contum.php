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
    
    /**
    * Obtém as Parcelas da Conta.
    *
    * @return Parcelas
    */
    public function parcelas()
    {
        return $this->hasMany('App\Parcela','conta_id');
    }
    
    /**
    * Obtém as Contas filho.
    *
    * @return Parcelas
    */
    public function contas()
    {
        return $this->hasMany('App\Contum','pai_id');
    }
    
    /**
    * Calcula o valor total da conta ($valor - $desconto).
    *
    * @return Decimal
    */
    public function total()
    {
        return $this->valor - $this->desconto;
    }
    
    /**
    * Verifica se a conta está paga
    *
    * @return boolean
    */
    public function isPago()
    {
        if($this->parcelas()->where("pago",false)->count()) return false;
        else return true;
    }

    /**
     * Eventos da Conta.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($conta) {
            Contum::where("pai_id",$conta->id)->delete();
        });
    }
}
