<?php

namespace App\Http\Controllers;

use App\Exports\BienkExport;
use App\Models\Area;
use App\Models\Bienk;
use App\Models\Estado;
use App\Models\Inventario;
use App\Models\IventarioOld;
use App\Models\Oficina;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InventarioExports;
use Inertia\Inertia;

class InventarioController extends Controller
{
    protected $bienK;
    protected $inventario;

    protected $correlativos;

    public function __construct()
    {
        $this->bienK = new Bienk;
        $this->inventario = new Inventario;
        $this->correlativos = [];
    }

    public function index()
    {
        return Inertia::render('Admin/Inventarios/');
    }

    public function viewPerfilInventario(Request $request)
    {
        $current_user = Auth::user();

        $datos =
            [
                'id' => $current_user->id,
                'nombres' => $current_user->nombres,
                'apellidos' => $current_user->apellidos,
                'email' => $current_user->email,
                'rol' => $current_user->rol,
            ];

        return Inertia::render('Inventario/Perfil', ['datos' => $datos]);
    }

    public function getInventarioByCode(Request $request)
    {
        $res = IventarioOld::select('*')
            //->join('area', 'area.id', '=', 'id_area')
            //->join('oficina', 'oficina.id', '=', 'area.id_oficina')
            ->where('codigo', $request->codigo)
            ->first();

        if (!$res) {
            $this->response['mensaje'] = 'Error, codigo no encontrado';
            $this->response['estado'] = false;
            $this->response['codigo'] = $request->codigo;

            return response()->json($this->response, 200);
        }


        $existe = Inventario::select('codigo')
            ->where('codigo', $res->codigo)
            ->first();

        if ($existe) {
            $this->response['error'] = true;
            $this->response['error_mensaje'] = 'El elemento ya esta registrado';
        }

        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['codigo'] = $request->codigo;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function viewRegistroInventario()
    {

        $current_user =  Auth::user();

        $mis_areas = Oficina::select('oficina.*', 'grupo.id_oficina')
            ->join('grupo', 'grupo.id_oficina', '=', 'oficina.iduoper')
            ->where('grupo.id_usuario', $current_user->id)
            //->where('id_oficina', $id)
            ->get();

        $estados = Estado::all();
        $oficinas = Oficina::all();
        $areas = Area::all();

        return Inertia::render('Inventario/', [
            'areas' => $areas,
            'estados' => $estados,
            'oficinas' => $oficinas,
            'mis_areas' => $mis_areas
        ]);
    }

    public function searchPersonas($term = '')
    {
        $res = Persona::where('nombres', 'LIKE', '%' . $term . '%')
            ->orWhere('dni', 'LIKE', '%' . $term . '%')
            ->orWhere('paterno', 'LIKE', '%' . $term . '%')
            ->orWhere('materno', 'LIKE', '%' . $term . '%')
            ->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        // $this->response['mensaje'] = $request->id_persona;
        return response()->json($this->response, 200);
    }

    public function searchPersonasById($id)
    {
        $res = Persona::where('id', $id)->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        //$this->response['mensaje'] = $request->id_persona;
        return response()->json($this->response, 200);
    }


    public function searchOficinaById($id)
    {
        $res = Oficina::find($id);
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        //$this->response['mensaje'] = $request->id_persona;
        return response()->json($this->response, 200);
    }
    public function searchOficinas($term = '')
    {
        $res = Oficina::where('nombre', 'LIKE', '%' . $term . '%')
            ->orWhere('codigo', 'LIKE', '%' . $term . '%')
            ->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] = $term;
        return response()->json($this->response, 200);
    }

    public function searchAreas($oficina = '')
    {
        $res = Area::where('id_oficina', $oficina)
            ->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $oficina;
        return response()->json($this->response, 200);
    }


    public function searchCodigos($codigo = '')
    {
        $res = IventarioOld::select('*')
            //->join('area', 'area.id', '=', 'id_area')
            ->where('codigo', 'LIKE', $codigo . '%')
            ->get();
        //text

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $codigo;
        return response()->json($this->response, 200);
    }

