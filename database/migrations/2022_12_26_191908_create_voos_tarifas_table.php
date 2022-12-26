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
        Schema::create('voos_tarifas', function (Blueprint $table) {
            $table->id();
            $table->float('preco');
            $table->unsignedBigInteger('id_voo');
            $table->unsignedBigInteger('id_tarifa');
            $table->timestamps();
            $table->foreign('id_voo')->references('id')->on('voos');
            $table->foreign('id_tarifa')->references('id')->on('tarifas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voos_tarifas');
    }
};
