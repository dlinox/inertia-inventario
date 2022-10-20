<?php

// use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers;

use App\Models\AreaPersona;

//Auth::routes();
use App\Models\Documento;
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
        $document = Documento::find($id);
        File::delete(public_path("$document->url"));

        $document->delete();

        return "Documento Eliminado";
    }

    public function store(Request $request)
    {

    }
}
