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
        Schema::create('clientes_voos_lugares', function (Blueprint $table) {
            $table->id();
            $table->integer('estado');
            $table->unsignedBigInteger('id_voo_lugar');
            $table->unsignedBigInteger('id_compra');
            $table->unsignedBigInteger('id_cliente');
            $table->timestamps();
            $table->foreign('id_voo_lugar')->references('id')->on('voos_lugares');
            $table->foreign('id_compra')->references('id')->on('compras');
            $table->foreign('id_cliente')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes_voos_lugares');
    }
};
