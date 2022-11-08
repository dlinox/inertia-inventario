<?php
namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromArray;

class UsersExport implements FromCollection, WithCustomStartCell, WithHeadings, ShouldAutoSize
{
    // public function styles(Worksheet $sheet)
    // {
    //     return [
    //         // Style the first row as bold text.
    //         1    => ['font' => ['bold' => true]],

    //         // Styling a specific cell by coordinate.
    //         'B2' => ['font' => ['italic' => true]],

    //         // Styling an entire column.
    //         'C'  => ['font' => ['size' => 16]],
    //     ];
    // }

    // public function array(): array
    // {
    //     return [
    //         ["CELDA 1", "CELDA 2", 'CELDA 3'],
    //         [4, 5, 6],
    //         ["CELDA 1", "CELDA 2", 'CELDA 3'],
    //         [4, 5, 6],
    //         ["CELDA 1", "CELDA 2", 'CELDA 3'],
    //         [4, 5, 6]
    //     ];
    // }

    public function headings(): array
    {
        return [
            [' ','Universidad Nacional de Altiplano de Puno' ],
            [' ','Facultad de Mecanica Electrica, Electrónica y Sistemas'],
            [' ', 'Inventario de bienes 2022 '],
            [' '],
            ['Oficina:','Dirección de Sistemas',' ',' ','N° Reporte:','RU00000001'],
            ['Responsable:','Jhon Ariel Luque Cusacani',' ',' ','Fecha:','15-10-2022'],
            ['Inventariador:','Denis Puma Ticoma',' ',' ','Hora:','20:50:30'],
            ['Fecha Inventario:','10-12-2022 al 14-12-2022'],
            [' '],
            ['CODIGO','NOMBRE','APELLIDOS',' ',' ', 'COREEO']
        ];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
    //         'C' => NumberFormat::FORMAT_CURRENCY_EUR_SIMPLE,
    //     ];
    // }

    public function startCell(): string
    {
        return 'A1';
    }

    public function collection()
    {

     $records = DB::table('users')->select('id','nombres','apellidos','rol','estado','email')->get();
     return $records;

    }




}
