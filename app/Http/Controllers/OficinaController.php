<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OficinaController extends Controller
{
    public function getOficinas($term)
    {

        $res = Oficina::where('nombre', 'LIKE', '%' . $term . '%')
            ->orWhere('codigo', 'LIKE', '%' . $term . '%')
            ->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] = $term;
        return response()->json($this->response, 200);
    }

    public function getallOficinas(){
        $res = DB::select('SELECT * FROM oficina where id IN ( SELECT id_oficina from area WHERE id IN ( SELECT id_area FROM inventario ));');

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
         return response()->json($this->response, 200);
    }

    public function getOficinasByAreas($id){
        $res = DB::select('SELECT * FROM oficina     where id_area IN (SELECT id_oficina FROM area WHERE id = '.$id.');');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);

    }

}
