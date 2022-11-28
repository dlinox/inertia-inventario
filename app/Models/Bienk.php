<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bienk extends Model
{
    use HasFactory;

    protected $table = 'bienk';
    protected $fillable = [
        'codigo',
        'codigo_siga',
        'descripcion',
        'modelo',
        'marca',
        'nro_serie',
        'anio_fabricacion',
        'estado_actual',
        'ubicacion',
        'persona_dni',
        'nro_cargo_personal',
        'fecha_cargo',
        'nro_orden',
        'fecha_compra',
        'proveedor_ruc',
        'nro_pecosa',
        'fecha_pecosa',
        'vida_util',
        'fecha_vida_util',
        'valor_adquisicion',
        'valor_inicial',
        'valor_depreciacion',
        'fecha_baja_bien',
        'clasificador',
        'sub_cta',
        'mayor',
        'observaciones',
        'registrado'
    ];

    public function searchDataByCode($codigo)
    {
        $res = $this::select('codigo', 'descripcion', 'registrado')
            ->where('codigo', 'LIKE', $codigo . '%')
            ->get();
        return $res;
    }

    public function getDataByCode($codigo)
    {
        $res = $this::select('bienk.*', 'oficina.iduoper as id_oficina')
            ->join('oficina', 'oficina.iduoper', '=', 'bienk.id_area')
            ->where('bienk.codigo', $codigo)
            ->first();

        $res['persona'] = Persona::where('dni', $res->persona_dni)->first();
        if($res['persona']){
            $res['id_persona']  = $res['persona']->id;
        }

        //$res['oficina//'] = Area::where('id', $res->area_id)->first();
        return $res;
    }
}
