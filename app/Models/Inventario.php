<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventario';

    protected $fillable = [
        'tipo',
        'idreg_anterior',
        'cod_ubicacion',
        'cuenta',
        'codigo',
        'codigo_anterior',
        'descripcion',
        'anio_adq',
        'modelo',
        'marca',
        'medidas',
        'nro_serie',
        'val_libros',
        'dep_acum2019',
        'color',
        'observaciones',
        'idbienk',
        'id_persona',
        'idpersona_otro',
        'id_area',
        'id_usuario',
        'id_estado',
        'foto_ref',
        'corr_area',
        'corr_num',
        'estado',
    ];

    public function getDataByCode($codigo)
    {
        $res = $this::select('inventario.*', 'iduoper as id_oficina')
            ->join('oficina', 'inventario.id_area', '=', 'iduoper')
            ->where('inventario.codigo', $codigo)
            ->first();

        $res['persona'] = Persona::where('id', $res->id_persona)->first();
        $res['persona_otro'] = Persona::where('id', $res->idpersona_otro)->first();
        $res['id_persona']  = $res->id_persona;
        $res['idpersona_otro']  = $res->idpersona_otro;
        //$res['oficina//'] = Area::where('id', $res->area_id)->first();
        return $res;
    }


    public function getDataByRegAnt($idreg_anterior)
    {
        $res = $this::select('inventario.*', 'iduoper as id_oficina', 'idreg_anterior')
            ->join('oficina', 'inventario.id_area', '=', 'iduoper')
            ->where('inventario.idreg_anterior', $idreg_anterior)
            ->first();

        $res['persona'] = Persona::where('id', $res->id_persona)->first();
        $res['persona_otro'] = Persona::where('id', $res->idpersona_otro)->first();
        $res['id_persona']  = $res->id_persona;
        $res['idpersona_otro']  = $res->idpersona_otro;
        //$res['oficina//'] = Area::where('id', $res->area_id)->first();
        return $res;
    }
}
