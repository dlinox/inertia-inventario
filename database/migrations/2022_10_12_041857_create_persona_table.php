<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persona', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('dni', 8);
            $table->string('paterno', 60)->nullable();
            $table->string('materno', 60)->nullable();
            $table->string('nombres', 80)->nullable();
            $table->char('idcondper', 1)->nullable();
            $table->string('email', 80)->nullable();
            $table->string('direccion', 80)->nullable();
            $table->string('telefono', 80)->nullable();
            $table->unsignedBigInteger('idtipope');
            $table->foreign('idtipope')->references('id')->on('tipo_persona');
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
        Schema::dropIfExists('persona');
    }
}
