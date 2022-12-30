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
        Schema::create('voos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aeroporto_origem');
            $table->unsignedBigInteger('id_aeroporto_destino');
            $table->date('data_partida');
            $table->time('hora');
            $table->integer('duracao_estimada');
            $table->unsignedBigInteger('id_aviao');
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->foreign('id_aeroporto_origem')->references('id')->on('aeroportos');
            $table->foreign('id_aeroporto_destino')->references('id')->on('aeroportos');
            $table->foreign('id_aviao')->references('id')->on('avioes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voos');
    }
};
