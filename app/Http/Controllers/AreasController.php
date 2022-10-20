<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;


class AreasController extends Controller
{

    public function index()
    {
        return Inertia::render('Admin/Areas/');
    }

    public function bloquear()
    {
        return Inertia::render('Admin/Areas/bloquear.vue');
    }


    public function getAreas()
    {
        $res = Area::select()->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getAreasByPersona($id)
    {
        $res = DB::select('SELECT * FROM AREA WHERE ID IN (SELECT area_persona.id_area FROM `area_persona` WHERE id_persona = ' . $id . ')');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function asignarPersona(Request $request, $id)
    {
        $res = Area::find($id);
        $res->id_persona = $request->id;
        $res->save();

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] = $request->nombre;
        return response()->json($this->response, 200);
    }

    public function cambiarEstado(Request $request, $nro)
    {
        $res = Area::find($request->id);
        $res->stado = $nro;
        $res->save();

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] = $request->nombre;
        return response()->json($this->response, 200);
    }

    public function getAreasByOficina($oficina, $usuario = "")
    {

        //$query_select = ['area.*'];
        // if ($usuario != "") array_push($query_select, DB::raw("IF( users.id = $usuario ,  TRUE , FALSE) AS usuario"));

        $res = Area::select('area.*')
            ->join('grupo', 'grupo.id_area', '=', 'area.id')
            ->where('area.id_oficina', $oficina)
            ->where('grupo.id_usuario', '!=', $usuario)
            ->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $oficina;
        return response()->json($this->response, 200);
    }

    public function getAllInfoArea($oficina, $usuario = "")
    {
        $res = Area::select(
            DB::raw('(SELECT COUNT(bienk.id) FROM bienk WHERE bienk.id_area = area.id) AS bienesk'),
            DB::raw('(SELECT COUNT(inventario.id) FROM inventario WHERE inventario.id_area = area.id) AS inventarios'),
            DB::raw('GROUP_CONCAT(persona.nombres SEPARATOR ",") as responsables'),
            'area.*'
        )
            ->join('grupo', 'grupo.id_area', '=', 'area.id')
            ->leftjoin('area_persona', 'area_persona.id_area', '=', 'area.id')
            ->leftjoin('persona', 'area_persona.id_persona', '=', 'persona.id')
            ->where('area.id_oficina', $oficina)
            ->where('grupo.id_usuario', $usuario)
            ->groupBy('area.id')
            ->get();

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $oficina;
        return response()->json($this->response, 200);
    }
}
