<?php
namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class tableExports implements FromView
{

    public function __construct( $idArea = "", $idP="")
    {
        $this->idArea = $idArea;
        $this->idP = $idP;
    }

    public function view(): View
    {
        return view('exports.bienExcel', [
            'invoices' => DB::select('SELECT * from inventario WHERE id_area = '.$this->idArea.' and id_persona = '.$this->idP.';'),
            'oficina' => DB::select('SELECT oficina.id, oficina.codigo, oficina.nombre FROM oficina WHERE oficina.id IN (SELECT area.id_oficina FROM area WHERE area.id ='.$this->idArea.');'),
            'area' => DB::select('SELECT * from  area WHERE area.id ='.$this->idArea.';'),
            'responsable' => DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno FROM persona WHERE persona.id ='.$this->idP),
            'responsable2' => DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno FROM persona WHERE persona.id IN (SELECT DISTINCT(idpersona_otro) from bienk WHERE id_area ='.$this->idArea.');'),
            'inventarista' => DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = '.$this->idArea.' and id_persona = '.$this->idP.');'),
            'bienes' => DB::select('SELECT * from inventario WHERE id_area = '.$this->idArea.' and id_persona = '.$this->idP.';'),
            'ldate' => date('d-m-Y'),
            'lhour' => date('H:i:s',strtotime('-5 hours'))
        ]);
    }

}

