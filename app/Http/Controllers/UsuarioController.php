<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsuarioController extends Controller
{
    public function index()
    {

        return Inertia::render('Admin/Usuarios/');
    }

    public function getUsuarios(Request $request)
    {
        $res = User::select()
            //->join('grupo', 'grupo.id_usuario', '=', 'users.id')
            //->join('area', 'area.id', '=', 'grupo.id_area')

            //->where('bienk.id_area', $request->area)
            ->where(function ($query) use ($request) {
                return $query
                    ->orWhere('users.nombres', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('users.apellidos', 'LIKE', '%' . $request->term . '%')
                    //->orWhere('users.dni', 'LIKE', '%' . $request->term . '%')
                    ->orWhere('users.email', 'LIKE', '%' . $request->term . '%');
            })->paginate(2);

            $res->getCollection()->transform(function ($item) {
                return  
                [
                    
                    'id' => $item->id,
                    'nombres' => $item->nombres,
                    'apellidos' => $item->apellidos,
                    'email' => $item->email,
                    'rol' => $item->rol,
                    'rol_name'  => $item->getRoleNames()[0],
                ];
            });

            

        $this->response['estado'] = true;
        $this->response['datos'] = $res;
        $this->response['mensaje'] =   $request->area;
        return response()->json($this->response, 200);
    }
}
