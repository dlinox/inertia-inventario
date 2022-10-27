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
            'codigo' => 'NU',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'Bueno',
            'codigo' => 'BU',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'Malo',
            'codigo' => 'MA',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'Muy Malo',
            'codigo' => 'MM',
        ]);
        DB::table('estado')->insert([
            'nombre' => 'Chatarra',
            'codigo' => 'CH',
        ]);
    }
}
