<?php

namespace App\Http\Controllers\Inventario;

use App\Http\Controllers\Controller;
use App\Models\Bienk;
use App\Models\Inventario;

class InventarioController extends Controller
{
    protected $bienK;
    public function __construct()
    {
        $this->bienK = new Bienk;
    }
    public function getBienesByCode($codigo)
    {
        $res = $this->bienK->searchDataByCode($codigo);
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

   
}
