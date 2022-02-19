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
        Schema::create('espaider_comarcas', function (Blueprint $table) {
            $table->id();
            $table->string('nome_comarca_espaider', 40);
            $table->string('espaider_uf_id', 2);
            $table->timestamps();

            $table->foreign('espaider_uf_id')->references('sigla')->on('espaider_ufs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('espaider_comarcas');
    }
};
