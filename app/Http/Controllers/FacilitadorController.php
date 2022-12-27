<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class FacilitadorController extends Controller
{
    public function index()
    {
        return Inertia::render('Facilitador/Dashboard');
    }
    public function viewGlobal()
    {
        return Inertia::render('Facilitador/Reporte/global');
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

    public function ReporteGlobaldia($fecha){
        $datos = [];
        $res = DB::select('SELECT users.equipo as equipo, users.id as uid, users.nombres, users.apellidos, dependencia, count(inventario.id) as reg
        from inventario
        LEFT JOIN oficina ON oficina.iduoper = inventario.id_area 
        JOIN users ON users.id = inventario.id_usuario 
        WHERE date(inventario.created_at) <= "'.$fecha.'" 
        AND inventario.id_usuario 
        IN (SELECT users.id FROM users WHERE equipo IN (SELECT distinct equipo FROM users))
        GROUP BY oficina.dependencia, users.id order by equipo;');

        $deps = [];        
        $usuarios = [];
        $i=0;
        $total = 0;
        $temp = 0;

        foreach ($res as $item) { 
            
            $e = $this->existe($item, $datos);
            $data[$i] = $this->existe($item, $datos);
            $total = $total + $item->reg;
    
            if ( $e == true ){
                if($i != 0){
                    $temp = $temp + $item->reg; 
                    $datos[$i-1]['reg'] = $datos[$i-1]['reg'] + $item->reg;                                    
                    $datos[$i-1]['usuarios']['dos'] = $item->apellidos." ".$item->nombres;
                    $datos[$i-1]['usuarios']['dosR'] =  $item->reg;
                    $us['id'] = $item->uid; 
                    $us['nombre'] = $item->apellidos." ".$item->nombres;

                    $ite = $this->compararU($us, $usuarios);

                    if( $ite != 999999) {    
                        $usuarios[$ite]['regis'] = $usuarios[$ite]['regis'] + $item->reg;    
                        $datos[$i-1]['users'] = $usuarios;                   
                    } else {
                        $us['regis'] = $item->reg;
                        array_push($usuarios, $us);
                        $datos[$i-1]['users'] = $usuarios;                    
                    }
                    
                    if($this->comparar($item->dependencia, $deps) == false) {
                        array_push($deps,$item->dependencia);
                        $datos[$i-1]['dependencia'] = $deps;                    
                    }
                }

            }else{
                $temp += $item->reg;
                $deps = [];
                $usuarios = [];
                $datos[$i]['equipo'] = $item->equipo;            
                $datos[$i]['reg'] = $item->reg;
                $datos[$i]['usuarios']['uno'] = $item->nombres." ".$item->apellidos;
                $datos[$i]['usuarios']['unoR'] = $item->reg;
                array_push($deps,$item->dependencia);
                $user['id'] = $item->uid;
                $user['nombre'] = $item->apellidos." ".$item->nombres;
                $user['regis'] = $item->reg;
                array_push($usuarios, $user);
                $datos[$i]['users'] = $usuarios;
                $datos[$i]['dependencia'] = $deps;
                $i++;
            }            
         } 
        $this->response['datos'] = $datos;
        $this->response['total'] = $total;
        return response()->json($this->response, 200);
    }
    
    //CONCILIACION
    public function getDependencias(){
        $res = DB::select('SELECT distinct substring(inventario.id_area,1,2) as iduoper,oficina.dependencia 
        FROM inventario
        JOIN oficina ON inventario.id_area = oficina.iduoper;');

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);

    }

    public function ConciliacionFac(){
        return Inertia::render('Facilitador/Conciliacion/Conciliacion');   
    }

    public function getBienesAF($page, $dependencia)
    {
        $limit = 30;
        $ofs = ($page-1)*$limit;
        $res = DB::select('SELECT *,oficina.dependencia, oficina.iduoper, persona.nombres, persona.paterno, persona.materno FROM bienk 
        JOIN oficina ON oficina.iduoper = bienk.id_area
        LEFT JOIN persona ON persona.dni = bienk.persona_dni
        WHERE bienk.tipo="ACTIVO FIJO"
        AND cod_ubicacion LIKE "'.$dependencia.'%"
        AND (bienk.codigo NOT IN (SELECT inventario.codigo FROM inventario WHERE codigo IS not NULL)) LIMIT 30 OFFSET '.$ofs);
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

 
    public function getBienesND($page, $dependencia)
    {
        $limit = 30;
        $ofs = ($page-1)*$limit;
        $res = DB::select('SELECT *,oficina.dependencia, oficina.iduoper, persona.nombres, persona.paterno, persona.materno FROM bienk 
        JOIN oficina ON oficina.iduoper = bienk.id_area
        LEFT JOIN persona ON persona.dni = bienk.persona_dni
        WHERE bienk.tipo="NO DEPRECIABLE"
        AND cod_ubicacion LIKE "'.$dependencia.'%"
        AND (bienk.codigo NOT IN (SELECT inventario.codigo FROM inventario WHERE codigo IS not NULL)) LIMIT 30 OFFSET '.$ofs);
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
    public function getBienesSobrantes($page, $dependencia)
    {
        $limit = 30;
        $ofs = ($page-1)*$limit;
        $res = DB::select('SELECT *,oficina.dependencia, oficina.iduoper, persona.nombres, persona.paterno, persona.materno FROM inventario 
        JOIN oficina ON oficina.iduoper = inventario.id_area
        LEFT JOIN persona ON persona.id = inventario.id_persona
        WHERE inventario.codigo is null
        AND inventario.codigo_anterior IS NULL
        AND SUBSTRING(inventario.corr_area,1,2) = "'.$dependencia.'" 
        LIMIT 30 OFFSET '.$ofs);
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
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

    private function compararU($item, $data){
        $est=999999;
        $tm = $this->sz($data);
        for($l=0; $l<=$tm; $l++){
            if( $data[$l]['id'] == $item['id']){
                $est = $l;
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

    public function getBienesAll(){
        $res = Inventario::select('inventario.id', 'tipo', 'idreg_anterior', 'cod_ubicacion', 'cuenta', 'codigo', 'descripcion', 'modelo', 'marca', 'medidas', 'color', 'observaciones', 'idbienk', 'corr_area', 'corr_num', 'estado_uso', 'num_ambiente', 'persona.dni AS responsable')
        ->join('persona','inventario.id_persona', '=', 'persona.id')->get();
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
    

}
