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
            $table->string('modelo', 60)->nullable();
            $table->string('marca', 60)->default('Generico');
            $table->string('serie', 60)->nullable();
                // $table->string('numero', 60)->nullable();
            $table->string('tipo', 60)->nullable(); //NULL
            $table->char('anio_fabricacion', 4)->nullable();
            $table->string('estado_actual', 15)->nullable();
            $table->string('nombre_ubicacion', 150 )->nullable();
            $table->char('dni', 9)->nullable();
            $table->string('nombres', 60)->nullable();
            $table->char('numero_cargo_personal', 12)->nullable();
            $table->date('fecha_cargo_personal')->nullable();
            $table->char('nro_orden_compra', 5)->nullable(); //PREGUNTAR
            $table->date('fecha_compra')->nullable(); //PREGUNTAR
            $table->char('datos_proveedor')->nullable();
            $table->integer('nro_pecosa')->nullable();
            $table->date('fecha_pecosa')->nullable();
            $table->double('vida_util_meses',10,6)->nullable();
            $table->date('fecha_vida_util')->nullable();
            $table->double('valor_adquisicion',15,6)->nullable();
            $table->double('valor_inicial',10,2)->nullable();

            $table->double('valor_depreciacion',10,2)->nullable();
            $table->date('fecha_baja_bien')->nullable();
            $table->string('clasificador',23);
            $table->char('sub_cuenta',6);
            $table->integer('mayor');
            $table->string('observaciones', 150)->nullable();

            // $table->char('fte_financiamiento', 2)->nullable(); //nuLO
            // $table->integer('vida_util_empleada_meses')->nullable();
            // $table->double('depreciacion_acumulada_2021', 10,2)->nullable();
            // $table->char('cuenta_contable', 15)->nullable();
            //Area ?/
            //  $table->string('nombre_ubicacion', 100)->nullable();
            //persona
            //    $table->integer('idpersona_otro')->nullable();
            //    $table->char('dni', 9)->nullable();
            //    $table->string('paterno', 60)->nullable();
            //    $table->string('materno', 60)->nullable();
            //    $table->string('nombres', 60)->nullable();
            //    $table->string('nro_celular', 60)->nullable();

            //proveedor
            // $table->char('ruc_proveedor', 11)->nullable();
            // $table->string('nombre_proveedor', 100)->nullable();

            // $table->unsignedBigInteger('id_persona');
            // $table->unsignedBigInteger('id_area');
            // $table->unsignedBigInteger('id_estado');
            // $table->foreign('id_persona')->references('id')->on('persona');
            // $table->foreign('id_area')->references('id')->on('area');
            // $table->foreign('id_estado')->references('id')->on('estado');

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
