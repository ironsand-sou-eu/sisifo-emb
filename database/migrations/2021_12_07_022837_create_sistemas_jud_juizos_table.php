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
        Schema::create('sistemas_jud_juizos', function (Blueprint $table) {
            $table->id();
            $table->string('nome_juizo_sistemas_jud', 120)->unique();
            $table->unsignedBigInteger('espaider_juizo_id');
            $table->timestamps();

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
        Schema::dropIfExists('sistemas_jud_juizos');
    }
};
