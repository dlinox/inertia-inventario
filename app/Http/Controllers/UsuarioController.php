<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {

        return Inertia::render('Admin/Usuarios/', [
            'roles' =>  Role::all(),
        ]);
    }

    public function saveUsuario(Request $request)
    {
        if (!$request->id) {

            $usuario = User::create([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'email' => $request->email,
                'rol' => $request->rol,
                'password' => Hash::make($request->password),
            ]);

            $usuario->assignRole($request->rol);

            $this->response['mensaje'] = 'Usuario creado con exito';
        } else {
            $usuario = User::find($request->id);
            $usuario->nombres = $request->nombres;
            $usuario->apellidos = $request->apellidos;
            $usuario->email = $request->email;
            $usuario->rol = $request->rol;
            $usuario->save();

            $usuario->roles()->sync($request->rol);

            $this->response['mensaje'] = 'Usuario editado con exito';
        }


        $this->response['estado'] = true;
        $this->response['datos'] = $usuario;

        return response()->json($this->response, 200);
    }

    public function getUsuarios(Request $request)
    {

        $query_where = [];
        if ($request->rol) array_push($query_where, ['users.rol', '=', $request->rol]);
        if ($request->oficina) array_push($query_where, ['oficina.id', '=', $request->oficina]);
        if ($request->area) array_push($query_where, ['area.id', '=', $request->area]);

        //DB::raw("CONCAT( hor_inicio , ' - ' , hor_fin) as horario")
        $res = User::select(
            'users.*',
            DB::raw('GROUP_CONCAT(oficina.nombre SEPARATOR ",") as oficinas'),
            DB::raw('GROUP_CONCAT(area.nombre SEPARATOR ",") as areas')
        )
            ->leftjoin('grupo', 'grupo.id_usuario', '=', 'users.id')
            ->leftjoin('area', 'area.id', '=', 'grupo.id_area')
            ->leftjoin('oficina', 'area.id_oficina', '=', 'oficina.id')

            //->where('bienk.id_area', $request->area)

            ->where($query_where)
            ->where(function ($query) use ($request) {

                //var_dump($request->rol);

                return $query
                    ->orWhere('users.nombres', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('users.apellidos', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $request->term . '%');
            })
            ->groupBy('users.id')
            ->paginate(2);


        $res->getCollection()->transform(function ($item) {
            return
                [
                    'id' => $item->id,
                    'nombres' => $item->nombres,
                    'apellidos' => $item->apellidos,
                    'email' => $item->email,
                    'rol' => $item->rol,
                    'rol_name'  => $item->getRoleNames()[0],
                    'areas' =>  $item->areas != "" ?  array_unique(explode(",", $item->areas)) : [],
                    'oficinas' =>  $item->oficinas != "" ?  array_unique(explode(",", $item->oficinas)) : []
                ];
        });



        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }

    public function asignarArea(Request $request)
    {

        foreach ($request->areas as $area) {
            $create = Grupo::create([
                'id_usuario' => $request->usuario,
                'id_area' => $area,
            ]);
        }

        $this->response['estado'] = true;

        $this->response['areas'] =   $request->areas;
        $this->response['usuario'] =   $request->usuario;
        return response()->json($this->response, 200);
    }

    public function getFormulario($id = "")
    {
        $props['roles'] = Role::all();

        $props['is_nuevo'] = true;

        if ($id !=  "") {
            $usuario = $this->getUsuario($id);

            if (!$usuario) {
                $props['error'] =  true;
            } else {
                $props['data'] = $usuario;
                $props['is_nuevo'] = false;
            }
        }

        return Inertia::render('Admin/Usuarios/Formulario', $props);
    }

    private function getUsuario($id)
    {
        $res = User::select(
            'users.*',
            DB::raw('GROUP_CONCAT(oficina.nombre SEPARATOR ",") as oficinas'),
            DB::raw('GROUP_CONCAT(oficina.id SEPARATOR ",") as oficinas_ids')
        )
            ->leftjoin('grupo', 'grupo.id_usuario', '=', 'users.id')
            ->leftjoin('area', 'area.id', '=', 'grupo.id_area')
            ->leftjoin('oficina', 'area.id_oficina', '=', 'oficina.id')
            ->where('users.id', $id)
            ->groupBy('users.id')
            ->first();

        if (!$res) {
            return false;
        }

        $oficinas = [];
        $_oficinas_nombres =   $res->oficinas != "" ?  array_unique(explode(",", $res->oficinas)) : [];
        $_oficinas_ids =   $res->oficinas_ids != "" ?  array_unique(explode(",", $res->oficinas_ids)) : [];

        foreach ($_oficinas_nombres as $i => $oficina) {
            $aux = [
                'id'  => $_oficinas_ids[$i],
                'nombre' => $oficina
            ];
            array_push($oficinas, $aux);
        }

        return
            [
                'id' => $res->id,
                'nombres' => $res->nombres,
                'apellidos' => $res->apellidos,
                'email' => $res->email,
                'rol' => $res->rol,
                'oficinas' =>  $oficinas
            ];
    }
}


/**
 *
 *
 *
 private function getUsuario($id)
    {
        $res = [];
        $usuario = User::select('id', 'nombres', 'apellidos', 'email', 'rol')->where('id', $id)->first();

        if ($usuario) {

            $res['usuario'] = $usuario;

            $oficinas = Oficina::select(
                'oficina.*',
                DB::raw('GROUP_CONCAT(area.nombre SEPARATOR ",") as areas'),
                DB::raw('GROUP_CONCAT(area.id SEPARATOR ",") as areas_ids')
            )
                ->join('area', 'area.id_oficina', '=', 'oficina.id')
                ->join('grupo', 'grupo.id_area', '=', 'area.id')
                ->where('grupo.id_usuario', $id)
                ->groupBy('oficina.id')
                ->get()
                ->map(function ($item) {
                    $areas = [];
                    $_areas_nombres =   $item->areas != "" ?  explode(",", $item->areas) : [];
                    $_areas_ids =   $item->areas_ids != "" ?  explode(",", $item->areas_ids) : [];
                    foreach ($_areas_nombres as $i => $area) {
                        $aux = [
                            'id'  => $_areas_ids[$i],
                            'nombre' => $area
                        ];
                        array_push($areas, $aux);
                    }
                    return [
                        'id' => $item->id,
                        'nombre' => $item->nombre,
                        'codigo' => $item->codigo,
                        'areas' => $areas
                    ];
                });

            if ($oficinas) {
                $res['oficinas'] = $oficinas;
            }
        }

        return $res;
    }
 */
