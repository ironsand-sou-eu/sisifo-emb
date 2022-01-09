<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nome_completo', 100);
            $table->string('nome_escolhido', 50)->nullable();
            $table->unsignedBigInteger('genero_declarado_id');
            $table->string('email', 70)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean("ativo");
            $table->string('avatar_path')->nullable();
            $table->timestamps();

            $table->foreign('genero_declarado_id')->references("id")->on("generos");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
