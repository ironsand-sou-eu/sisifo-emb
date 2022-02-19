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
        Schema::create('espaider_juizos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_juizo_espaider', 120)->unique();
            $table->string('slug', 120)->unique();
            $table->string('redacao_cabecalho_juizo', 150);
            $table->string('redacao_resumida_juizo', 60);
            $table->unsignedBigInteger('espaider_comarca_id');
            $table->unsignedBigInteger('espaider_orgao_id');
            $table->timestamps();

            $table->foreign('espaider_comarca_id')->references('id')->on('espaider_comarcas');
            $table->foreign('espaider_orgao_id')->references('id')->on('espaider_orgaos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('espaider_juizos');
    }
};
