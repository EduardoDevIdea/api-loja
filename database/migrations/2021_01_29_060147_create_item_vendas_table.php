<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemVendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_vendas', function (Blueprint $table) {
            $table->id();
            $table->float('preco');
            $table->unsignedBigInteger('id_produto'); //foreign key id_produto
            $table->unsignedBigInteger('id_venda'); //foreign key id_venda
            $table->foreign('id_produto')->references('id')->on('produtos'); //referenciando campo id_produto a chave primaria da tabela produtos
            $table->foreign('id_venda')->references('id')->on('vendas'); //referenciando o campo id_vena a chave primaria da tabela vendas
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
        Schema::dropIfExists('item_vendas');
    }
}
