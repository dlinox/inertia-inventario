<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OficinaController extends Controller
{
    public function getOficinas($term, $user = "")
    {

        if ($user != "") {
            $res = Oficina::join('grupo', 'grupo.id_oficina', 'oficina.iduoper')
                ->where('grupo.id_usuario', $user)
                ->orWhere('nombre', 'LIKE', '%' . $term . '%')
                ->orWhere('codigo', 'LIKE', '%' . $term . '%')
                ->orWhere('dependencia', 'LIKE', '%' . $term . '%')
                ->orWhere('iduoper', 'LIKE', '%' . $term . '%')
                ->get();
        } else {

            $res = Oficina::where('nombre', 'LIKE', '%' . $term . '%')
                ->orWhere('codigo', 'LIKE', '%' . $term . '%')
                ->orWhere('dependencia', 'LIKE', '%' . $term . '%')
                ->orWhere('iduoper', 'LIKE', '%' . $term . '%')
                ->get();
        }

        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] = $term;
        return response()->json($this->response, 200);
    }

    public function getallOficinas()
    {
        $res = DB::select('SELECT * FROM oficina where iduoper IN ( SELECT id_area FROM inventario );');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getallOficinasG()
    {
        $res = DB::select('SELECT * FROM oficina');

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    // public function getOficinasG(Request $request){


    //     $res = Oficina::all();
    //         // ->where(function ($query) use ($request) {
    //         //     return $query
    //         //         ->orWhere('iduoper', 'LIKE', '%' . $request->term . '%')
    //         //         ->orWhere('nombre', 'LIKE', '%' . $request->term . '%');
    //         // })
    //         // ->paginate(7);

    //     $this->response['estado'] = true;
    //     $this->response['datos'] = $res;

    //     return response()->json($this->response, 200);
    // }


    public function getOficinasByAreas($id)
    {
        $res = DB::select('SELECT * FROM oficina     where id_area IN (SELECT id_oficina FROM area WHERE id = ' . $id . ');');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function getOficinasFacilitador()
    {
        $res = DB::select('SELECT * FROM oficina;');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
}
