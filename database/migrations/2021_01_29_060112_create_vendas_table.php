<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->float('valor');
            $table->string('status')->nullable();
            $table->unsignedBigInteger('id_cliente'); //id_cliente é uma foreign key
            $table->foreign('id_cliente')->references('id')->on('clientes'); //fazendo referencia do campo id_cliente a chave primaria da tabela clientes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendas');
    }
}
