<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAreaPersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('area_persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo',40);
            $table->string('url',150);
            $table->boolean('estado')->default(1);
            $table->date('fecha');
            $table->unsignedBigInteger('id_usuario');
            $table->char('id_area',15);
            $table->unsignedBigInteger('id_persona');
            $table->foreign('id_persona')->references('id')->on('persona');
            $table->foreign('id_area')->references('iduoper')->on('oficina');
            $table->foreign('id_usuario')->references('id')->on('users');
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
        Schema::dropIfExists('area_persona');
    }
}
