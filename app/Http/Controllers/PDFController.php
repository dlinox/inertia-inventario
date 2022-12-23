<?php
namespace App\Http\Controllers;
use App\Models\Inventario;
use App\Models\AreaPersona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\Snappy\Facades\SnappyPdf;

use PDF;
class PDFController extends Controller
{
    public function pdfCreate(){
        $pdf = PDF::loadView('Prueba');
        return $pdf->download('prueba.pdf');
    }

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

    public function PDFBienes(Request $doc){
        $registrado = DB::select('SELECT * from area_persona where id_persona = '.$doc->persona.' and id_area = "'.$doc->area.'"  AND estado = 0;');
        
        if($registrado != null){
            $num_doc = $registrado[0]->num + 1;

            if ($doc->opcion == 0){
                $this->response['mensaje'] = 'ITEM YA REGISTRADO';
                return response()->json($this->response, 200);
            }
            else {                

                $bienes = DB::select('SELECT * from inventario WHERE estado = 1 AND id_area = "'.$doc->area.'" AND id_persona = ' . $doc->persona. ';');
                $oficina = DB::select('SELECT * from oficina WHERE iduoper = "'. $doc->area .'";');
                $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno, persona.idtipoper FROM persona WHERE persona.id =' . $doc->persona);
                $r2 = DB::select('SELECT * FROM persona WHERE ID IN ( SELECT idpersona_otro from inventario WHERE id_area = "' . $doc->area . '" and id_persona = ' . $doc->persona . ');');
                if($r2 != null){ $responsable2 = $r2[0]; }
                else { $responsable2 = null; }

                $inventaristas = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = "' . $doc->area . '" and id_persona = ' . $doc->persona . ');');
                $ldate = date('Y-m-d');
                $lhour = date('H:i:s');
                $pdf = PDF::loadView('Bienes', compact('bienes','oficina','inventaristas','responsable','responsable2','ldate','lhour','num_doc'));
                $pdf->setPaper('a4','landscape');
                $pdf->output();
                $codigo = $this->getCodigo('CBI');

                $output = $pdf->output();
                file_put_contents(public_path().'/documents/cargos/'.$codigo.'.pdf', $output);

                $docs['codigo'] = $codigo;
                $docs['id_area'] = $doc->area;
                $docs['id_persona'] = $doc->persona;
                $docs['url'] = '/documents/cargos/'.$codigo.'.pdf';
                $docs['tipo'] = 3;
                $docs['estado'] = 0;
                $docs['num'] = $num_doc;
                $docs['fecha'] = $ldate;
                $docs['id_usuario'] = Auth::id();
                AreaPersona::create($docs);

                $this->bloquearBienes( $doc->area, $doc->persona);
                $this->response['mensaje'] = 'PDF';
                $this->response['estado'] = true;
                $this->response['datos'] = $docs;
                return response()->json($this->response, 200);

            }
        }
        else{

            $num_doc = 1;
            $oficina = DB::select('SELECT * from oficina WHERE iduoper = "'. $doc->area .'";');
            $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno, persona.idtipoper FROM persona WHERE persona.id =' . $doc->persona);
            $r2 = DB::select('SELECT * FROM persona WHERE ID IN ( SELECT idpersona_otro from inventario WHERE id_area = "' . $doc->area . '" and id_persona = ' . $doc->persona . ');');
            if($r2 != null){ $responsable2 = $r2[0]; }
            else { $responsable2 = null; }
            $inventaristas = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = "' . $doc->area . '" and id_persona = ' . $doc->persona . ');');
            $bienes = DB::select('SELECT * from inventario WHERE id_area = "'. $doc->area .'" AND id_persona = ' . $doc->persona . ';');
            $ldate = date('Y-m-d');
            $lhour = date('H:i:s');
            $pdf = PDF::loadView('Bienes', compact('bienes','oficina','inventaristas','responsable','responsable2','ldate','lhour', 'num_doc'));
            $pdf->setPaper('a4','landscape');
            $pdf->output();
            $codigo = $this->getCodigo('CBI');

            $output = $pdf->output();
            file_put_contents(public_path().'/documents/cargos/'.$codigo.'.pdf', $output);

            $docs['codigo'] = $codigo;
            $docs['id_area'] = $doc->area;
            $docs['id_persona'] = $doc->persona;
            $docs['url'] = '/documents/cargos/'.$codigo.'.pdf';
            $docs['tipo'] = 1;
            $docs['num'] = $num_doc;
            $docs['estado'] = 0;
            $docs['fecha'] = $ldate;
            $docs['id_usuario'] = Auth::id();
            AreaPersona::create($docs);

