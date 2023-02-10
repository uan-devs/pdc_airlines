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
        Schema::create('bilhete_lugares', function (Blueprint $table) {
            $table->id();   
            $table->unsignedBigInteger('id_bilhete');
            $table->unsignedBigInteger('id_voo_lugar');
            $table->string('tipo');
            $table->integer('estado')->default(1);
            $table->timestamps();
            $table->foreign('id_bilhete')->references('id')->on('bilhetes');
            $table->foreign('id_voo_lugar')->references('id')->on('voo_lugares'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bilhete_lugares');
    }
};
