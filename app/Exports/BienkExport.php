<?php

namespace App\Exports;

use App\Models\BienK;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class BienkExport implements FromView
{

    protected  $tipo;
    protected  $dependencia;


    public function __construct($dependencia, $tipo )
    {
        $this->tipo = $tipo;
        $this->dependencia = $dependencia;
    }

    public function view(): View
    {
        $data = DB::select("SELECT bienk.*,persona.*,  oficina.dependencia, oficina.nombre AS oficina
        FROM bienk 
        JOIN oficina ON oficina.iduoper = bienk.id_area
        LEFT JOIN persona ON persona.dni = bienk.persona_dni
        WHERE bienk.tipo='{$this->tipo}'  
        AND cod_ubicacion LIKE '{$this->dependencia}%' 
        AND (bienk.codigo NOT IN (SELECT inventario.codigo FROM inventario WHERE codigo IS not NULL));");

        return view('exports.conciliacion', ['data' => $data]);
    }
}
