<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
        'codigo',
        'codigo_siga',
        'descripcion',
        'modelo',
        'marca',
        'nro_serie',
        'anio_fabricacion',
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
        'tipo',
        'idbienk',
        'estado',
        'idpersona_otro',
        'id_persona',
        'id_area',
        'id_usuario',
        'id_estado',

        'foto_ref'
    ];

    public function getDataByCode($codigo)
    {
        $res = $this::select('inventario.*', 'id_oficina')
            ->join('area', 'inventario.id_area', '=', 'area.id')
            ->where('inventario.codigo', $codigo)
            ->first();

        $res['persona'] = Persona::where('id', $res->id_persona)->first();
        $res['persona_otro'] = Persona::where('id', $res->idpersona_otro)->first();
        $res['id_persona']  = $res->id_persona;
        $res['idpersona_otro']  = $res->idpersona_otro;
        //$res['oficina//'] = Area::where('id', $res->area_id)->first();
        return $res;
    }
}
