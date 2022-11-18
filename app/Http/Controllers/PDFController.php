<?php
namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Inventario;
use App\Models\AreaPersona;
use App\Models\Document;
use App\Models\Bienk;
use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use \PDF;

class PDFController extends Controller
{
    public function pdfCreate(){
        $pdf = PDF::loadView('Prueba');
        return $pdf->download('prueba.pdf');
    }

    // public function verReportes(){

    // }

    public function getAreaPersonSelected ($idP, $idA)
    {
            $res = AreaPersona::where('id_persona',$idP AND 'id_area',$idA)->get();
            return $res;
    }

    public function bloquear(Request $request,  $id) {

        $res = AreaPersona::find($id);
        $res->estado = 0;
        $res->save();
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function desbloquear(Request $request,  $id) {
        $res = AreaPersona::find($id);
        $res->estado = 1;
        $res->save();
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function PDFBienes($idP,$idArea){

        $registrado = DB::select('SELECT * from area_persona where id_persona = '.$idP.' and id_area = '.$idArea.' AND estado = 0 ;');

        if($registrado != null){
            $this->response['mensaje'] = 'ITEM YA REGISTRADO';
            return response()->json($this->response, 200);
        }
        else{
            $res = DB::select('SELECT * from area_persona where id_persona = '.$idP.' and id_area = '.$idArea.';');
            $oficina = DB::select('SELECT oficina.id, oficina.codigo, oficina.nombre FROM oficina WHERE oficina.id IN (SELECT area.id_oficina FROM area WHERE area.id ='.$idArea.')');
            $area = DB::select('SELECT * from  area WHERE area.id ='.$idArea.';');
            $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno FROM persona WHERE persona.id ='.$idP);
            $inventaristas = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = '.$idArea.' and id_persona = '.$idP.');');
            $bienes = DB::select('SELECT * from inventario WHERE id_area = '.$idArea.' and id_persona = '.$idP.';');
            $ldate = date('Y-m-d');
            $lhour = date('H:i:s');
            $pdf = PDF::loadView('Bienes', compact('bienes','oficina','inventaristas','area','responsable','ldate','lhour'));
    //        $pdf->output(['/public','F']);
            $pdf->setPaper('a4','landscape');
            if (AreaPersona::max('id') > 0 ){
                $nro = AreaPersona::max('id')+1;
            }else {
                $nro = 1;
            }

            if ($nro < 10) {
                $codigo = 'CBI-'.date('d').date('m').date('Y').'-000000'.$nro;
            }
            if ($nro > 9 && $nro < 100) {
                $codigo = 'CBI-'.date('d').date('m').date('Y').'-00000'.$nro;
            }
            if ($nro > 99 && $nro < 1000) {
                $codigo = 'CBI-'.date('d').date('m').date('Y').'-0000'.$nro;
            }
            if ($nro > 999 && $nro < 10000) {
                $codigo = 'CBI-'.date('d').date('m').date('Y').'-000'.$nro;
            }
            if ($nro > 9999 && $nro < 100000) {
                $codigo = 'CBI-'.date('d').date('m').date('Y').'-00'.$nro;
            }
            if ($nro > 99999 && $nro < 1000000) {
                $codigo = 'CBI-'.date('d').date('m').date('Y').'-0'.$nro;
            }

            $output = $pdf->output();
            file_put_contents(public_path().'/documents/cargos/'.$codigo.'.pdf', $output);

            $doc['codigo'] = $codigo;
            $doc['id_area'] = $idArea;
            $doc['id_persona'] = $idP;
            $doc['url'] = '/documents/cargos/'.$codigo.'.pdf';
            $doc['tipo'] = 1;
            $doc['estado'] = 0;
            $doc['fecha'] = $ldate;
            $doc['id_usuario'] = Auth::id();
            AreaPersona::create($doc);

            $this->bloquearBienes( $idArea, $idP);
            $this->response['mensaje'] = 'PDF';
            $this->response['estado'] = true;
            $this->response['datos'] = $doc;
            return response()->json($this->response, 200);
        }


    }

    private function bloquearBienes( $id_a, $id_p ){
        $bienes = DB::select('SELECT * from inventario WHERE id_area =  '.$id_a.' AND id_persona = '.$id_p.';');
        foreach ($bienes as $p) {
            $this->cambiar($p, 0);
        }
    }

    private function cambiar($bienes, $estado){
        $res = Inventario::find($bienes->id);
        $res->estado = $estado;
        $res->save();
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

}
