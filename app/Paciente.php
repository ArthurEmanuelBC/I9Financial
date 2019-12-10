<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    /**
    * Obtém o pagador
    *
    * @return Paciente
    */
    public function pagador()
    {
        return $this->belongsTo('App\Paciente','pagador_id')->first();
    }
}