            $this->bloquearBienes( $doc->area, $doc->persona);
            $this->response['mensaje'] = 'PDF';
            $this->response['estado'] = true;
            $this->response['datos'] = $docs;
            return response()->json($this->response, 200);
            
        }

    }

    private function bloquearBienes( $id_a, $id_p ){
        $bienes = DB::select('SELECT * from inventario WHERE id_area =  "'.$id_a.'" AND id_persona = '.$id_p.';');
        foreach ($bienes as $p) {
            $this->cambiar($p, 0);
        }
    }

    private function cambiar($bienes, $estado){
        $res = Inventario::find($bienes->id);
        $res->estado = $estado;
        $res->save();
        // $this->response['datos'] = $res;
        // return response()->json($this->response, 200);
    }

    public function PDFBienesBorrador($idP,$idArea){

        $num_doc = 1;
        $data = [ 'title' => 'Borrador'];
        $oficina = DB::select('SELECT * from oficina WHERE iduoper = "'. $idArea .'";');
        $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno, persona.idtipoper FROM persona WHERE persona.id =' . $idP);
        $r2 = DB::select('SELECT * FROM persona WHERE ID IN ( SELECT idpersona_otro from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ');');
        if($r2 != null){ $responsable2 = $r2[0]; }
        else { $responsable2 = null; }

        $inventaristas = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ');');
        $bienes = DB::select('SELECT * from inventario WHERE  id_area = "'.$idArea.'" AND id_persona = ' . $idP . ';');
        $ldate = date('Y-m-d');
        $lhour = date('H:i:s');

        $pdf = SnappyPdf::loadView('cargos.cargo', compact('bienes','oficina','inventaristas','ldate','lhour',));
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('no-stop-slow-scripts', true); 

        $pdf->setOptions([
            'header-html'=>view('cargos._headercargo',compact('oficina','responsable','responsable2','num_doc')),
            'footer-html'=>view('cargos._footercargo'),
            'margin-bottom'=>'4.1cm',
            'margin-left'=>'0.5cm',
            'margin-right'=>'0.5cm',
            'margin-top'=>'3.6cm',
            'encoding'=>'UTF-8',
            'orientation'=>'landscape',
            'page-size'=>'a4'
        ]);

        $pdf->output();

        $codigo = $this->getCodigo('CBB');

        $output = $pdf->output();
        file_put_contents(public_path().'/documents/borradores/'.$codigo.'.pdf', $output);

        $doc['codigo'] = $codigo;
        $doc['id_area'] = $idArea;
        $doc['id_persona'] = $idP;
        $doc['url'] = '/documents/borradores/'.$codigo.'.pdf';
        $doc['tipo'] = 2;
        $doc['estado'] = 1;
        $doc['fecha'] = $ldate;
        $doc['id_usuario'] = Auth::id();
        AreaPersona::create($doc);
        
        $this->response['mensaje'] = 'PDF';
        $this->response['estado'] = true;
        $this->response['datos'] = $doc;
        return response()->json($this->response, 200);        
    }

    public function pdfCubiculosIMP(Request $response){
        $area = $response->area;
        $persona = $response->persona;
        $this->PDFcubiculos($persona,$area);
        $this->PDFcubiculosR($response->persona,$response->persona2,$response->area);
        $this->PDFcubiculos($response->persona2,$area);
    }

    private function PDFcubiculos($idP,$idArea){

        $num_doc = 1;
        $data = [ 'title' => 'Borrador'];
        $oficina = DB::select('SELECT * from oficina WHERE iduoper = "'. $idArea .'";');
        $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno, persona.idtipoper FROM persona WHERE persona.id =' . $idP);
        $r2 = DB::select('SELECT * FROM persona WHERE ID IN ( SELECT idpersona_otro from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ');');

        $responsable2 = null;

        $inventaristas = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = "' . $idArea . '" and id_persona != ' . $idP . ');');
        $bienes = DB::select('SELECT * from inventario WHERE  id_area = "'.$idArea.'" AND id_persona = ' . $idP . ' AND idpersona_otro IS null'.';');
        $ldate = date('Y-m-d');
        $lhour = date('H:i:s');

        $pdf = SnappyPdf::loadView('cargos.cargo', compact('bienes','oficina','inventaristas','ldate','lhour',));
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('no-stop-slow-scripts', true); 

        $pdf->setOptions([
            'header-html'=>view('cargos._headercargo',compact('oficina','responsable','responsable2','num_doc')),
            'footer-html'=>view('cargos._footercargo'),
            'margin-bottom'=>'4.1cm',
            'margin-left'=>'0.5cm',
            'margin-right'=>'0.5cm',
            'margin-top'=>'3.6cm',
            'encoding'=>'UTF-8',
            'orientation'=>'landscape',
            'page-size'=>'a4'
        ]);

        $pdf->output();

        $codigo = $this->getCodigo('CBB');

        $output = $pdf->output();
        file_put_contents(public_path().'/documents/borradores/'.$codigo.'.pdf', $output);

        $doc['codigo'] = $codigo;
        $doc['id_area'] = $idArea;
        $doc['id_persona'] = $idP;
        $doc['url'] = '/documents/borradores/'.$codigo.'.pdf';
        $doc['tipo'] = 2;
        $doc['estado'] = 1;
        $doc['fecha'] = $ldate;
        $doc['id_usuario'] = Auth::id();
        AreaPersona::create($doc);
        
    }

    public function PDFcubiculosR($idP,$idP2,$idArea){

        $num_doc = 1;
        $data = [ 'title' => 'Borrador'];
        $oficina = DB::select('SELECT * from oficina WHERE iduoper = "'. $idArea .'";');
        $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno, persona.idtipoper FROM persona WHERE persona.id =' . $idP);
        $r2 = DB::select('SELECT * FROM persona WHERE ID IN ( SELECT idpersona_otro from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ');');
        if($r2 != null){ $responsable2 = $r2[0]; }
        else { $responsable2 = null; }

        $inventaristas = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ');');
        $bienes = DB::select('SELECT * from inventario WHERE  id_area = "'.$idArea.'" AND id_persona = ' . $idP . ' AND idpersona_otro ='.$idP2.';');
        $ldate = date('Y-m-d');
        $lhour = date('H:i:s');

        $pdf = SnappyPdf::loadView('cargos.cargo', compact('bienes','oficina','inventaristas','ldate','lhour',));
        $pdf->setOption('enable-javascript', true);
        $pdf->setOption('no-stop-slow-scripts', true); 

        $pdf->setOptions([
            'header-html'=>view('cargos._headercargo',compact('oficina','responsable','responsable2','num_doc')),
            'footer-html'=>view('cargos._footercargo'),
            'margin-bottom'=>'4.1cm',
            'margin-left'=>'0.5cm',
            'margin-right'=>'0.5cm',
            'margin-top'=>'3.6cm',
            'encoding'=>'UTF-8',
            'orientation'=>'landscape',
            'page-size'=>'a4'
        ]);

        $pdf->output();

        $codigo = $this->getCodigo('CBB');

        $output = $pdf->output();
        file_put_contents(public_path().'/documents/borradores/'.$codigo.'.pdf', $output);

        $doc['codigo'] = $codigo;
        $doc['id_area'] = $idArea;
        $doc['id_persona'] = $idP;
        $doc['url'] = '/documents/borradores/'.$codigo.'.pdf';
        $doc['tipo'] = 2;
        $doc['estado'] = 1;
        $doc['fecha'] = $ldate;
        $doc['id_usuario'] = Auth::id();
        AreaPersona::create($doc);
        
    }

    private function getCodigo($name){
        if (AreaPersona::max('id') > 0 ){ $nro = AreaPersona::max('id')+1; }
        else { $nro = 1; }
        if ($nro < 10) { $codigo = $name.'-'.date('d').date('m').date('Y').'-000000'.$nro; }
        if ($nro > 9 && $nro < 100) { $codigo = $name.'-'.date('d').date('m').date('Y').'-00000'.$nro; }
        if ($nro > 99 && $nro < 1000) { $codigo = $name.'-'.date('d').date('m').date('Y').'-0000'.$nro; }
        if ($nro > 999 && $nro < 10000) { $codigo = $name.'-'.date('d').date('m').date('Y').'-000'.$nro; }
        if ($nro > 9999 && $nro < 100000) { $codigo = $name.'-'.date('d').date('m').date('Y').'-00'.$nro; }
        if ($nro > 99999 && $nro < 1000000) { $codigo = $name.'-'.date('d').date('m').date('Y').'-0'.$nro; }
        return $codigo;
    }


    public function reportSnappy(){
        $data = Inventario::limit(100)->get(); 
        $pdf = SnappyPdf::loadView('cargos.cargo',compact('data'));
        return $pdf->setOptions([
            'header-html'=> view('cargos._headercargo'),
            'footer-html'=> view('cargos._footercargo'),
            'margin-bottom'=>'1cm',
            'margin-top'=>'1cm',
            'encoding'=>'UTF-8',    
            'orientation'=>'landscape',
            'page-size'=>'a4'
        ])->inline('report.pdf');
    }

    public function inventarioFisico(){
        $pdf = SnappyPdf::loadView('inventarioFisico.inventariofisico');
        return $pdf->setOptions([
            'header-html'=> view('inventarioFisico._header'),
            'footer-html'=> view('inventarioFisico._footer'),
            'margin-bottom'=>'1cm',
            'margin-top'=>'2cm',
            'encoding'=>'UTF-8',    
            'orientation'=>'landscape',
            'page-size'=>'a4'
        ])->inline('report.pdf');
    }

}
