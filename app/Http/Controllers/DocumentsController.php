<?php

// use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use App\Models\AreaPersona;

//Auth::routes();
use App\Models\Documento;
use App\Models\Inventario;
//use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Facades\File;

class DocumentsController extends Controller {

    public function getDocuments(){
        $res = Documento::select()->orderBy('id', 'DESC')->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    // public function verReportes(){

    //     return Inertia::render('Admin/ExploradorDocs/',['documents' => Document::all() ]);

    // }

    // public function cerrarInventario(){

    //     return Inertia::render('Admin/Cierre/',[ ]);

    // }
    public function saveDocument(Request $request)
    {
        $ldate = date('Y-m-d');

            $document = AreaPersona::create([
                'codigo' => $request->codigo,
                'id_area' => $request->id_area,
                'id_persona' => $request->id_persona,
                'url' => $request->url,
                'tipo'=> 1,
                'estado' => 0,
                'fecha' => $ldate,
            ]);
            $this->response['mensaje'] = 'Documento creado con exito';
            $this->bloquearBienes( $request->id_area, $request->id_persona);
            $this->response['estado'] = true;
            $this->response['datos'] = $document;

        return response()->json($this->response, 200);
    }

    public function bloquearBienes( $id_a, $id_p ){
        $bienes = DB::select('SELECT * from inventario WHERE id_area =  '.$id_a.' AND id_persona = '.$id_p.';');

        foreach ($bienes as $p) {
            $this->cambiar($p, 0);
        }
    }

    public function desbloquearBienes($id){
        $res = AreaPersona::find($id);
        $res->estado = 1;
        $res->save();
        $bienes = DB::select('SELECT * from inventario WHERE id_area =  '.$res->id_area.' AND id_persona = '.$res->id_persona.';');
        foreach ($bienes as $p) {
            $this->cambiar($p, 1);
        }
    }

    public function cambiar($bienes, $estado){
        $res = Inventario::find($bienes->id);
        $res->estado = $estado;
        $res->save();
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function create()
    {

    }
    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id) {

    }

    public function destroy($id){
        $document = AreaPersona::find($id);
        File::delete(public_path("$document->url"));
        $document->delete();
        return "Documento Eliminado";
    }

    public function store(Request $request)
    {

    }
}
