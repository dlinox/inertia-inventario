<?php
namespace App\Http\Controllers;

use App\Models\AreaPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class AreaPersonaController extends Controller
{
    public function index()
    {

    }

    public function getAreaPersonSelected ($idP, $idA)
    {
            $res = DB::select('select * from area_persona where id_persona = '.$idP.' and id_area = '.$idA.';');
            return $res;
    }
    public function bloquearAreaPersona( $id) {

            $res = AreaPersona::find($id);
            $res->estado = 0;
            $res->save();

            $this->response['estado'] = true;
            $this->response['datos'] = $res;
            return response()->json($this->response, 200);

    }
    public function desBloquearAreaPersona( $id) {

        $res = AreaPersona::find($id);
        $res->estado = 1;
        $res->save();

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);

    }


}
