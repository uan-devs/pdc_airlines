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
        Schema::create('regalias_tarifas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_regalia');
            $table->unsignedBigInteger('id_tarifa');
            $table->integer('estado')->default(1);
            $table->foreign('id_regalia')->references('id')->on('regalias');
            $table->foreign('id_tarifa')->references('id')->on('tarifas');
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
        Schema::dropIfExists('regalias_tarifas');
    }
};
