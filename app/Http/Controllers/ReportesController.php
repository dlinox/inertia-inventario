<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ReportesController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Reportes/');
    }
    public function generador()
    {
        return Inertia::render('Admin/Reportes/');
    }
    public function explorador(){
        return Inertia::render('Admin/Explorador/');
    }

}
