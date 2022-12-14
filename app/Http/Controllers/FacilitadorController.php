<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FacilitadorController extends Controller
{
    public function index()
    {
        return Inertia::render('Facilitador/Dashboard');
    }

    public function bienesSinCodigo(){
        return Inertia::render('Facilitador/Inventario/BienesSinCodigo');
    }

    public function Reportex(){
        return Inertia::render('Facilitador/Reporte/');

    }

    public function Reportedia($fecha){
        $datos = [];
        $res = DB::select('SELECT users.equipo as equipo, users.nombres, users.apellidos, dependencia, count(inventario.id) as reg
        from inventario
        JOIN oficina ON oficina.iduoper = inventario.id_area 
        JOIN users ON users.id = inventario.id_usuario 
        WHERE date(inventario.created_at) = "'.$fecha.'"
        AND inventario.id_usuario 
        IN (SELECT users.id FROM users WHERE equipo IN (SELECT distinct equipo FROM users))
        GROUP BY oficina.dependencia, users.id order by equipo;');

        $deps = [];        
        $i=0;
        $total = 0;

        foreach ($res as $item) { 
            
            $e = $this->existe($item, $datos);
            $data[$i] = $this->existe($item, $datos);
            $total = $total + $item->reg;

            if ( $e == true ){
                if($i != 0){
                    $datos[$i-1]['reg'] = $datos[$i-1]['reg'] + $item->reg;                
                    $datos[$i-1]['usuarios']['dos'] = $item->apellidos." ".$item->nombres;
                    $datos[$i-1]['usuarios']['dosR'] = $item->reg;
                    if($this->comparar($item->dependencia, $deps) == false){
                        array_push($deps,$item->dependencia);
                        $datos[$i-1]['dependencia'] = $deps;                    
                    }
                 }

            }else{
                $deps = [];
                $tm = 0;
                $datos[$i]['equipo'] = $item->equipo;            
                $datos[$i]['reg'] = $item->reg;
                $datos[$i]['usuarios']['uno'] = $item->nombres." ".$item->apellidos;
                $datos[$i]['usuarios']['unoR'] = $item->reg;
                array_push($deps,$item->dependencia);
                $datos[$i]['dependencia'] = $deps;
                $i++;
            }            
         } 
        $this->response['datos'] = $datos;
        $this->response['total'] = $total;
        return response()->json($this->response, 200);
    }

    private function existe($item, $data){
        $existe = false;
        foreach ($data as $it) {
            if($it['equipo'] == $item->equipo ){
                $existe = true;
            }
        }
        return $existe;
    }

    private function comparar($item, $data){
        $est=false;
        $tm = $this->sz($data);
        for($l=0; $l<=$tm; $l++){
            if( $data[$l] == $item){
                $est = true;
            }
        }
        return $est;
    }

    private function sz( $array){
        $cont = 0;
        foreach ($array as $key => $item) {
            $cont = $key;
        }
        return $cont;
    }


    

}
