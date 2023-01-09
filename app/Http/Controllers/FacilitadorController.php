<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Inventario;
use App\Models\Oficina;
use Database\Seeders\UsuariosDemo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExports;

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

    public function export()
    {
        $date = date('d-m-Y');
        return Excel::download(new InventarioExports, 'inventario' . $date . '.xlsx');
    }

    public function getBienesAll(){
        $res = DB::select('SELECT inventario.id, 
        inventario.tipo, inventario.idreg_anterior, inventario.cod_ubicacion, inventario.cuenta, inventario.codigo, inventario.descripcion, inventario.modelo, 
        inventario.marca, inventario.medidas, inventario.color, inventario.observaciones, inventario.idbienk, inventario.corr_area AS Areas, inventario.corr_num AS corr, 
        inventario.estado_uso, inventario.num_ambiente, 
        persona.dni, CONCAT(persona.nombres," ", persona.paterno," ",persona.materno) ,
        oficina.dependencia, oficina.nombre AS oficina, 
        CONCAT(users.nombres," ", users.apellidos) AS inventariador
        FROM inventario 
        left join persona ON inventario.id_persona = persona.id
        left join oficina ON inventario.id_area = oficina.iduoper
        left join users ON inventario.id_usuario = users.id
        ORDER BY(inventario.corr_area)');
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);

        // $date = date('d-m-Y');
        
        // return Excel::download(new InventarioExports, 'inventario' . $date . '.xlsx');
    }



   //Mantenimiento de oficinas y Personas
    public function viewOficinas(){
        return Inertia::render('Facilitador/Mantenimiento/Oficinas');   
    }

    public function guardarOficina(Request $request ){
        $oficina = new Oficina();
        $oficina->iduoper = $request->input('iduoper');
        $oficina->nombre = $request->input('nombre');
        $oficina->dependencia = $request->input('dependencia');
        $oficina->save();
        //$this->asignarGrupo($request->input('iduoper'));

        $dep = Str::substr($oficina->iduoper,0,2);
        $usuarios = DB::select('SELECT DISTINCT id_usuario FROM grupo 
        WHERE SUBSTRING(id_oficina,1,2) = '.$dep.';');        
    
        foreach ($usuarios as $us){
            $this->asignarGrupo($oficina->iduoper, $us->id_usuario);   
        }

    }

    private function asignarGrupo($iduoper, $id_usuario){
        $grupo = new Grupo();
        $grupo->id_oficina = $iduoper;
        $grupo->id_usuario = $id_usuario;
        $grupo->save();
    
    }

    public function getOFicinasF(Request $request)
    {
        $query_where = [];
        if ($request->dependencia) array_push($query_where, [DB::raw('substr(iduoper, 1, 2)'), '=', $request->dependencia]);
        //DB::raw("CONCAT( hor_inicio , ' - ' , hor_fin) as horario")
        $res = Oficina::select(
            'oficina.*',
         )
            ->where($query_where)
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('oficina.iduoper', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('oficina.dependencia', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('oficina.nombre', 'LIKE', '%' . $request->term . '%');
            })->orderBy('oficina.ide', 'DESC')
            ->paginate(150);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function viewPersonas(){
        return Inertia::render('Facilitador/Mantenimiento/Personas');   
    }

}
