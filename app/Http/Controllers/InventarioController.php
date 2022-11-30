<?php

namespace App\Http\Controllers;

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
use Inertia\Inertia;

class InventarioController extends Controller
{
    protected $bienK;
    protected $inventario;

    public function __construct()
    {
        $this->bienK = new Bienk;
        $this->inventario = new Inventario;
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

        $res = BienK::select('bienk.codigo',  'bienk.descripcion', 'bienk.registrado', 'bienk.idreg_anterior')
            ->join('oficina', 'oficina.iduoper', '=', 'bienk.id_area') //iduoper
            ->where(function ($query) use ($request) {

                if ($request->mostrar == 'Registrados') {
                    $temp = $query
                        ->where('bienk.id_area', $request->area)
                        ->where('bienk.registrado', 1);
                } else if ($request->mostrar == 'Sin registrar') {
                    $temp = $query
                        ->where('bienk.id_area', $request->area)
                        ->where('bienk.registrado', 0);
                } else {
                    $temp = $query
                        ->where('bienk.id_area', $request->area);
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

    public function getBienesUsuarios(Request $request)
    {
        $res = Inventario::select('inventario.id', 'inventario.codigo',  'inventario.descripcion',  'oficina.nombre', 'oficina.dependencia', 'inventario.idbienk')
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
    {
        if (!$request->registrado) {
            if ($request->codigo == "") {
                $res = $this->bienK->getDataByRegAnt($request->idreg_anterior);
            } else {
                $res = $this->bienK->getDataByCode($request->codigo);
            }
        } else {

            if ($request->codigo) {
                $res = $this->inventario->getDataByCode($request->codigo);
            } elseif ($request->idbienk ==  null) {
                $res = $this->inventario->getDataById($request->id);
            } else {
                $res = $this->inventario->getDataByRegAnt($request->idreg_anterior);
            }
        }

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function createInventario(Request $request)
    {

        $res = Inventario::create([
            'tipo' => $request->tipo,
            'idreg_anterior' => $request->idreg_anterior,
            'cod_ubicacion' => $request->cod_ubicacion,
            'cuenta' => $request->cuenta,
            'codigo' => $request->codigo,
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
            $this->response['corr_num'] = $corr_num;
            $this->response['corr_area'] = $corr_area;

            return response()->json($this->response, 200);
        }

        $this->response['mensaje'] = 'Error';
        $this->response['estado'] = false;
        $this->response['mensaje'] = 'Error al registrar';
        $this->response['codigo'] =  $request->id_area;
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
        $data = [

            'medidas' => $request->medidas,
            'color' => $request->color,
            'id_persona' => $request->id_persona,
            'idpersona_otro' => $request->idpersona_otro,
            'id_area' => $request->id_oficina,
            //'id_usuario' => Auth::user()->id,
            'id_estado' => $request->id_estado,
            'observaciones' => $request->observaciones,
        ];

        $res = Inventario::where('codigo', $request->codigo)
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
                $path = Storage::disk('public')->put('Fotos/Referencia/' . $res->codigo, $request->file('foto'));

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





    // public function getBienesAllbyOfice(Request $request)
    // {
    //     $res = Inventario::select('*')
    //         ->Join("area", "inventario.id_area","=","area.id")
    //         ->where(function ($query) use ($request) {
    //             return $query
    //                 ->orWhere('codigo', 'LIKE', '%' . $request->term . '%')
    //                 ->orWhere('descripcion', 'LIKE', '%' . $request->term . '%');
    //         })->paginate(7);

    //     $this->response['estado'] = true;
    //     $this->response['datos'] = $res;
    //     return response()->json($this->response, 200);
    // }
}
