<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('codigo');
            $table->string('url');
            $table->integer('tipo');
            $table->unsignedBigInteger('id_area_persona')->nullable();
            $table->string('dni',8)->nullable();
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->string('Observacion',190)->nullable();
            $table->timestamps();
            $table->foreign('id_area_persona')->references('id')->on('area_persona');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_area')->references('id')->on('area');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documentos');
    }
}
