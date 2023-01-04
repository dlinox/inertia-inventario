<?php

namespace App\Exports;

use App\Models\Inventario;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class SobrantesExport implements FromView
{

    public function __construct($dependencia )
    {
        $this->dependencia = $dependencia;
    }

    public function view(): View
    {
        $data = DB::select("SELECT inventario.*,persona.*, oficina.dependencia, oficina.nombre AS oficina
        FROM inventario 
        JOIN oficina ON oficina.iduoper = inventario.id_area
        JOIN persona ON persona.id = inventario.id_persona
        AND id_area LIKE '{$this->dependencia}%' 
        AND (inventario.codigo IS NULL OR inventario.codigo = '')
        AND (inventario.codigo_anterior is NULL OR inventario.codigo_anterior = '')
        AND id_usuario = 40
        ;");

        return view('exports.conciliacion', ['data' => $data]);
    }
}
