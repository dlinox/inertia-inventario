<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OficinaController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Oficina/index');
    }

    public function store(Request $request)
    {

        $usuario = Oficina::create([
            'iduoper' => $request->iduoper,
            'nombre' => $request->nombre,
            'dependencia' => $request->dependencia,
        ]);

        $this->response['estado'] = true;
        $this->response['datos'] = $usuario;

        return response()->json($this->response, 200);

    }

    public function getOficinas($term, $user = "")
    {

        if ($user != "") {
            $res = Oficina::join('grupo', 'grupo.id_oficina', 'oficina.iduoper')
                ->where('grupo.id_usuario', $user)
                ->where(function ($query) use ($term) {
                    return $query
                        ->orWhere('nombre', 'LIKE', '%' . $term . '%')
                        ->orWhere('codigo', 'LIKE', '%' . $term . '%')
                        ->orWhere('dependencia', 'LIKE', '%' . $term . '%')
                        ->orWhere('iduoper', 'LIKE', '%' . $term . '%');
                })
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
        $res = DB::select('SELECT *, CONCAT(oficina.nombre," - ",oficina.dependencia) as nombres FROM oficina where iduoper IN ( SELECT id_area FROM inventario );');
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


    public function getallOficinasDependencia()
    {

        $res = Oficina::select(
            'dependencia',
            DB::raw('GROUP_CONCAT(nombre SEPARATOR "|#|") as oficinas'),
            DB::raw('GROUP_CONCAT(iduoper SEPARATOR "|#|") as oficinas_ids')
        )
            ->groupBy('dependencia')
            ->get();

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['esto'] = 'da';
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

    public function getUOficinas()
    {
        $idu = auth()->id();

        $res = DB::select('SELECT distinct oficina.*, CONCAT(oficina.nombre," - ",oficina.dependencia) as nombres FROM oficina inner join inventario ON oficina.iduoper = inventario.id_area where iduoper IN (SELECT id_area FROM inventario ) AND inventario.id_usuario = ' . $idu . ';');
        // $res = DB::select('SELECT * FROM oficina;');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function getoficinex()
    {


        $res = DB::select('SELECT substring(oficina.iduoper,1,2) as cod, oficina.nombre  FROM oficina ;');
        // $res = DB::select('SELECT * FROM oficina;');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return $res;
    }
}
