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
            $table->id();
            $table->string('tipo', 30)->nullable();

            $table->integer('idreg_anterior')->nullable();
            $table->string('cod_ubicacion', 30)->nullable();
            $table->string('id_area', 8)->nullable(); //01.01.1 //area.ofica.tipo_persona

            $table->string('cuenta', 25)->nullable();
            $table->string('codigo', 40)->nullable();
            $table->string('codigo_anterior', 40)->nullable();
            $table->string('descripcion', 200)->nullable();

            $table->string('estado', 4)->nullable();;
            $table->string('persona_dni', 8)->nullable();;

            $table->char('anio_adq', 4)->nullable(); //año adquisision
            $table->string('modelo', 150)->nullable();
            $table->string('marca', 150)->nullable();
            $table->string('nro_serie', 130)->nullable();
            $table->decimal('val_libros', 10, 6)->nullable();
            $table->decimal('dep_acum2019', 10, 6)->nullable();
            $table->string('medidas', 150)->nullable();
            $table->string('color', 150)->nullable();
            $table->string('observaciones', 250)->nullable();;
            $table->boolean('registrado')->default(0);


            /* $table->char('anio_fabricacion',4)->nullable(); //cambiar a date
            $table->string('estado_actual', 20);
            $table->integer('nro_cargo_personal');
            $table->date('fecha_cargo');
            $table->integer('nro_orden')->nullable();
            $table->date('fecha_compra')->nullable();
            $table->char('proveedor_ruc', 11)->nullable();
            $table->integer('nro_pecosa');
            $table->date('fecha_pecosa')->nullable();
            $table->double('vida_util', 10, 6)->nullable();
            $table->date('fecha_vida_util')->nullable();
            $table->decimal('valor_adquisicion', 20, 6)->default(0);
            $table->double('valor_inicial', 10, 2);
            $table->double('valor_depreciacion', 10, 2);
            $table->date('fecha_baja_bien')->nullable();
            $table->string('clasificador', 15);
            $table->char('sub_cta', 10);
            $table->integer('mayor');
            $table->char('codigo_siga', 15);*/

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