    public function getBienes(Request $request)
    {

        $res = BienK::select(
            'bienk.id',
            'bienk.codigo',
            'bienk.tipo',
            'bienk.descripcion',
            'bienk.registrado',
            'bienk.idreg_anterior',
            'bienk.cod_ubicacion'
        )
            ->join('oficina', 'oficina.iduoper', '=', 'bienk.id_area') //iduoper
            ->where(function ($query) use ($request) {

                $temp = $query
                    ->where('bienk.id_area', $request->area);

                if ($request->mostrar == 'Registrados') {
                    $temp->where('bienk.registrado', 1);
                }
                if ($request->mostrar == 'Sin registrar') {
                    $temp->where('bienk.registrado', 0);
                }
                if ($request->responsable) {
                    $temp->where('bienk.persona_dni', $request->responsable);
                }
                if ($request->correlativo) {
                    $temp->where(DB::raw("SUBSTRING_INDEX(bienk.cod_ubicacion,'-',-1)"),  'LIKE', '%' . $request->correlativo . '%');
                }

                return $temp;
            })
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('bienk.codigo', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('bienk.idreg_anterior', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('bienk.descripcion', 'LIKE', '%' . $request->term . '%');
            })->paginate(10);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }

    public function getBienesByCorrelativo(Request $request)
    {
        $res = BienK::select(
            'bienk.id',
            'bienk.codigo',
            'bienk.descripcion',
            'bienk.registrado',
            'bienk.idreg_anterior',
            'bienk.cod_ubicacion'
        )
            ->join('oficina', 'oficina.iduoper', '=', 'bienk.id_area') //iduoper
            ->where(DB::raw("SUBSTRING_INDEX(bienk.cod_ubicacion,'.',1)"),  $request->corr_area)
            ->where(DB::raw("SUBSTRING_INDEX(bienk.cod_ubicacion,'-',-1)"),  'LIKE', $request->corr_num . '%')
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('bienk.codigo', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('bienk.idreg_anterior', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('bienk.descripcion', 'LIKE', '%' . $request->term . '%');
            })->paginate(10);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }

    public function getBienesUsuarios(Request $request)
    {
        $res = Inventario::select('inventario.id', 'inventario.codigo', 'inventario.tipo',  'inventario.descripcion',  'oficina.nombre', 'oficina.dependencia', 'inventario.idbienk', 'inventario.corr_area', 'inventario.corr_num')
            ->leftjoin('oficina', 'oficina.iduoper', '=', 'inventario.id_area')
            ->where('inventario.id_usuario', Auth::user()->id)
            ->paginate(10);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }

    public function saveInventario(Request $request)
    {

        if ($request->id_inventario) {

            $res = Inventario::find($request->id_inventario);
            $res->id_persona = $request->id_persona;
            $res->idpersona_otro = $request->idpersona_otro;
            $res->id_area = $request->id_area;
            $res->id_estado = $request->id_estado;
            $res->observaciones = $request->observaciones;
            $res->save();
            $this->response['mensaje'] = 'Exito, Inventario actualizado';
        } else {

            $res = Inventario::create([
                'codigo' => $request->codigo,
                'codigo_anterior' => $request->codigo_anterior,
                'nombre' => $request->nombre,
                'modelo' => $request->modelo,
                'numero' => $request->numero,
                'serie' => $request->serie,
                'idbienk' => $request->id,

                'id_persona' => $request->id_persona,
                'idpersona_otro' => $request->idpersona_otro,
                'id_area' => $request->id_oficina,
                'id_usuario' => Auth::user()->id,
                'id_estado' => $request->id_estado,
                'observaciones' => $request->observaciones,
            ]);

            $this->response['mensaje'] = 'Exito, Inventario registrado';
        }


        if ($res) {

            $this->response['estado'] = true;
            $this->response['codigo'] =  $request->id_area;
            $this->response['datos'] = $res;
            return response()->json($this->response, 200);
        }


        $this->response['mensaje'] = 'Error';
        $this->response['estado'] = true;
        $this->response['codigo'] =  $request->id_area;
        return response()->json($this->response, 200);
    }

