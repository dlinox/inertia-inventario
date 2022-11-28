<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TipoPersonaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_persona')->insert([
            'id' => '',
            'nombre' => ' ',
        ]);
        DB::table('tipo_persona')->insert([
            'id' => 1,
            'nombre' => 'DOCENTE',
        ]);
        DB::table('tipo_persona')->insert([
            'id' => 2,
            'nombre' => 'ADMINISTRATIVO',
        ]);
        DB::table('tipo_persona')->insert([
            'id' => 3,
            'nombre' => 'CAS',
        ]);
    }
}
