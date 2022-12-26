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
        Schema::create('voos_lugares', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->integer('estado');
            $table->unsignedBigInteger('id_lugar');
            $table->unsignedBigInteger('id_voo_tarifa');
            $table->timestamps();
            $table->foreign('id_lugar')->references('id')->on('lugares');
            $table->foreign('id_voo_tarifa')->references('id')->on('voos_tarifas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voos_lugares');
    }
};
