<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Parcela extends Model
{
    /**
    * Obtém a Contum da Conta.
    *
    * @return Contum
    */
    public function conta()
    {
        return $this->belongsTo('App\Contum','conta_id')->first();
    }
}
