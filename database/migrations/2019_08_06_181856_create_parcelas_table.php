<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParcelasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('parcelas', function(Blueprint $table) {
            $table->increments('id');
            $table->date('lancamento');
            $table->date('vencimento');
            $table->date('pagamento')->nullable();
            $table->date('recebimento')->nullable();
			$table->decimal('valor', 18, 2);
			$table->boolean('pago')->default(0);
            $table->text('observacao')->nullable();
            $table->integer('conta_id')->unsigned();
			$table->timestamps();
			
			$table->foreign('conta_id')->references('id')->on('contas')->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('parcelas');
	}

}
