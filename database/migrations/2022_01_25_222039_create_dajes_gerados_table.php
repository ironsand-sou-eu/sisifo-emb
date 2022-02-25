<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dajes_gerados', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 20)->unique();
            $table->string('processo', 30);
            $table->string('parte_adversa', 120);
            $table->float('valor', 20, 2, true);
            $table->date('emissao');
            $table->date('vencimento');
            $table->string('tipo', 50);
            $table->integer('qtd_atos', false, true);
            $table->string('eventos_atos', 150)->nullable();
            $table->string('gerencia', 5);
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
        Schema::dropIfExists('dajes_gerados');
    }
};
