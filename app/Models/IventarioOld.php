<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IventarioOld extends Model
{
    use HasFactory;

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
        'observaciones'
    ];


}
