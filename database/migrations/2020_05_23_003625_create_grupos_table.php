<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGruposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->timestamps();
        });

        Schema::table('contas', function (Blueprint $table) {
            $table->integer('grupo_id')->nullable()->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
        Schema::table('empresas', function (Blueprint $table) {
            $table->integer('grupo_id')->nullable()->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
        Schema::table('fornecedors', function (Blueprint $table) {
            $table->integer('grupo_id')->nullable()->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
        Schema::table('pacientes', function (Blueprint $table) {
            $table->integer('grupo_id')->nullable()->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
        Schema::table('tipos', function (Blueprint $table) {
            $table->integer('grupo_id')->nullable()->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('grupo_id')->nullable()->unsigned();
            $table->foreign('grupo_id')->references('id')->on('grupos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('grupos');
    }
}
