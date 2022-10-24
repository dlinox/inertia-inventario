<?php

namespace App\Http\Controllers;

use App\Models\AreaPersona;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportesController extends Controller
{
    public function getDocuments(){
        $res = AreaPersona::select()->orderBy('id', 'DESC')->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
    public function index()
    {
        return Inertia::render('Admin/Reportes/');
    }
    public function generador()
    {
        return Inertia::render('Admin/Reportes/');
    }
    public function explorador(){
        return Inertia::render('Admin/Explorador/');
    }

}
