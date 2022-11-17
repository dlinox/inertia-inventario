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
            $table->char('codigo', 12)->unique();
            $table->char('codigo_siga', 12)->nullable();
            $table->string('descripcion', 100);
            $table->string('modelo', 50);
            $table->string('marca', 50);
            $table->string('nro_serie', 30);

            $table->char('anio_fabricacion')->nullable(); //cambiar a date
            //$table->string('estado_actual', 20);
            $table->integer('nro_cargo_personal')->nullable();
            $table->date('fecha_cargo')->nullable();
            $table->integer('nro_orden')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->char('proveedor_ruc', 11)->nullable();
            $table->integer('nro_pecosa')->nullable();
            $table->date('fecha_pecosa')->nullable();
            $table->double('vida_util', 10, 6)->nullable();
            $table->date('fecha_vida_util')->nullable();
            $table->decimal('valor_adquisicion', 20, 6)->default(0);
            $table->double('valor_inicial', 10, 2)->nullable();
            $table->double('valor_depreciacion', 10, 2)->nullable();
            $table->date('fecha_baja_bien')->nullable();
            $table->string('clasificador', 15)->nullable();
            $table->char('sub_cta', 10)->nullable();
            $table->integer('mayor')->nullable();
            $table->string('observaciones', 150)->nullable();

            $table->string('tipo', 60)->nullable();
            $table->string('idbienk', 60)->nullable();
            $table->boolean('estado')->default(1); //bloqueado?

            //$table->integer('vida_util_empleada_meses')->nullable();

            $table->integer('idpersona_otro')->nullable();
            
            $table->unsignedBigInteger('id_persona');
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_estado');

            $table->foreign('id_persona')->references('id')->on('persona');
            //$table->foreign('idpersona_otro')->references('id')->on('persona');
            $table->foreign('id_area')->references('id')->on('area');
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
