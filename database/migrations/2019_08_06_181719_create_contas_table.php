<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contas', function(Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('tipo_pagamento', 50);
            $table->string('num_doc', 11)->nullable();
            $table->integer('qtd_parcelas');
            $table->decimal('valor', 18, 2);
            $table->decimal('desconto', 18, 2);
            $table->decimal('pago', 18, 2);
            $table->text('descricao')->nullable();
            $table->string('cartao')->nullable();
            $table->string('fornecedor')->nullable();
            $table->boolean('tipo');
            $table->boolean('morto');
            $table->integer('user_id')->unsigned();
            $table->integer('paciente_id')->nullable()->unsigned();
            $table->integer('pai_id')->nullable()->unsigned();
            $table->integer('empresa_id')->nullable()->unsigned();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('pai_id')->references('id')->on('contas');
            $table->foreign('empresa_id')->references('id')->on('empresas');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contas');
	}

}
