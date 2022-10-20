<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaPersona;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
class PersonasController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Personas/');
    }

    public function getPersonas()
    {
        $res = Persona::select()->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getPersonasInv()
    {
        $res = DB::select('SELECT * from persona WHERE id IN (SELECT id_persona FROM inventario);');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getPersonasByAreaInv($id)
    {
        $res = DB::select('SELECT * from persona WHERE id IN (SELECT id_persona FROM inventario where id_area = '.$id.');');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getPersonasByArea($id){

        $res = DB::select('SELECT * FROM PERSONA WHERE ID IN (SELECT area_persona.id_persona FROM `area_persona` WHERE id_area = '.$id.')');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
}
