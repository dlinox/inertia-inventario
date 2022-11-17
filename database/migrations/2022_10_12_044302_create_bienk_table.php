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
            $table->char('codigo', 12)->unique();
            $table->char('codigo_siga', 12);
            $table->string('descripcion', 100)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->string('marca', 50)->nullable();
            $table->string('nro_serie', 30)->nullable();
            $table->char('anio_fabricacion')->nullable(); //cambiar a date
            $table->string('estado_actual', 20);
            $table->integer('id_area');
            $table->char('persona_dni', 8);
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
            $table->string('observaciones', 150);
            $table->boolean('registrado')->default(0);
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
