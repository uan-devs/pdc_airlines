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
        Schema::create('tarifas_regalias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_tarifa");
            $table->unsignedBigInteger("id_regalia");
            $table->timestamps();
            $table->foreign("id_tarifa")->references("id")->on("tarifas");
            $table->foreign("id_regalia")->references("id")->on("regalias");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tarifas_regalias');
    }
};
