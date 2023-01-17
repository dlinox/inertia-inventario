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

    public function cargoUpdate(){
        return Inertia::render('Admin/Explorador/cargos.vue');
    }

    public function getCargos($depenencia){

        $res = DB::select("SELECT area_persona.id_persona, area_persona.id_area, CONCAT(area_persona.id_area,' ',persona.dni,' - ',area_persona.num) as name,area_persona.id,area_persona.tipo, area_persona.num,oficina.iduoper, oficina.nombre, persona.dni, persona.nombres, persona.paterno, persona.materno 
            FROM area_persona
            JOIN persona on persona.id = area_persona.id_persona
            JOIN oficina on oficina.iduoper = area_persona.id_area
            WHERE substr(id_area, 1, 2) = '".$depenencia."' AND area_persona.tipo != 2 AND estado = 1;"); 

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getDependencias(){
        $res = DB::select('SELECT distinct substring(inventario.id_area,1,2) as iddep, oficina.dependencia 
        FROM inventario
        JOIN oficina ON inventario.id_area = oficina.iduoper;');

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);

    }


    public function getBienes($area, $persona){
        $res = DB::select('SELECT * from inventario WHERE id_area = "'.$area.'" AND id_persona = ' . $persona . ' ORDER BY corr_num ASC;');
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200); 
    }


}
