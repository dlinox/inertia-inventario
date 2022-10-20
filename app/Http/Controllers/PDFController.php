<?php
namespace App\Http\Controllers;

use App\Models\Area;
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

        $res = DB::select('SELECT * from area_persona where id_persona = '.$idP.' and id_area = '.$idArea.';');
        $oficina = DB::select('SELECT oficina.id, oficina.codigo, oficina.nombre FROM oficina WHERE oficina.id IN (SELECT area.id_oficina FROM area WHERE area.id ='.$idArea.')');
        $area = DB::select('SELECT * from  area WHERE area.id ='.$idArea.';');
        $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno FROM persona WHERE persona.id ='.$idP);
//      $inventarista = DB::select('SELECT * FROM users WHERE users.id in (SELECT grupo.id_usuario FROM grupo WHERE id_area ='.$idArea.');');
//      $bienes = DB::select('SELECT * from inventario WHERE id_area = '.$idArea.' and id_usuario='.$inventarista[0]->id.';');
        $bienes = DB::select('SELECT * from inventario WHERE id_area = '.$idArea.' and id_persona = '.$idP.';');
        $ldate = date('Y-m-d');
        $lhour = date('H:i:s');
        $pdf = PDF::loadView('Bienes', compact('bienes','oficina','area','responsable','ldate','lhour'));
//        $pdf->output(['/public','F']);
        $pdf->setPaper('a4','landscape');
        $nro = Documento::max('id')+1;
        if ($nro < 10) {
            $codigo = 'CBI-'.date('d').date('m').date('Y').'-000000'.$nro;
        }else{
            $codigo = 'CBI-'.date('d').date('m').date('Y').'-00000'.$nro;
        }

        $output = $pdf->output();
        file_put_contents(public_path().'/documents/cargos/'.$codigo.'.pdf', $output);

        $doc['codigo'] = $codigo;
        $doc['url'] = '/documents/cargos/'.$codigo.'.pdf';
        $doc['tipo'] = 1;
        $doc['dni_responsable'] = $responsable[0]->dni;
        $doc['id_area'] = $idArea;
        $doc['id_oficina'] = $oficina[0]->id;
        $doc['id_area_persona'] = $res[0]->id;
        $doc['id_usuario'] = Auth::id();
        Documento::create($doc);

        $this->response['mensaje'] = 'PDF';
        $this->response['estado'] = true;
        $this->response['datos'] = $doc;
        return response()->json($this->response, 200);
    }


}
