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

class UsersExports implements FromView, WithColumnWidths,  WithDrawings, WithStyles
{

    public function __construct( $idArea = "", $idP="")
{
    $this->idArea = $idArea;
    $this->idP = $idP;
}

    // public function iniciar($id_area){
    //     $this->data = DB::select('SELECT * from bienk where id_estado= '.$id_area.';');
    //     $this->export();
    // }

    // public function view(): View
    // {
    //     return view($this->view,
    //         $this->data
    //     );
    // }
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

    public function export($idArea, $idP){

        return Excel::download(new UsersExports($idArea,$idP), 'invoices.xlsx');
    }

    public function columnWidths(): array  {
        return [
            'A' => 5, 'B' => 12, 'C' => 35, 'D' => 12, 'E' => 12, 'F' => 12, 'G' => 12, 'H' => 8, 'I' => 8, 'J' => 8,'K' => 22
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/images/logo_unap_tiny.png'));
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');

        $drawing2 = new Drawing();
        $drawing2->setName('Logo_inventario');
        $drawing2->setDescription('This is my logo');
        $drawing2->setPath(public_path('/images/logo_inventario_tiny.png'));
        $drawing2->setHeight(90);
        $drawing2->setCoordinates('K1');
        return [$drawing, $drawing2];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            2    => ['font' => ['bold' => true]],
            // Styling a specific cell by coordinate.
            10   => ['font' => ['bold' => true],['size' => 12] ],
            'C'  => ['alignment' => ['wrapText' => true] ],
            'G'  => ['alignment' => ['wrapText' => true] ]
        ];
    }





}

