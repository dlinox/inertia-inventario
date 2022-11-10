<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBienkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bienk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('codigo', 13)->unique();
            $table->char('codigo_anterior', 13);
            $table->string('nombre', 150);
            $table->string('marca', 60)->default('Generico');
            $table->string('modelo', 60)->nullable();
            $table->string('serie', 60)->nullable();
            $table->string('numero', 60)->nullable();
            $table->string('tipo', 60)->nullable();
            $table->string('observaciones', 150)->nullable();
            $table->char('nro_orden_compra', 5)->nullable();
            $table->date('fecha_orden_compra')->nullable();
            $table->char('fte_financiamiento', 2)->nullable();
            $table->char('nro_pecosa', 5)->nullable();
            $table->date('fecha_pecosa')->nullable();
            $table->integer('vida_util_meses')->nullable();
            $table->integer('vida_util_empleada_meses')->nullable();
            $table->double('valor_adquisicion', 10,2)->nullable();
            $table->double('depreciacion_acumulada_2021', 10,2)->nullable();
            $table->char('cuenta_contable', 15)->nullable();
            $table->char('anio_fabrica', 4)->nullable();
            $table->char('estado', 2)->nullable();
            //Area ?
            $table->char('codigo_ubicacion', 5)->nullable();
            $table->string('nombre_ubicacion', 100)->nullable();
            //persona
            $table->integer('idpersona_otro')->nullable();
            $table->char('dni', 9)->nullable();
            $table->string('paterno', 60)->nullable();
            $table->string('materno', 60)->nullable();
            $table->string('nombres', 60)->nullable();
            $table->string('nro_celular', 60)->nullable();

            $table->char('numero_cargo_personal', 5)->nullable();
            $table->date('fecha_cargo_personal')->nullable();

            //proveedor
            $table->char('ruc_proveedor', 11)->nullable();
            $table->string('nombre_proveedor', 100)->nullable();

            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_estado');
            $table->foreign('id_persona')->references('id')->on('persona');
            $table->foreign('id_area')->references('id')->on('area');
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
        Schema::dropIfExists('bienk');
    }
}
