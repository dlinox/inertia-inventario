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
        $res = DB::select('SELECT *, concat(persona.nombres," ",persona.paterno," ",persona.materno) as nombre from persona;');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getPersonasInv()
    {
        $res = DB::select('SELECT *, concat(persona.nombres," ",persona.paterno," ",persona.materno) as nombre from persona WHERE id IN (SELECT id_persona FROM inventario);');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getPersonasByAreaInv($id)
    {
        $res = DB::select('SELECT *, concat(persona.nombres," ",persona.paterno," ",persona.materno) as nombre from persona WHERE id IN (SELECT id_persona FROM inventario where id_area = "'.$id.'");');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getPersonasByAreaInvNoR($id)
    {
        $res = DB::select('SELECT *, concat(persona.nombres," ",persona.paterno," ",persona.materno) as nombre from persona WHERE id IN (SELECT id_persona FROM inventario where id_area = "'.$id.'") AND ID NOT IN (SELECT ID_PERSONA from area_persona WHERE ID_AREA = "'.$id.'" AND estado = 1 );');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
    public function getPersonasForAdicionales($id)
    {
        $res = DB::select('SELECT *, concat(persona.nombres," ",persona.paterno," ",persona.materno) as nombre from persona WHERE id IN (SELECT id_persona FROM inventario where id_area ="'.$id.'"  AND estado = 1);');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function getPersonasByArea($id){

        $res = DB::select('SELECT * FROM PERSONA WHERE ID IN (SELECT area_persona.id_persona FROM `area_persona` WHERE id_area = ' . $id . ' )');
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
            'persona.*'
            //'tipo_persona.nombre as tipo_nombre'
        )
           // ->leftjoin('tipo_persona', 'tipo_persona.id', '=', 'persona.id_tipo_persona')
            ->where($query_where)
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('persona.nombres', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('persona.paterno', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('persona.materno', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('persona.dni', 'LIKE', '%' . $request->term . '%');
            })
            ->paginate(10);



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
                'idtipoper' => $request->id_tipo_persona,
            ]);

            $this->response['mensaje'] = 'Persona creada con exito';
        } else {

            $usuario = Persona::find($request->id);

            $usuario->nombres = $request->nombres;
            $usuario->paterno = $request->paterno;
            $usuario->materno = $request->materno;
            $usuario->dni = $request->dni;
            $usuario->idtipoper = $request->id_tipo_persona;
            $usuario->save();

            $this->response['mensaje'] = 'Persona editada con exito';
        }


        $this->response['estado'] = true;
        $this->response['datos'] = $usuario;

        return response()->json($this->response, 200);
    }

    public function savePersonasImport(Request $request)
    {
        $datos= $request->data;

        $n = $this->sz($request->data);

        for($i=1; $i<=$n; $i++){
            $peronsa = Persona::create([
                'nombres' => $datos[$i][1],
                'paterno' => $datos[$i][2],
                'materno' => $datos[$i][3],
                'dni' => $datos[$i][0],
                'id_tipo_persona' => 1,
            ]);
        }
        return $request->data[$n][0];
        // $usuario = Persona::create([
        //     'nombres' => $request->nombres,
        //     'paterno' => $request->paterno,
        //     'materno' => $request->materno,
        //     'dni' => $request->dni,
        //     'id_tipo_persona' => $request->id_tipo_persona,
        // ]);

        // $this->response['estado'] = true;
        // $this->response['datos'] = $usuario;

        // return response()->json($this->response, 200);
    }
    private function sz( $array){
        $cont = 0;
        foreach ($array as $key => $item) {
            $cont = $key;
        }
        return $cont;
    }


    /**************** FACILITADOR *****************/
    public function getPersonasFacilitador(Request $request)
    {
        $res = Persona::select('*')
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('dni', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('nombres' , 'LIKE', '%' . $request->term . '%');
            })->paginate(10);



        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


}
