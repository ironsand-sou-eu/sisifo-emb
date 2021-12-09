<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogAlteracoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_alteracoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("campo_id");
            $table->timestamp("data_alteracao");
            $table->string("valor_anterior", 150);
            $table->string("valor_atual", 150);
            $table->timestamps();

            $table->foreign("campo_id")->references("id")->on("campos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_alteracoes');
    }
}
