<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estado')->insert([
            'nombre' => 'Nuevo',
            'codigo' => 'B',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'Regular',
            'codigo' => 'R',
        ]);

        DB::table('estado')->insert([
            'nombre' => 'Bueno',
            'codigo' => 'B',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'Malo',
            'codigo' => 'M',
        ]);

        DB::table('estado')->insert([
            'nombre' => 'Chatarra',
            'codigo' => 'Y',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'RAEE',
            'codigo' => 'RAEE',//CAMBIAR TIPO
        ]);
    }
}
