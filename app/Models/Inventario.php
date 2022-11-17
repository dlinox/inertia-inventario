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
    ];

    public function getDataByCode($codigo)
    {
        $res = $this::where('codigo', $codigo)
            ->first();
        $res['persona'] = Persona::where('dni', $res->persona_dni)->first();
        //$res['oficina//'] = Area::where('id', $res->area_id)->first();
        return $res;
    }
}
