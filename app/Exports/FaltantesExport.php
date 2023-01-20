<?php

namespace App\Exports;

use App\Models\Bienk;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;


class FaltantesExport implements FromView
{
    protected  $dependencia;
    protected  $activofijo;
    protected  $nodepreciable;
    protected  $otro;


    public function __construct($dependencia, $activofijo, $nodepreciable, $otro)
    {

        $this->dependencia = $dependencia;
        $this->activofijo = $activofijo;
        $this->nodepreciable = $nodepreciable;
        $this->otro = $otro;
    }

    public function view(): View
    {


        $bajas_objet = DB::select('SELECT codigo FROM bajas_2022');
        $bajas = [];
        foreach ($bajas_objet as $val) {
            array_push($bajas, $val->codigo );
        }


        $data = Bienk::select(
            'bienk.id',
            'bienk.tipo',
            'bienk.codigo',
            'bienk.descripcion',
            'bienk.cod_ubicacion',
            'bienk.modelo',
            'bienk.marca',
            'bienk.nro_serie',
            'bienk.medidas',
            'bienk.color',
            'bienk.observaciones',
            'persona.nombres',
            'persona.paterno',
            'persona.materno',
            'persona.dni',
            'oficina.dependencia',
            'oficina.nombre AS oficina '
        )
            ->leftjoin('oficina', 'oficina.iduoper', '=', 'bienk.id_area')
            ->leftjoin('persona', 'persona.dni', '=', 'bienk.persona_dni')
            ->where('bienk.id_area', 'LIKE', "$this->dependencia.%")
            ->where('bienk.registrado', 0)
            ->whereNotIn('codigo', $bajas)
            ->where(function ($query) {
                $temp = $query
                    ->orwhere('bienk.tipo', 'ACTIVO FIJO');

                if ($this->nodepreciable == 'true') {
                    $temp->orwhere('bienk.tipo', 'NO DEPRECIABLE');
                }
                if ($this->otro == 'true') {
                    $temp->orwhere('bienk.tipo', '');
                    $temp->orWhereNull('bienk.tipo');
                    $temp->orwhere('bienk.tipo', 'OTROS');
                }
                return $temp;
            })->groupBy(
                'bienk.id',
                'bienk.tipo',
                'bienk.codigo',
                'bienk.descripcion',
                'bienk.cod_ubicacion',
                'bienk.modelo',
                'bienk.marca',
                'bienk.nro_serie',
                'bienk.medidas',
                'bienk.color',
                'bienk.observaciones',
                'persona.nombres',
                'persona.paterno',
                'persona.materno',
                'persona.dni',
                'oficina.dependencia',
                'oficina.nombre'
            )->get();


        return view('exports.faltantes', ['data' => $data]);
    }
}
