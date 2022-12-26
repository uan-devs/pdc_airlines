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
            $table->string('origem');
            $table->string('destino');
            $table->date('data_partida');
            $table->integer('duracao_estimada');
            $table->time('hora');
            $table->unsignedBigInteger('id_aviao');
            $table->unsignedBigInteger('id_aeroporto');
            $table->timestamps();
            $table->foreign('id_aviao')->references('id')->on('avioes');
            $table->foreign('id_aeroporto')->references('id')->on('aeroportos');
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
