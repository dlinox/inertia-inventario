<?php

namespace App\Http\Controllers;

use App\Models\AreaPersona;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function getDocuments(){
        //$res = AreaPersona::select()->orderBy('id', 'DESC')->get();
        $res = DB::select('SELECT area_persona.*, area_persona.fecha, area.nombre, persona.dni FROM ((area_persona INNER JOIN area ON area_persona.id_area = area.id)INNER JOIN persona ON area_persona.id_persona = persona.id) ORDER BY area_persona.id desc;
        ');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
    public function index()
    {
        return Inertia::render('Admin/Reportes/');
    }

    public function preview($idArea,$idP){
        $oficina = DB::select('SELECT oficina.id, oficina.codigo, oficina.nombre FROM oficina WHERE oficina.id IN (SELECT area.id_oficina FROM area WHERE area.id ='.$idArea.')');
        $area = DB::select('SELECT * from  area WHERE area.id ='.$idArea.';');
        $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno FROM persona WHERE persona.id ='.$idP);
        $datos['bienes'] = DB::select('SELECT * from inventario WHERE id_area = '.$idArea.' and id_persona = '.$idP.';');
        $datos['lfecha'] = date('Y-m-d');
        $datos['lhour'] = date('H:i:s');
        $datos['inventaristas'] = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = '.$idArea.' and id_persona = '.$idP.');');
        $datos['oficina'] = $oficina[0];
        $datos['area'] = $area[0];
        $datos['responsable'] = $responsable[0];

//        $res = DB::select('SELECT * from area_persona where id_persona = '.$idP.' and id_area = '.$idArea.';');
        return Inertia::render('Admin/Reportes/Preview/',  ['datos' => $datos]);

    }

    public function generador()
    {
        return Inertia::render('Admin/Reportes/');
    }
    public function explorador(){
        return Inertia::render('Admin/Explorador/');
    }

}
