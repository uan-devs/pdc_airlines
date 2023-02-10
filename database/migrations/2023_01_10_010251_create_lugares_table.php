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
        Schema::create('lugares', function (Blueprint $table) {
            $table->id();
            $table->string('numero');
            $table->integer('in_janela');
            $table->unsignedBigInteger('id_aviao');
            $table->unsignedBigInteger('id_fila');
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->foreign('id_aviao')->references('id')->on('avioes');
            $table->foreign('id_fila')->references('id')->on('filas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lugares');
    }
};
