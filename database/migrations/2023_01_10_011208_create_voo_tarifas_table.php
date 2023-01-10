<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voo_tarifas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tarifa');
            $table->unsignedBigInteger('id_voo');
            $table->double('preco');
            $table->integer('taxa_retorno');
            $table->timestamps();
            $table->foreign('id_tarifa')->references('id')->on('tarifas');
            $table->foreign('id_voo')->references('id')->on('voos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voo_tarifas');
    }
};
