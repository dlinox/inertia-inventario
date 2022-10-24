<?php

namespace App\Http\Controllers;

use App\Mail\PruebaMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class AuthController extends Controller
{

    public function viewResetPasword()
    {
        return Inertia::render('Auth/ResetPassword');
    }


    public function sentEmailResetPassword(Request $request)
    {

        $validate = $request->validate([
            'email' => ['required', 'email', 'exists:users'],
        ]);

        if ($validate) {

            $datos = [
                'email' => $request->email,
                'token' => Hash::make($request->email),
            ];

            Mail::to($request->email)->send(new PruebaMail($datos));

            DB::table('password_resets')->insert([
                'email' => $datos['email'],
                'token' => $datos['token']
            ]);

            $this->response['mensaje'] = 'Correo Enviado. Revise su bandeja de entrada.';
            $this->response['estado'] = true;
            return response()->json($this->response, 200);
        }

        $this->response['error'] = 'El email no existe.';
        $this->response['estado'] = false;
        return response()->json($this->response, 400);
    }

    public function viewChangePassword(Request $request)
    {

        return Inertia::render('Auth/ChangePassword', ['token' => $request->token]);
    }
    public function saveNewPassword(Request $request)
    {
        if ($request->token) {

            $res_pass = DB::table('password_resets')
                ->select('email')
                ->where('token', $request->token)
                ->first();

            $user = User::where('email', $res_pass->email)
                ->first();

            $user->password = Hash::make($request->password);
            $user->save();


            $this->response['mensaje'] = 'Contraseña Restablecida.';
            $this->response['estado'] =  $user;
            return response()->json($this->response, 200);
        }

        $this->response['error'] = 'Error, cambiar contraseña.';
        $this->response['estado'] = false;
        return response()->json($this->response, 400);
    }
}
