<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveFieldsFromContasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contas', function (Blueprint $table) {
            $table->dropColumn('tipo_pagamento');
            $table->dropColumn('qtd_parcelas');
            $table->dropColumn('desconto');
            $table->dropColumn('pago');
            $table->dropColumn('cartao');
            $table->dropColumn('morto');
            $table->dropColumn('pai_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
