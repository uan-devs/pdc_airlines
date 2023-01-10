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
        Schema::create('papel_permissoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_papel");
            $table->unsignedBigInteger("id_permissao");
            $table->timestamps();
            $table->foreign("id_papel")->references("id")->on("papeis");
            $table->foreign("id_permissao")->references("id")->on("permissoes");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('papel_permissoes');
    }
};
