<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\AreaPersona;
use App\Models\Persona;
use Faker\Provider\ar_EG\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PersonasController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Personas/', []);
    }

    public function getPersonas()
    {
        $res = Persona::select()->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

<<<<<<< HEAD
    public function getPersonasByArea($id)
    {
=======
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
>>>>>>> 01eedfb21e161fb1d5074ce13143b26eeb377ce5

        $res = DB::select('SELECT * FROM PERSONA WHERE ID IN (SELECT area_persona.id_persona FROM `area_persona` WHERE id_area = ' . $id . ')');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getAllPersonas(Request $request)
    {

        $query_where = [];
        if ($request->tipo) array_push($query_where, ['persona.id_tipo_persona', '=', $request->tipo]);


        //DB::raw("CONCAT( hor_inicio , ' - ' , hor_fin) as horario")
        $res = Persona::select(
            'persona.*',
            'tipo_persona.nombre as tipo_nombre'
        )
            ->leftjoin('tipo_persona', 'tipo_persona.id', '=', 'persona.id_tipo_persona')
            ->where($query_where)
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('persona.nombres', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('persona.paterno', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('persona.materno', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('persona.dni', 'LIKE', '%' . $request->term . '%');
            })
            ->paginate(2);



        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }

    public function getFormulario($id = "")
    {

        $props['is_nuevo'] = true;

        if ($id !=  "") {


            $usuario = Persona::find($id);

            if (!$usuario) {
                $props['error'] =  true;
            } else {
                $props['data'] = $usuario;
                $props['is_nuevo'] = false;
            }
        }

        return Inertia::render('Admin/Personas/Formulario', $props);
    }

    public function savePersona(Request $request)
    {
        if (!$request->id) {

            $usuario = Persona::create([
                'nombres' => $request->nombres,
                'paterno' => $request->paterno,
                'materno' => $request->materno,
                'dni' => $request->dni,
                'id_tipo_persona' => $request->id_tipo_persona,
            ]);

            $this->response['mensaje'] = 'Persona creada con exito';
        } else {

            $usuario = Persona::find($request->id);

            $usuario->nombres = $request->nombres;
            $usuario->paterno = $request->paterno;
            $usuario->materno = $request->materno;
            $usuario->dni = $request->dni;
            $usuario->id_tipo_persona = $request->id_tipo_persona;
            $usuario->save();

            $this->response['mensaje'] = 'Persona editada con exito';
        }


        $this->response['estado'] = true;
        $this->response['datos'] = $usuario;

        return response()->json($this->response, 200);
    }
}
