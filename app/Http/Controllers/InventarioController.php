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


        $res = User::select(
            'users.*',
            DB::raw('GROUP_CONCAT(oficina.nombre SEPARATOR "|#|") as oficinas'),
            DB::raw('GROUP_CONCAT(oficina.id SEPARATOR "|#|") as oficinas_ids')
        )
            ->leftjoin('grupo', 'grupo.id_usuario', '=', 'users.id')
            ->leftjoin('area', 'area.id', '=', 'grupo.id_area')
            ->leftjoin('oficina', 'area.id_oficina', '=', 'oficina.id')
            ->where('users.id', $current_user->id)
            ->groupBy('users.id')
            ->first();

        if (!$res) {
            return false;
        }

        $oficinas = [];
        $_oficinas_nombres =   $res->oficinas != "" ?  array_unique(explode("|#|", $res->oficinas)) : [];
        $_oficinas_ids =   $res->oficinas_ids != "" ?  array_unique(explode("|#|", $res->oficinas_ids)) : [];

        foreach ($_oficinas_nombres as $i => $oficina) {
            $aux = [
                'id'  => $_oficinas_ids[$i],
                'nombre' => $oficina
            ];
            array_push($oficinas, $aux);
        }

        $datos =
            [
                'id' => $res->id,
                'nombres' => $res->nombres,
                'apellidos' => $res->apellidos,
                'email' => $res->email,
                'rol' => $res->rol,
                'rol_name' => $res->getRoleNames()[0],
                'oficinas' =>  $oficinas
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

        $mis_areas = Area::select('area.*', 'grupo.id_area')
            ->join('grupo', 'grupo.id_area', '=', 'area.id')
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

        $res = BienK::select('bienk.codigo', 'bienk.codigo_siga', 'bienk.descripcion', 'bienk.registrado')
            ->join('area', 'area.id', '=', 'bienk.id_area')
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
                    ->orWhere('bienk.codigo_siga', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('bienk.descripcion', 'LIKE', '%' . $request->term . '%');
            })->paginate(10);

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }

    public function getBienesUsuarios(Request $request)
    {
        $res = Inventario::select('inventario.codigo', 'inventario.codigo_siga', 'inventario.descripcion', 'area.id', 'area.nombre')
            ->join('area', 'area.id', '=', 'inventario.id_area')
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
                'id_area' => $request->id_area,
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
            $res = $this->bienK->getDataByCode($request->codigo);
        } else {
            $res = $this->inventario->getDataByCode($request->codigo);
        }

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }

    public function createInventario(Request $request)
    {
        $res = Inventario::create([
            'codigo' => $request->codigo,
            'codigo_siga' => $request->codigo_siga,
            'descripcion' => $request->descripcion,
            'modelo' => $request->modelo,
            'marca' => $request->marca,
            'nro_serie' => $request->nro_serie,
            'anio_fabricacion' => $request->anio_fabricacion,
            'nro_cargo_personal' => $request->nro_cargo_personal,
            'fecha_cargo' => $request->fecha_cargo  == "0000-00-00" ? NULL :  $request->fecha_cargo,
            'nro_orden' => $request->nro_orden,
            'fecha_compra' => $request->fecha_compra,
            'proveedor_ruc' => $request->proveedor_ruc,
            'nro_pecosa' => $request->nro_pecosa,
            'fecha_pecosa' => $request->fecha_pecosa,
            'vida_util' => $request->vida_util,
            'fecha_vida_util' => $request->fecha_vida_util,
            'valor_adquisicion' => $request->valor_adquisicion,
            'valor_inicial' => $request->valor_inicial,
            'valor_depreciacion' => $request->valor_depreciacion,
            'fecha_baja_bien' => $request->fecha_baja_bien,
            'clasificador' => $request->clasificador,
            'sub_cta' => $request->sub_cta,
            'mayor' => $request->mayor,
            'observaciones' => $request->observaciones,

            'tipo' => $request->codigo,
            'idbienk' => $request->id,
            'id_persona' => $request->id_persona,
            'idpersona_otro' => $request->idpersona_otro,
            'id_area' => $request->id_area,
            'id_usuario' => Auth::user()->id,
            'id_estado' => $request->id_estado,
        ]);

        if ($res) {

            if ($res->idbienk) {
                Bienk::select('registrado')->where('id', $res->idbienk)->update(['registrado' => 1]);
            }

            $this->response['estado'] = true;
            $this->response['mensaje'] = 'Registrado con exito';
            $this->response['id'] = $res->id;
            return response()->json($this->response, 200);
        }

        $this->response['mensaje'] = 'Error';
        $this->response['estado'] = false;
        $this->response['mensaje'] = 'Error al registrar';
        $this->response['codigo'] =  $request->id_area;
        return response()->json($this->response, 200);
    }
    public function updateInventario(Request $request)
    {
        if ($request->id_usuario != Auth::user()->id) {
            $this->response['estado'] = false;
            $this->response['mensaje'] = 'No puede editar registros de otro usuario';
            return response()->json($this->response, 200);
        }
        $data = [
            'id_persona' => $request->id_persona,
            'idpersona_otro' => $request->idpersona_otro,
            'id_area' => $request->id_area,
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
        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        return response()->json($this->response, 200);
    }
}
