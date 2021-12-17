<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEspaiderUfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('espaider_ufs', function (Blueprint $table) {
            $table->string("sigla", 2);
            $table->string("nome_uf_espaider", 25)->unique();
            $table->timestamps();

            $table->primary("sigla");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('espaider_ufs');
    }
}
