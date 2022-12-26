<?php

namespace App\Http\Controllers;

use App\Models\cargoFPDF;
use App\Models\Inventario;
use App\Models\User;

class FPDFController extends Controller 
{

    public function cargoFPDF() 
    {
        $fpdf = new cargoFPDF('L','mm','A4');
        $fpdf->SetMargins(8, 11 , 8, 10);
        $fpdf->setNombre("Ariel");

        $fpdf->SetFont('Arial', '', 11);
        $fpdf->AddPage(); 

        // Carga de datos
        $data = Inventario::all();
        $fpdf->SetFont('Arial','',14);
        $fpdf->FancyTable($data);
        // for($i=1; $i<=400; $i++)
        //     $fpdf->Cell(0,3,utf8_decode('Imprimiendo linea número'),0,1);
            
        $fpdf->Output();

        exit;
    }
    
}

