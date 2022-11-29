<?php



namespace App\Http\Controllers;

use App\Models\AreaPersona;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class ReportesController extends Controller
{
    public function getDocuments()
    {
        //$res = AreaPersona::select()->orderBy('id', 'DESC')->get();
        $res = DB::select('SELECT area_persona.*, area_persona.fecha, oficina.nombre, persona.dni FROM ((area_persona INNER JOIN oficina ON area_persona.id_area = oficina.iduoper)INNER JOIN persona ON area_persona.id_persona = persona.id) ORDER BY area_persona.id desc;
        ');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getDocumentsActivos()
    {
        //$res = AreaPersona::select()->orderBy('id', 'DESC')->get();
        $res = DB::select('SELECT area_persona.*, area_persona.fecha, area.nombre, persona.dni FROM ((area_persona INNER JOIN area ON area_persona.id_area = area.id)INNER JOIN persona ON area_persona.id_persona = persona.id) WHERE ESTADO = 0 ORDER BY area_persona.id desc;
        ');
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getDocumentsF($estado, $i, $f_fin)
    {
        $count = null;
        if ($estado == 2) {
            $res = DB::select('SELECT area_persona.*, area_persona.fecha, oficina.nombre, persona.dni FROM ((area_persona INNER JOIN oficina ON area_persona.id_area = oficina.iduoper)INNER JOIN persona ON area_persona.id_persona = persona.id) WHERE fecha BETWEEN ' . $i . ' AND ' . $f_fin . ' ORDER BY area_persona.id desc;');
            $count = DB::select('SELECT count(persona.dni) as registros FROM ((area_persona INNER JOIN area ON area_persona.id_area = area.id)INNER JOIN persona ON area_persona.id_persona = persona.id) WHERE fecha BETWEEN ' . $i . ' AND ' . $f_fin . ' ORDER BY area_persona.id desc;');
        } else {
            //$res = AreaPersona::select()->orderBy('id', 'DESC')->get();
            $res = DB::select('SELECT area_persona.*, area_persona.fecha, oficina.nombre, persona.dni FROM ((area_persona INNER JOIN oficina ON area_persona.id_area = oficina.iduoper)INNER JOIN persona ON area_persona.id_persona = persona.id) WHERE fecha BETWEEN ' . $i . ' AND ' . $f_fin . ' AND ESTADO != ' . $estado . ' ORDER BY area_persona.id desc;');
            $count = DB::select('SELECT count(persona.dni) as registros FROM ((area_persona INNER JOIN oficina ON area_persona.id_area = oficina.iduoper)INNER JOIN persona ON area_persona.id_persona = persona.id) WHERE fecha BETWEEN ' . $i . ' AND ' . $f_fin . ' AND ESTADO != ' . $estado . ' ORDER BY area_persona.id desc;');
        }

        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['count'] = $count;
        return response()->json($this->response, 200);
    }

    public function getDocumentsFP(Request $request)
    {
        //       $res = DB::select('SELECT area_persona.*, area_persona.fecha, area.nombre, persona.dni FROM ((area_persona INNER JOIN area ON area_persona.id_area = area.id)INNER JOIN persona ON area_persona.id_persona = persona.id) WHERE fecha BETWEEN '.$i.' AND '.$f_fin.' AND ESTADO != '.$estado.' ORDER BY area_persona.id desc;');
        $res = AreaPersona::select('*')
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('dni', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('codigo', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('nombre', 'LIKE', '%' . $request->term . '%')
                    ->whereBetween('fecha', [$request->inicio, $request->fin])
                    ->where('estado');
            })->paginate(10);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }




    public function index()
    {
        return Inertia::render('Admin/Reportes/');
    }

    public function dashboard()
    {
        return Inertia::render('Admin/Reportes/Reportes/index.vue');
    }

    

    public function preview($idArea, $idP)
    {
//        $oficina = DB::select('SELECT oficina.id, oficina.codigo, oficina.nombre FROM oficina WHERE oficina.id IN (SELECT area.id_oficina FROM area WHERE area.id =' . $idArea . ')');
        $oficina = DB::select('SELECT * from oficina WHERE iduoper = "'. $idArea .'";');
        $responsable = DB::select('SELECT persona.dni, persona.nombres, persona.paterno, persona.materno FROM persona WHERE persona.id =' . $idP);
        $datos['bienes'] = DB::select('SELECT * from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ';');
        $datos['lfecha'] = date('Y-m-d');
        $datos['lhour'] = date('H:i:s');
        $datos['inventaristas'] = DB::select('SELECT * FROM users WHERE ID IN ( SELECT ID_USUARIO from inventario WHERE id_area = "' . $idArea . '" and id_persona = ' . $idP . ');');
        $datos['oficina'] = $oficina[0];
       // $datos['area'] = $area[0];  
        $datos['responsable'] = $responsable[0];
        //        $res = DB::select('SELECT * from area_persona where id_persona = '.$idP.' and id_area = '.$idArea.';');
        return Inertia::render('Admin/Reportes/Preview/',  ['datos' => $datos]);
    }

    public function generador()
    {
        return Inertia::render('Admin/Reportes/');
    }
    public function explorador()
    {
        return Inertia::render('Admin/Explorador/');
    }

    /*******  REPORTES *****/
    public function avanceGlobal()
    {
        $h = date('Y-m-d');

        $actual = DB::select('SELECT count(*) as registros from inventario;');
        $antes = DB::select('SELECT count(*) as registros from bienk;');
        $ayer = DB::select('SELECT count(*) as registros FROM `inventario` WHERE date(created_at) = DATE_ADD(CURRENT_DATE, INTERVAL -1 DAY);');
        $hoy = DB::select('SELECT count(*) as registros FROM `inventario` WHERE date(created_at) = CURRENT_DATE;');

        $this->response['estado'] = true;
        $this->response['g_actual'] = $actual[0];
        $this->response['g_antes'] = $antes[0];
        $this->response['g_ayer'] = $ayer[0];
        $this->response['g_hoy'] = $hoy[0];
        return response()->json($this->response, 200);
    }

    public function ranking()
    {
        $h = date('Y-m-d');
        $avanceDiario = DB::select('SELECT users.NOMBRES, users.APELLIDOS, inventario.ID_USUARIO, COUNT(inventario.codigo) AS NREGISTROS FROM inventario INNER JOIN users ON inventario.ID_USUARIO = users.ID GROUP BY inventario.ID_USUARIO  ORDER BY NREGISTROS DESC ;');
        $this->response['estado'] = true;
        $this->response['avance_diario'] = $avanceDiario;
        return response()->json($this->response, 200);
    }

    public function avanceCargos()
    {

        $cargos = DB::select('SELECT count(*) as registros FROM area_persona where estado = 0');
        //     $totalCargos = DB::select('SELECT COUNT(DISTINCT id_area, id_persona) as registros from bienk ');
        $nOficinas = DB::select('SELECT COUNT(*) as registros from oficina where id IN (SELECT area.id_oficina from area where id in (SELECT id_area FROM area_persona))');
        $totalCargosInv = DB::select('SELECT COUNT(DISTINCT id_area, id_persona) as registros from inventario');
        $nAreas = DB::select('SELECT count(area.id_oficina) as registros from area where id in (SELECT id_area FROM area_persona)');

        $this->response['estado'] = true;
        $this->response['cargos'] = $cargos[0];
        $this->response['nOficinas'] = $nOficinas[0];
        $this->response['nAreas'] = $nAreas[0];
        $this->response['totalCargosInv'] = $totalCargosInv[0];
        return response()->json($this->response, 200);
    }

    public function regDiario()
    {

        $diario = DB::select('SELECT COUNT(*) AS REGISTROS, date(created_at) as FECHA FROM inventario WHERE date(created_at) <= CURRENT_DATE GROUP BY date(created_at) ORDER BY date(created_at) DESC LIMIT 5;');
        //$cont = 5;
        $n = $this->sz($diario);
        $regs = [];
        for ($i = 0, $n; $n >= 0; $n--, $i++) {
            $regs[$i] = $diario[$n];
        }
        $registros = [];
        $fechas = [];

        foreach ($regs as $key => $registro) {
            $registros[$key] = $registro->REGISTROS;
            $fechas[$key] = $registro->FECHA;
        }
        $this->response['estado'] = true;
        $this->response['datos'] = $diario;
        $this->response['registros'] = $registros;
        $this->response['fechas'] = $fechas;
        return response()->json($this->response, 200);
    }

    public function regDiarioG()
    {

        $diario = DB::select('SELECT COUNT(*) AS REGISTROS, date(created_at) as FECHA FROM inventario WHERE date(created_at) <= CURRENT_DATE GROUP BY date(created_at) ORDER BY date(created_at) DESC;');
        $registros = DB::select('SELECT inventario.id, inventario.codigo, inventario.descripcion, inventario.estado,  DATE(inventario.created_at) as fecha, oficina.nombre as area, CONCAT(users.nombres, users.apellidos) as usuario FROM inventario JOIN oficina ON inventario.id_area = oficina.iduoper JOIN users on inventario.id_usuario = users.id  WHERE  date(inventario.created_at) <= CURRENT_DATE ORDER BY DATE(inventario.created_at) DESC;');
        $this->response['datos'] = $diario;
        $this->response['registros'] = $registros;
        return response()->json($this->response, 200);
    }

    public function RegXdia($fecha)
    {
        $regDiario = DB::select('SELECT inventario.*, oficina.nombre as a FROM inventario JOIN oficina ON inventario.id_area = oficina.iduoper where DATE(inventario.created_at) = ' . $fecha);
        $this->response['registros'] = $regDiario;
        return response()->json($this->response, 200);
    }

    public function OficinasAvanzadas()
    {
        $oficina = DB::select('SELECT DISTINCT oficina.iduoper from inventario LEFT JOIN oficina on inventario.id_area = oficina.iduoper;');
        $oficinas = [];

        foreach ($oficina as $key => $registro) {
            $ofi = DB::select('SELECT COUNT(inventario.id) as registros, oficina.* from inventario JOIN oficina ON inventario.id_oficina = oficina.iduoper WHERE oficina.iduoper = ' . $registro->id . ";");
            $oficinas[$key] = $ofi[0];
        }

        $this->response['oficinas'] = $oficinas;
        return response()->json($this->response, 200);
    }

    public function OficinasAvanzadasCargos()
       {

        $oficina = DB::select('SELECT oficina.* from area_persona JOIN oficina ON area_persona.id_area = oficina.iduoper GROUP BY oficina.iduoper;');
        $oficinas = [];

        foreach ($oficina as $key => $registro) {
            $ofi = DB::select('SELECT COUNT(area_persona.id) as registros, oficina.* from area_persona JOIN oficina ON area_persona.id_area = oficina.iduoper JOIN oficina ON area.id_oficina = oficina.iduoper WHERE oficina.iduoper = ' . $registro->id . " AND estado = 0;");
            $oficinas[$key] = $ofi[0];
        }

        $this->response['oficinas'] = $oficinas;
        return response()->json($this->response, 200);
    }

    public function getCountOficina($idO)
    {
        $oficina = DB::select('SELECT COUNT(inventario.id) as registros, oficina.id from inventario JOIN oficina ON inventario.id_area = oficina.iduoper  WHERE oficina.iduoper = ' . $idO . ';');
        $this->response['oficina'] = $oficina;
        return response()->json($this->response, 200);
    }

    public function getCountArea($id)
    {
        $areas = DB::select('SELECT area.id, area.nombre, area.codigo, count(area.codigo) as registros from inventario JOIN area ON inventario.id_area = area.id JOIN oficina ON area.id_oficina = oficina.id WHERE area.id_oficina = ' . $id . ' GROUP BY area.id');
        $this->response['areas'] = $areas;
        return response()->json($this->response, 200);
    }
    public function getCountAreaCargos($id)
    {
        $areas = DB::select('SELECT area.id, area.nombre, area.codigo, count(area.codigo) as registros from area_persona JOIN area ON area_persona.id_area = area.id JOIN oficina ON area.id_oficina = oficina.id WHERE area.id_oficina = ' . $id . ' AND estado = 0 GROUP BY area.id');
        $this->response['areas'] = $areas;
        return response()->json($this->response, 200);
    }

    public function getCargrosByArea($id)
    {
        $cargos = DB::select('SELECT area_persona.codigo, area_persona.url, concat(persona.nombres," ",persona.paterno," ",persona.materno) as nombre from area_persona JOIN persona on persona.id = area_persona.id WHERE id_area = ' . $id . ' AND estado = 0');
        $this->response['cargos'] = $cargos;
        return response()->json($this->response, 200);
    }

    private function sz($array)
    {
        $cont = 0;
        foreach ($array as $key => $item) {
            $cont = $key;
        }
        return $cont;
    }
}
