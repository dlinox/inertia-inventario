<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleFacilitador
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

        if (auth()->user()->getRoleNames()[0] == 'Facilitador') {
            return $next($request);
        } elseif (auth()->user()->getRoleNames()[0] == 'Inventario') {
            return Redirect::route('inventario.index');
        } elseif (auth()->user()->getRoleNames()[0] == 'Administrador') {
            return Redirect::route('admin.index');
        }
        //return redirect(RouteServiceProvider::HOME);
    }
}
