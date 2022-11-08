<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('area')->insert([
            'nombre' => 'BIBLIOTECA DE ING. ECONOMICA',
            'codigo'  => 'AR0001',
            'id_oficina' => 1,
        ]);
        DB::table('area')->insert([
            'nombre' => 'COORDINACION ACADEMICA DE ING. ECONÓMICA',
            'codigo'  => 'AR0002',
            'id_oficina' => 1,
        ]);
        DB::table('area')->insert([
            'nombre' => 'DIRECCION DE ING. ECONÓMICA',
            'codigo'  => 'AR0003',
            'id_oficina' => 1,
        ]);
        DB::table('area')->insert([
            'nombre' => 'BIBLIOTECA DE ING. ESTADISTICA',
            'codigo'  => 'AR0004',
            'id_oficina' => 2,
        ]);
        DB::table('area')->insert([
            'nombre' => 'SECRETARIA DE ING. ESTADISTICA',
            'codigo'  => 'AR0005',
            'id_oficina' => 2,
        ]);
        DB::table('area')->insert([
            'nombre' => 'DIRECCION ING. ESTADISTICA',
            'codigo'  => 'AR0006',
            'id_oficina' => 2,
        ]);
        DB::table('area')->insert([
            'nombre' => 'DIRECCION DE ING. DE SISTEMAS',
            'codigo'  => 'AR0007',
            'id_oficina' => 3,
        ]);
        DB::table('area')->insert([
            'nombre' => 'LABORATORIO 1 ING. SISTEMAS',
            'codigo'  => 'AR0008',
            'id_oficina' => 3,
        ]);
        DB::table('area')->insert([
            'nombre' => 'LABORATORIO 2 ING. SISTEMAS',
            'codigo'  => 'AR0009',
            'id_oficina' => 3,
        ]);
        DB::table('area')->insert([
            'nombre' => 'BIBLIOTECA DE ING. DE SISTEMAS',
            'codigo'  => 'AR0010',
            'id_oficina' => 3,
        ]);
        DB::table('area')->insert([
            'nombre' => 'OFICINA DE CONSEJERIA NUTRICIONAL',
            'codigo'  => 'AR0011',
            'id_oficina' => 4,
        ]);
        DB::table('area')->insert([
            'nombre' => 'CONSULTORIO CRED',
            'codigo'  => 'AR0012',
            'id_oficina' => 5,
        ]);
        DB::table('area')->insert([
            'nombre' => 'TRIAJE',
            'codigo'  => 'AR0013',
            'id_oficina' => 5,
        ]);
        DB::table('area')->insert([
            'nombre' => 'CONSUTORIO DE TUBERCULOSIS',
            'codigo'  => 'AR0014',
            'id_oficina' => 5,
        ]);
        DB::table('area')->insert([
            'nombre' => 'AREA DE INMUNIZACIONES',
            'codigo'  => 'AR0015',
            'id_oficina' => 5,
        ]);
        DB::table('area')->insert([
            'nombre' => 'TOPICO',
            'codigo'  => 'AR0016',
            'id_oficina' => 5,
        ]);
        DB::table('area')->insert([
            'nombre' => 'BIBLIOTECA DE SOCIOLOGÍA',
            'codigo'  => 'AR0017',
            'id_oficina' => 6,
        ]);
        DB::table('area')->insert([
            'nombre' => 'SECRETARIA DE SOCIOLOGÍA',
            'codigo'  => 'AR0018',
            'id_oficina' => 6,
        ]);
        DB::table('area')->insert([
            'nombre' => 'DIRECCION DE SOCIOLOGÍA',
            'codigo'  => 'AR0019',
            'id_oficina' => 6,
        ]);

    }
}
