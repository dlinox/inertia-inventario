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
            $table->bigIncrements('id');
            $table->char('codigo', 13)->unique();
            $table->char('codigo_anterior', 13);
            $table->string('nombre', 130);
            $table->string('modelo', 60);
            $table->string('numero', 60);
            $table->string('marca', 60)->default('Generico');
            $table->string('serie', 60);
            $table->string('tipo', 60)->nullable();
            $table->string('idbienk', 60);

            $table->char('nro_orden_compra', 5)->nullable();
            $table->date('fecha_orden_compra')->nullable();

            $table->char('fte_financiamiento', 2)->nullable();

            $table->char('nro_pecosa', 5)->nullable();
            $table->date('fecha_pecosa')->nullable();

            $table->integer('vida_util_meses')->nullable();
            $table->integer('vida_util_empleada_meses')->nullable();

            $table->double('valor_adquisicion', 10, 2)->nullable();
            $table->double('depreciacion_acumulada_2021', 10, 2)->nullable();
            $table->char('cuenta_contable', 15)->nullable();

            $table->char('anio_fabrica', 4)->nullable();
            //$table->char('estado', 2)->nullable();


            $table->boolean('estado')->default(1);
            $table->string('observaciones', 150);


            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('idpersona_otro');
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_estado');
            $table->unsignedBigInteger('id_area_persona')->nullable();

            $table->foreign('id_persona')->references('id')->on('persona');
            $table->foreign('idpersona_otro')->references('id')->on('persona');
            $table->foreign('id_area')->references('id')->on('area');
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_estado')->references('id')->on('estado');
            $table->foreign('id_area_persona')->references('id')->on('area_persona');

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
