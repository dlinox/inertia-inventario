<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOficinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

  


        Schema::create('oficina', function (Blueprint $table) {
            $table->char('iduoper',15)->primary();
            $table->string('nombre',250)->nullable();//desuoper
            $table->string('dependencia',200)->nullable();
            $table->char('codigo',20)->nullable();
            $table->char('flag',1)->nullable();
            $table->string('dep1',200)->nullable();
            $table->string('dep2',200)->nullable();
            $table->string('dep',200)->nullable();
            $table->char('tipo',1)->default(1);
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
        Schema::dropIfExists('oficina');
    }
}
