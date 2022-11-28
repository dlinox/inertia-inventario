<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use PhpParser\Node\Stmt\Echo_;

class GrupoController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Grupo/');
    }



    public function getItemsGroup()
    {
        $oficinas = DB::select('SELECT id, nombre as name FROM oficina');
        $areas = DB::select('SELECT (id + 1000) as id, nombre as name, id_oficina FROM area');
        $tamO = $this->sz($oficinas);
        $tamA = $this->sz($areas);
        $temp = [];
        for ($i = 0; $i < $tamO; $i++) {
            for ($j = 0; $j < $tamA; $j++) {
                if ($oficinas[$i]->id == $areas[$j]->id_oficina) {
                    array_push($temp, $areas[$j]);
                }

                // if($temp != []) {
                //     $oficinas[$i]->children = $temp;
                // }
            }
            if ($temp != []) {
                $oficinas[$i]->children = $temp;
            }

            $temp = [];
        }

        $this->response['estado'] = true;
        $this->response['datos'] = $oficinas;
        return response()->json($this->response, 200);
    }


    public function getOficinasByGrupo()
    {
        $res = DB::select('SELECT * from oficina WHERE id IN ( SELECT DISTINCT id_oficina FROM area JOIN grupo ON grupo.id_area = area.id )');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function getAreasOficinaByGrupo($id_oficina)
    {
        $res = DB::select('SELECT * from area WHERE id IN (SELECT id_area FROM area JOIN grupo ON grupo.id_area = area.id WHERE id_oficina = ' . $id_oficina . ' );');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getUsuariosByAreas($id_oficina)
    {
        $res = DB::select('SELECT users.* FROM users JOIN grupo ON grupo.id_usuario = users.id WHERE grupo.id_area = ' . $id_oficina . ';');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function guardarGrupo(Request $request)
    {



        // $this->response['usuarios'] = $request->usuarios;
        // $this->response['oficinas'] = $request->ofici;
        // return response()->json($this->response, 200);



        foreach ($request->usuarios as $item) {

            foreach ($request->ofici as $oficina) {

                $this->save($oficina, $item);
                //echo($oficina);
                //echo($item);

            }
        }

        // return $area;
    }

    private function save($id_oficina, $id_usuario)
    {

       


        $registrado = null;
        $registrado = DB::select("SELECT id FROM grupo where id_oficina = '$id_oficina'  AND id_usuario = $id_usuario");

        if ($registrado == null) {


            $grupo = Grupo::create([
                'id_oficina' => $id_oficina,
                'id_usuario' => $id_usuario,
            ]);
            $this->response['mensaje'] = "Grupo guardado";
            $this->response['datos'] = $grupo;
        }

        $this->response['mensaje'] = "Grupo no guardado";

        return response()->json($this->response, 200);

        return $registrado;
    }

    private function sz($array)
    {
        $cont = 0;
        foreach ($array as $key => $item) {
            $cont = $key;
        }
        return $cont;
    }


    /*************** FACILITADOR ********************/
    public function indexFacilitador()
    {
        return Inertia::render('Facilitador/Grupo/');
    }
}
