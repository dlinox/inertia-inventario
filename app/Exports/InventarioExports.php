<?php
namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InventarioExports implements FromView
{

    public function view(): View
    {
        $data = DB::select('SELECT inventario.id, 
        inventario.tipo, inventario.idreg_anterior, inventario.cod_ubicacion, inventario.codigo, inventario.descripcion, inventario.modelo, 
        inventario.marca, inventario.nro_serie, inventario.medidas, inventario.color, inventario.observaciones, inventario.idbienk, inventario.corr_area AS dep, inventario.corr_num AS corr, 
        inventario.estado_uso, inventario.num_ambiente, 
        persona.dni, CONCAT(persona.nombres," ", persona.paterno," ",persona.materno) as responsable,
        oficina.dependencia, oficina.nombre AS oficina, 
        CONCAT(users.nombres," ", users.apellidos) AS inventariador
        FROM inventario 
        left join persona ON inventario.id_persona = persona.id
        left join oficina ON inventario.id_area = oficina.iduoper
        left join users ON inventario.id_usuario = users.id
        ORDER BY(inventario.corr_area) LIMIT 10');

        return view('exports.inventario', ['data' => $data]);
    }

}
