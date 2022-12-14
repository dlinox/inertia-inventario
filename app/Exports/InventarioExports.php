<?php
namespace App\Exports;

use App\Models\Inventario;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromView;

class InventarioExports implements FromView
{
    use Exportable;

    public function view(): View
    {
        $res = Inventario::select('inventario.id', 'tipo', 'idreg_anterior', 'cod_ubicacion', 'cuenta', 'codigo', 'descripcion', 'modelo', 'marca', 'medidas', 'color', 'observaciones', 'idbienk', 'corr_area', 'corr_num', 'estado_uso', 'num_ambiente', 'persona.dni AS responsable')
         ->join('persona','inventario.id_persona', '=', 'persona.id')->get();
        return view('exports.inventario', [
            'res' => $res,
        ]);
    }
}

// class InventarioExports implements FromCollection
// {
//     use Exportable;

//     public function collection()
//     {
//         $res = Inventario::select('inventario.id', 'tipo', 'idreg_anterior', 'cod_ubicacion', 'cuenta', 'codigo', 'descripcion', 'modelo', 'marca', 'medidas', 'color', 'observaciones', 'idbienk', 'corr_area', 'corr_num', 'estado_uso', 'num_ambiente', 'persona.dni AS responsable')
//         ->join('persona','inventario.id_persona', '=', 'persona.id')->get();

//         return $res;
//     }

// }
