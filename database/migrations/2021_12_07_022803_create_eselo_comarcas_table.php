<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEseloComarcasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eselo_comarcas', function (Blueprint $table) {
            $table->id();
            $table->string("nome_comarca_eselo", 40);
            $table->unsignedBigInteger("espaider_comarca_id");
            $table->timestamps();

            $table->foreign("espaider_comarca_id")->references("id")->on("espaider_comarcas");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('eselo_comarcas');
    }
}
