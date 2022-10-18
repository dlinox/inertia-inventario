<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleAdministrador
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {


        if (auth()->user()->getRoleNames()[0] == 'Administrador') {
            return $next($request);
        } elseif (auth()->user()->getRoleNames()[0] == 'Inventario') {
            return Redirect::route('inventario.index');
        }
        //return redirect(RouteServiceProvider::HOME);
    }
}
