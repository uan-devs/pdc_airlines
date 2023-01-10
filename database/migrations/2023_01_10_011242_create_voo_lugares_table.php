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
        Schema::create('voo_lugares', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_voo_tarifa');
            $table->unsignedBigInteger('id_lugar');          
            $table->integer('estado')->default(0);
            $table->timestamps();
            $table->foreign('id_voo_tarifa')->references('id')->on('voo_tarifas');
            $table->foreign('id_lugar')->references('id')->on('lugares');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voo_lugares');
    }
};
