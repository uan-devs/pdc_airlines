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
        Schema::create('escalas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aeroporto');
            $table->unsignedBigInteger('id_voo');
            $table->timestamps();
            $table->foreign('id_aeroporto')->references('id')->on('aeroportos');
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
        Schema::dropIfExists('escalas');
    }
};
