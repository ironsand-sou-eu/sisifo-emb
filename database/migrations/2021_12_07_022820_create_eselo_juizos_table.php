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
        Schema::create('eselo_juizos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_juizo_eselo', 150);
            $table->unsignedBigInteger('eselo_comarca_id');
            $table->unsignedBigInteger('espaider_juizo_id');
            $table->timestamps();

            $table->foreign('eselo_comarca_id')->references('id')->on('eselo_comarcas');
            $table->foreign('espaider_juizo_id')->references('id')->on('espaider_juizos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eselo_juizos');
    }
};
