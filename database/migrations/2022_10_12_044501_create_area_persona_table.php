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
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_persona');
            $table->boolean('estado')->default(1);
            $table->date('fecha');
            $table->foreign('id_persona')->references('id')->on('persona');
            $table->foreign('id_area')->references('id')->on('area');
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