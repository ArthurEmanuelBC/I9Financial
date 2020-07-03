<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTime;

class Empresa extends Model
{
    /**
    * Obtém a margem atual do médico.
    *
    * @return Decimal
    */
    public function margem_atual()
    {
        $mes = intval(date('m'));
        $data_fim = new DateTime();
        $margem = $this->margem * $mes;

        foreach(Contum::where('empresa_id', $this->id)->where('date','<=',$data_fim->format('Y-m-t'))->get() as $contum) {
            if($contum->tipo)
                $margem += $contum->valor;
            else
                $margem -= $contum->valor;
        }

        return $margem;
    }

    /**
    * Obtém a margem do médico de todos os meses no ano corrente.
    *
    * @return Array
    */
    public function margem_mensal()
    {
        $ano = date('Y');
        $margem = [];
        $meses = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $index = 0;

        foreach ($meses as $mes) {
            $data_inicio = "$ano-$mes-01";
            $data_fim = new DateTime($data_inicio);
            $margem["$mes/$ano"] = $this->margem;

            if($index > 0)
                $margem["$mes/$ano"] += $margem[$meses[$index-1]."/$ano"];

            foreach(Contum::where('empresa_id', $this->id)->whereBetween('date',[$data_inicio, $data_fim->format('Y-m-t')])->get() as $contum) {
                if($contum->tipo)
                    $margem["$mes/$ano"] += $contum->valor;
                else
                    $margem["$mes/$ano"] -= $contum->valor;
            }
            $index++;
        }

        return $margem;
    }
}