    public function getInventario($id)
    {

        $res = Inventario::select('inventario.*', 'area.id_oficina')
            ->join('area', 'area.id', '=', 'inventario.id_area')
            ->where('inventario.id', $id)
            ->first();

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function updatePassword(Request $request)
    {

        $validate = $request->validate([
            'password' => ['required'],
        ]);

        if ($validate) {

            $res = User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->password), 'estado_password' => 1]);

            if ($res) {
                $this->response['mensaje'] = 'Contraseña Actualizada';
                $this->response['estado'] = true;
                return response()->json($this->response, 200);
            }
        }

        $this->response['error'] = 'Error al actualizar al contraseña.';
        $this->response['estado'] = false;
        return response()->json($this->response, 400);
    }

    public function getBienByCodigo(Request $request)
    { //datos para llenar el formulario  solo por codigo

        if (!$request->registrado) {
            $res = $this->bienK->getDataByCode($request->codigo);
        } else {
            $res = $this->inventario->getDataByCode($request->codigo);
        }

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getBienByID(Request $request)
    { //datos para llenar el formulario solo por id

        if (!$request->registrado) {
            $res = $this->bienK->getDataByID($request->id);
        } else {
            $res = $this->inventario->getDataByIDBienk($request->id);
        }

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getInventarioByID(Request $request)
    {

        if ($request->registrado) {
            $res = $this->inventario->getDataByID($request->id);
        } else {
            $this->response['estado'] = true;
            $this->response['mensaje'] = 'Ocurrio un error';
            return response()->json($this->response, 200);
        }


        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function createInventario(Request $request)
    {

        if ($request->codigo) {

            $codigo_existe = Inventario::where('codigo', $request->codigo)->first();

            if ($codigo_existe) {
                $this->response['estado'] = false;
                $this->response['mensaje'] = 'El codigo ya existe';
                return response()->json($this->response, 200);
            }
        }



        $res = Inventario::create([
            'tipo' => $request->tipo,
            'idreg_anterior' => $request->idreg_anterior,
            'cod_ubicacion' => $request->cod_ubicacion,
            'cuenta' => $request->cuenta,
            'codigo' =>  trim($request->codigo),
            'codigo_anterior' => $request->codigo_anterior,
            'descripcion' => $request->descripcion,

            'anio_adq' => $request->anio_adq,

            'modelo' => $request->modelo,
            'marca' => $request->marca,
            'medidas' => $request->medidas,
            'nro_serie' => $request->nro_serie,

            'val_libros' => $request->val_libros,
            'dep_acum2019' => $request->dep_acum2019,
            'color' => $request->color,
            'observaciones' => $request->observaciones,
            'idbienk' => $request->id,
            'id_persona' => $request->id_persona,
            'idpersona_otro' => $request->idpersona_otro,
            'id_area' => $request->id_oficina,
            'id_usuario' => Auth::user()->id,
            'id_estado' => $request->id_estado,
            'estado_uso' => $request->estado_uso,
            'num_ambiente' => $request->num_ambiente,
        ]);

        if ($res) {

            $corr_area =  explode('.', $res->id_area)[0];

            $corr_num = $this->AsignarCorrelativo($res);

            $res->corr_area =  $corr_area;
            $res->corr_num = $corr_num;
            $res->save();

            if ($res->idbienk) {
                Bienk::select('registrado')->where('id', $res->idbienk)->update(['registrado' => 1]);
            }

            $this->response['estado'] = true;
            $this->response['mensaje'] = 'Registrado con exito';
            $this->response['id'] = $res->id;
            $this->response['corr_num'] = $corr_num;
            $this->response['corr_area'] = $corr_area;

            return response()->json($this->response, 200);
        }

        $this->response['mensaje'] = 'Error';
        $this->response['estado'] = false;
        $this->response['mensaje'] = 'Error al registrar';
        return response()->json($this->response, 200);
    }

    public function AsignarCorrelativo($inventario)
    {
        $corr_area =  explode('.', $inventario->id_area)[0];
        $last_num = Inventario::select('corr_num')->where('corr_area', $corr_area)->orderByDesc('corr_num')->first();

        if ($last_num) {
            return  $last_num->corr_num + 1;
        } else {
            return  1;
        }
    }

    public function updateInventario(Request $request)
    {
        if ($request->id_usuario != Auth::user()->id) {
            $this->response['estado'] = false;
            $this->response['mensaje'] = 'No puede editar registros de otro usuario';
            return response()->json($this->response, 200);
        }

        if (trim($request->codigo)) {

            $codigo_existe = Inventario::where('codigo', trim($request->codigo))
                ->where('id', '!=',  $request->id)
                ->first();

            if ($codigo_existe) {
                $this->response['estado'] = false;
                $this->response['mensaje'] = 'El codigo ya existe';
                return response()->json($this->response, 200);
            }
        }


        if ($request->idbienk === null) {
            $data = [
                'codigo' =>  trim($request->codigo),
                'descripcion' => $request->descripcion,
                'modelo' => $request->modelo,
                'marca' => $request->marca,
                'nro_serie' => $request->nro_serie,

                'estado_uso' => $request->estado_uso,
                'num_ambiente' => $request->num_ambiente,
                'medidas' => $request->medidas,
                'color' => $request->color,
                'id_persona' => $request->id_persona,
                'idpersona_otro' => $request->idpersona_otro,
                'id_area' => $request->id_oficina,
                //'id_usuario' => Auth::user()->id,
                'id_estado' => $request->id_estado,
                'observaciones' => $request->observaciones,
            ];
        } else {
            $data = [

                'estado_uso' => $request->estado_uso,
                'num_ambiente' => $request->num_ambiente,
                'medidas' => $request->medidas,
                'color' => $request->color,
                'id_persona' => $request->id_persona,
                'idpersona_otro' => $request->idpersona_otro,
                'id_area' => $request->id_oficina,
                //'id_usuario' => Auth::user()->id,
                'id_estado' => $request->id_estado,
                'observaciones' => $request->observaciones,
            ];
        }




        $res = Inventario::where('id', $request->id)
            ->update($data);

        if ($res) {
            $this->response['estado'] = true;
            $this->response['id'] = $request->id;
            $this->response['mensaje'] = 'Editado con exito';
            return response()->json($this->response, 200);
        }

        $this->response['mensaje'] = 'Error al editar';
        $this->response['estado'] = false;
        return response()->json($this->response, 200);
    }

    public function deleteInventario(Request $request)
    {
        $res = Inventario::find($request->id);

        if ($res) {

            if ($res->id_usuario != Auth::user()->id) {
                $this->response['estado'] = false;
                $this->response['mensaje'] = 'No puede eliminar registros de otro usuario';
                return response()->json($this->response, 200);
            }

            $res->delete();
            Bienk::select('registrado')->where('id', $res->idbienk)->update(['registrado' => 0]);
            $this->response['mensaje'] = 'Exito, Inventario eliminado';
            $this->response['estado'] = true;
            return response()->json($this->response, 200);
        }

        $this->response['mensaje'] = 'Error';
        $this->response['estado'] = false;
        return response()->json($this->response, 200);
    }

    public function saveFoto(Request $request)
    {
        if ($request->file('foto')) {
            if ($request->id) {
                $res = Inventario::find($request->id);
                $path = Storage::disk('public')->put('Fotos/Referencia/' . $res->corr_area . "- " . $res->corr_num, $request->file('foto'));

                $res->foto_ref = asset($path);
                $res->save();

                $this->response['mensaje'] = 'Exito';
                $this->response['estado'] = true;
                return response()->json($this->response, 200);
            }
        }

        $this->response['mensaje'] = 'Error';
        $this->response['estado'] = false;
        return response()->json($this->response, 200);
    }


    public function getBienesByCode($codigo)
    {
        $res = $this->bienK->searchDataByCode($codigo);

        if (count($res)  < 1) {
            $this->response['estado'] = false;
            $this->response['mensaje'] = 'Sin resutados para ' . $codigo;
            $this->response['datos'] = $res;
            return response()->json($this->response, 200);
        }
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    /************** FACILITADOR *********************/


    public function indexFacilitador()
    {
        return Inertia::render('Facilitador/Inventario/');
    }

    public function getBienesAll(Request $request)
    {
        $res = Inventario::select('*')
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('codigo', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('descripcion', 'LIKE', '%' . $request->term . '%');
            })->paginate(7);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    // DB::table('categories as c')
    // ->select('c.id', 'c.name', DB::raw('COUNT(p.id) as products_count'))
    // ->leftJoin('products as p', 'c.id', 'p.product_type')
    // ->groupBy('c.id')

    public function getBienesAllbyArea(Request $request)
    {

        $query_where = [];
        if ($request->id_area) array_push($query_where, ['inventario.id_area', '=', $request->id_area]);
        if ($request->id_persona) array_push($query_where, ['inventario.id_persona', '=', $request->id_persona]);
        //DB::raw("CONCAT( hor_inicio , ' - ' , hor_fin) as horario")
        $res = Inventario::select(
            'inventario.*',
            'area.nombre as area'
        )
            ->leftjoin('area', 'area.id', '=', 'inventario.id_area')
            ->where($query_where)
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('inventario.codigo', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('inventario.descripcion', 'LIKE', '%' . $request->term . '%');
            })
            ->paginate(7);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;

        return response()->json($this->response, 200);
    }

    public function getBienesInv(Request $request)
    {
        $query_where = [];
        if ($request->oficina) array_push($query_where, [DB::raw('substr(id_area, 1, 2)'), '=', $request->oficina]);
        if ($request->dependencia) array_push($query_where, [DB::raw('substr(id_area, 4, 2)'), '=', $request->dependencia]);
        if ($request->usuario) array_push($query_where, [DB::raw('id_usuario'), '=', $request->usuario]);
        if ($request->fecha) array_push($query_where, [DB::raw('date(inventario.created_at)'), '=', $request->fecha]);
        //DB::raw("CONCAT( hor_inicio , ' - ' , hor_fin) as horario")
        $res = Inventario::select(
            'inventario.*',
            'oficina.dependencia as dependencia',
            'oficina.nombre as oficina',
            'users.nombres as unombre',
            'users.apellidos as uapellidos',
            'persona.dni as pdni',
            'persona.nombres as pnombre',
            'persona.paterno',
            'persona.materno'
        )
            ->join('oficina', 'inventario.id_area', '=', 'oficina.iduoper')
            ->join('users', 'inventario.id_usuario', '=', 'users.id')
            ->join('persona', 'inventario.id_persona', '=', 'persona.id')
            ->where($query_where)
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('inventario.codigo', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('inventario.descripcion', 'LIKE', '%' . $request->term . '%');
            })->orderBy('inventario.id', 'DESC')
            ->paginate(1000);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getBienInv($id)
    {
        //        JOIN inventario.id_persona = persona.id'
        $res = DB::select('SELECT inventario.*, users.nombres as unombre, users.apellidos as uapellido, oficina.nombre as onombre, oficina.dependencia as dependencia, persona.dni as dni from inventario left join users on users.id = inventario.id_usuario left join oficina on inventario.id_area = oficina.iduoper left join persona on inventario.id_persona = persona.id WHERE inventario.id = ' . $id);

        $this->response['datos'] = $res[0];

        return response()->json($this->response, 200);
    }

    public function getBiens()
    {
        //        JOIN inventario.id_persona = persona.id'
        $res = DB::select('SELECT inventario.*, users.nombres as unombre, users.apellidos as uapellido, oficina.nombre as onombre, oficina.dependencia as dependencia, persona.dni as dni from inventario left join users on users.id = inventario.id_usuario left join oficina on inventario.id_area = oficina.iduoper left join persona on inventario.id_persona = persona.id');

        $this->response['datos'] = $res;

        return response()->json($this->response, 200);
    }

    public function eliminarBienAdmin($id)
    {
        $bien = Inventario::find($id);
        $bien->delete();
        $this->response['mensaje'] = 'Bien eliminado';
        $this->response['estado'] = true;
        $this->response['datos'] = $bien;
        return response()->json($this->response, 200);
    }


    public function viewCargosInventario()
    {

        return Inertia::render('Inventario/Cargos/');
    }



    public function getResponsablesByArea($area)
    {
        $res = DB::select(
            "SELECT concat(dni,' - ', nombres,' ',paterno,' ',materno) as text , id, dni
            from persona 
            WHERE dni IN 
                (SELECT persona_dni 
                FROM bienk 
                where id_area = '$area');"
        );

        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }


    public function getUsuariosForInventario()
    {
        $res = User::where('rol', 2)->get();
        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function getBienesInvBlank(Request $request)
    {
        $query_where = [];
        if ($request->usuario) array_push($query_where, [DB::raw('id_usuario'), '=', $request->usuario]);
        if ($request->fecha) array_push($query_where, [DB::raw('date(inventario.created_at)'), '=', $request->fecha]);
        //DB::raw("CONCAT( hor_inicio , ' - ' , hor_fin) as horario")
        $res = Inventario::select(
            'inventario.*',
            'oficina.dependencia as dependencia',
            'oficina.nombre as oficina',
            'users.nombres as unombre',
            'users.apellidos as uapellidos',
            'persona.dni as pdni',
            'persona.nombres as pnombre',
            'persona.paterno',
            'persona.materno'
        )
            ->join('oficina', 'inventario.id_area', '=', 'oficina.iduoper')
            ->join('users', 'inventario.id_usuario', '=', 'users.id')
            ->join('persona', 'inventario.id_persona', '=', 'persona.id')
            ->where($query_where)
            ->where('inventario.codigo', '=', '')
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('inventario.descripcion', 'LIKE', '%' . $request->term . '%');
            })->orderBy('inventario.id', 'DESC')
            ->paginate(1000);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function viewLotesInventario()
    {

        $current_user =  Auth::user();

        $mis_areas = Oficina::select('oficina.*', 'grupo.id_oficina')
            ->join('grupo', 'grupo.id_oficina', '=', 'oficina.iduoper')
            ->where('grupo.id_usuario', $current_user->id)
            //->where('id_oficina', $id)
            ->get();

        $estados = Estado::all();
        $oficinas = Oficina::all();
        $areas = Area::all();

        return Inertia::render('Inventario/RegistroLote', [
            'areas' => $areas,
            'estados' => $estados,
            'oficinas' => $oficinas,
            'mis_areas' => $mis_areas
        ]);
    }

    public function viewLotesInventarioNuevo()
    {

        $current_user =  Auth::user();

        $mis_areas = Oficina::select('oficina.*', 'grupo.id_oficina')
            ->join('grupo', 'grupo.id_oficina', '=', 'oficina.iduoper')
            ->where('grupo.id_usuario', $current_user->id)
            //->where('id_oficina', $id)
            ->get();

        $estados = Estado::all();
        $oficinas = Oficina::all();
        $areas = Area::all();

        return Inertia::render('Inventario/RegistroLoteNuevo', [
            'areas' => $areas,
            'estados' => $estados,
            'oficinas' => $oficinas,
            'mis_areas' => $mis_areas
        ]);
    }

    public function guardarLote(Request $request)
    {
        try {
            $trans = DB::transaction(function () use ($request) {

                $datos = (object)[
                    'color' => $request->color,
                    'estado_uso' => $request->estado_uso,
                    'id_estado' => $request->id_estado,
                    'id_area' => $request->id_oficina,
                    'id_persona' => $request->id_persona,
                    'idpersona_otro' => $request->idpersona_otro,
                    'medidas' => $request->medidas,
                    'num_ambiente' => $request->num_ambiente,
                    'observaciones' => $request->observaciones,
                ];

                foreach ($request->bienes as $item) {
                    //$correlativos push correlativo
                    $correlativo =  $this->getAndCreteInventario($item, $datos);
                    array_push($this->correlativos, $correlativo);
                }
            });

            $this->response['mensaje'] = 'Exito';
            $this->response['estado'] = true;
            $this->response['datos'] = $trans;
            $this->response['correlativos'] = $this->correlativos;
            return response()->json($this->response, 200);
        } catch (\Throwable $th) {
            $this->response['mensaje'] = 'Ocurrió un error, vuelva a intentarlo';
            $this->response['estado'] = false;
            return response()->json($this->response, 200);
        }
    }

    public function guardarLoteNuevos(Request $request)
    {
        try {
            $trans = DB::transaction(function () use ($request) {

                $datos = (object)[
                    'descripcion' => $request->descripcion,
                    'modelo' => $request->modelo,
                    'color' => $request->color,
                    'marca' => $request->marca,
                    'estado_uso' => $request->estado_uso,
                    'id_estado' => $request->id_estado,
                    'id_area' => $request->id_oficina,
                    'id_persona' => $request->id_persona,
                    'idpersona_otro' => $request->idpersona_otro,
                    'medidas' => $request->medidas,
                    'num_ambiente' => $request->num_ambiente,
                    'observaciones' => $request->observaciones,
                ];

                foreach ($request->cant as $item) {
                    //$correlativos push correlativo
                    $datos->codigo = $item['codigo'];
                    $datos->nro_serie = $item['nro_serie'];
                    $correlativo =  $this->nuevoInventario($datos);
                    array_push($this->correlativos, $correlativo);
                }
            });

            $this->response['mensaje'] = 'Exito';
            $this->response['estado'] = true;
            $this->response['correlativos'] = $this->correlativos;
            return response()->json($this->response, 200);
        } catch (\Throwable $th) {
            $this->response['mensaje'] = 'Ocurrió un error, vuelva a intentarlo';
            $this->response['estado'] = false;
            return response()->json($this->response, 200);
        }
    }

    private function nuevoInventario($data)
    {

        $res = Inventario::create([
            'codigo' =>  trim($data->codigo),
            'descripcion' => trim($data->descripcion),
            'modelo' => $data->modelo,
            'marca' => $data->marca,
            'medidas' => $data->medidas,
            'nro_serie' => $data->nro_serie,
            'color' => $data->color,
            'observaciones' => $data->observaciones,
            'id_persona' => $data->id_persona,
            'idpersona_otro' => $data->idpersona_otro,
            'id_area' => $data->id_area,
            'id_usuario' => Auth::user()->id,
            'id_estado' => $data->id_estado,
            'estado_uso' => $data->estado_uso,
            'num_ambiente' => $data->num_ambiente,
        ]);

        if ($res) {

            $corr_area =  explode('.', $res->id_area)[0];

            $corr_num = $this->AsignarCorrelativo($res);

            $res->corr_area =  $corr_area;
            $res->corr_num = $corr_num;
            $res->save();

            $correlativo = (object)[
                'codigo' => $res->codigo,
                'serie' => $res->nro_serie,
                'correlativo' => $res->corr_area . ' - ' . $res->corr_num,
            ];

            return $correlativo;
        }
    }



    //create-inventario-lote

    public function getAndCreteInventario($item, $datos)
    {

        $bienk = $this->bienK->getDataByID($item['id']);

        $res = Inventario::create([
            'tipo' => $bienk->tipo,
            'idreg_anterior' => $bienk->idreg_anterior,
            'cod_ubicacion' => $bienk->cod_ubicacion,
            'cuenta' => $bienk->cuenta,
            'codigo' =>  trim($bienk->codigo),
            'codigo_anterior' => $bienk->codigo_anterior,
            'descripcion' => $bienk->descripcion,
            'anio_adq' => $bienk->anio_adq,
            'modelo' => $bienk->modelo,
            'marca' => $bienk->marca,
            //********************* */
            'medidas' => $datos->medidas,
            'color' => $datos->color,
            'id_persona' => $datos->id_persona,
            'idpersona_otro' => $datos->idpersona_otro,
            'id_area' => $datos->id_area,
            'id_estado' => $datos->id_estado,
            'estado_uso' => $datos->estado_uso,
            'num_ambiente' => $datos->num_ambiente,
            'observaciones' => $datos->observaciones,
            /********************** */
            'nro_serie' => $bienk->nro_serie,
            'val_libros' => $bienk->val_libros,
            'dep_acum2019' => $bienk->dep_acum2019,
            'idbienk' => $bienk->id,
            'id_usuario' => Auth::user()->id,
        ]);

        if ($res) {

            $corr_area =  explode('.', $res->id_area)[0];

            $corr_num = $this->AsignarCorrelativo($res);

            $res->corr_area =  $corr_area;
            $res->corr_num = $corr_num;
            $res->save();

            if ($res->idbienk) {
                Bienk::select('registrado')->where('id', $res->idbienk)->update(['registrado' => 1]);
            }

            $correlativo = (object)[
                'codigo' => $res->codigo,
                'cod_ubicacion' => $res->cod_ubicacion,
                'correlativo' => $res->corr_area . '-' . $res->corr_num,
            ];

            return $correlativo;
        }
    }

    public function export()
    {
        $date = date('d-m-Y');
        return Excel::download(new InventarioExports, 'inventario' . $date . '.xlsx');
    }

    //Conciliación
    public function viewConciliacionInventario()
    {
<<<<<<< HEAD
        return Inertia::render('Inventario/Conciliacion');
        $user = (Auth::user()->equipo);
=======

        $user = Auth::user()->equipo;
>>>>>>> e415b6bb53c34bc178e2cbd78158f9f2b70e4322

        $dependencias = DB::select("SELECT distinct substring(grupo.id_oficina,1,2) as id, oficina.dependencia  FROM grupo 
        JOIN users ON grupo.id_usuario = users.id
        JOIN oficina on oficina.iduoper = grupo.id_oficina
        WHERE users.equipo IN ($user)");

        return Inertia::render(
            'Inventario/Conciliacion',
            [
                'dependencias' => $dependencias,
            ]
        );
    }

    public function getDependenciasTEMP(){
        $user = (Auth::user()->equipo);
        $dependencias = DB::select("SELECT distinct substring(grupo.id_oficina,1,2) as id, oficina.dependencia  FROM grupo 
        JOIN users ON grupo.id_usuario = users.id
        JOIN oficina on oficina.iduoper = grupo.id_oficina
        WHERE users.equipo IN ($user)");
        
        $this->response['datos'] = $dependencias;
        return response()->json($this->response, 200);

    } 
    public function getBienesConciliacion($dependencia, $tipo = "")
    {

        $data = DB::select("SELECT bienk.*,persona.*,  oficina.nombre AS oficina
        FROM bienk 
        JOIN oficina ON oficina.iduoper = bienk.id_area
        LEFT JOIN persona ON persona.dni = bienk.persona_dni
        WHERE bienk.tipo='$tipo'  
        AND cod_ubicacion LIKE '$dependencia%' 
        AND (bienk.codigo NOT IN (SELECT inventario.codigo FROM inventario WHERE codigo IS not NULL));");

        $this->response['mensaje'] = 'Exito';
        $this->response['estado'] = true;
        $this->response['datos'] = $data;
        return response()->json($this->response, 200);
    }

    public function getBienesAF($page)
    {
        $limit = 30;
        $ofs = ($page - 1) * $limit;
        $res = DB::select('SELECT *,oficina.dependencia, oficina.iduoper, persona.nombres, persona.paterno, persona.materno FROM bienk 
        JOIN oficina ON oficina.iduoper = bienk.id_area
        LEFT JOIN persona ON persona.dni = bienk.persona_dni
        WHERE bienk.tipo="ACTIVO FIJO"  
        AND cod_ubicacion LIKE "44%"     
        AND (bienk.codigo NOT IN (SELECT inventario.codigo FROM inventario WHERE codigo IS not NULL)) LIMIT 30 OFFSET ' . $ofs);
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function downloadExcelConciliacion($dependencia, $tipo = "")
    {
        return Excel::download(new BienkExport($dependencia, $tipo), "Conciliacion-$dependencia-$tipo.xlsx");
    }
}
