<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {




        Schema::create('inventario', function (Blueprint $table) {

            $table->id();
            
            $table->string('tipo', 30)->nullable();
            $table->integer('idreg_anterior')->nullable();
            $table->string('cod_ubicacion', 30)->nullable();
           

            $table->string('cuenta', 25)->nullable();
            $table->string('codigo', 40)->nullable();
            $table->string('codigo_anterior', 40)->nullable();
            $table->string('descripcion', 200)->nullable();

            $table->char('anio_adq', 4)->nullable(); //año adquisision
            $table->string('modelo', 150)->nullable();
            $table->string('marca', 150)->nullable();
            $table->string('nro_serie', 130)->nullable();
            $table->decimal('val_libros', 10, 6)->nullable();
            $table->decimal('dep_acum2019', 10, 6)->nullable();
            $table->string('medidas', 150)->nullable();
            $table->string('color', 150)->nullable();
            $table->string('observaciones', 250)->nullable();;

        
            $table->string('idbienk', 60)->nullable();
            $table->boolean('estado')->default(1); //bloqueado?
            //$table->integer('vida_util_empleada_meses')->nullable();
            $table->integer('idpersona_otro')->nullable();
        
            $table->unsignedBigInteger('id_persona');
          
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->unsignedBigInteger('id_estado')->nullable();
            $table->char('id_area',15)->nullable();

            $table->foreign('id_persona')->references('id')->on('persona');
            //$table->foreign('idpersona_otro')->references('id')->on('persona');
            $table->foreign('id_area')->references('iduoper')->on('oficina');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_estado')->references('id')->on('estado');

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
        Schema::dropIfExists('inventario');
    }
}
