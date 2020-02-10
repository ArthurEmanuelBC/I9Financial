<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFornecedorIdToConta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contas', function (Blueprint $table) {
            $table->integer('fornecedor_id')->nullable()->unsigned();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors');
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
