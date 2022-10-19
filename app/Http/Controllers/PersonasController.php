<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Persona;
use Illuminate\Http\Request;
use Inertia\Inertia;


class PersonasController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Personas/');
    }

    public function getPersonas()
    {
        $res = Persona::select()->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
}
