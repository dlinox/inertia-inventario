<?php

namespace App\Models;
use Codedge\Fpdf\Fpdf\Fpdf;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Trunc;

class CargoFPDF extends Fpdf
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    private $nombre="kin";

    public function setNombre( $n){
        $this->nombre = $n;
    }
    public function Header()
    {
        $this->SetFont('Helvetica','',13);
        $this->Cell(-10, -5, 'Universidad Nacional del Altiplano'); 
        $this->SetFont('Helvetica','',10); 
        $this->Cell(560, -5, 'Pag. '.$this->PageNo().' de {nb}', 0, 0, 'C');    
        $this->AliasNbPages();

        $this->SetFillColor(0,255,0);
        $this->SetDrawColor(32,240,0);

        $this->SetFont('Helvetica','',10);
        $this->SetX(8);
        $this->Cell(10, 5, utf8_decode('Comisión de Inventario Activos Fijos 2022'),);  
        $this->SetFont('Helvetica','',13);
        $this->SetX(18);
        $this->Cell(0, 8, utf8_decode('FORMATO DE FICHA DE LEVANTAMIENTO DE INFORMACIÓN'),0,0,'C');  
        $this->SetX(123);
        $this->SetFont('Helvetica','',11);
        $this->setX(8);
        $this->setY(17);
        $this->Cell(280, 7, utf8_decode('INVENTARIO PATRIMONIAL 2022'),0,0,'C');  

        $this->SetFillColor(240,240,245);
        $this->SetDrawColor(0,0,0);
        $this->SetY(24);
        $this->Cell(0, 8, utf8_decode('Dependencia'),'C',0,0);  
        $this->SetX(70);
        $this->Cell(0, 8, utf8_decode(': Rectorado - RECTORADO'),'C');  
        $this->Cell(0, 8, utf8_decode('ID: 01.01.1 01309849-1'),0,0,'R');  
        
        $this->SetY(30);
        $this->Cell(0, 8, utf8_decode('[DNI]Apellidos y Nombres'),'C',0,0);  
        $this->SetY(30);
        $this->SetX(70);
        $this->Cell(0, 7, utf8_decode(': [01309849] GINEZ CHOQUE PERCY ARTURO'),'C');  
        $this->SetY(30);
        $this->Cell(0, 7, utf8_decode('TIPO DE VERIFICACIÓN: FÍSICA ( X )  DIGITAL (  )'),0,1,'R');  
        
        $this->SetFont('Helvetica','B',8);
        $this->SetY(39);
        $this->SetX(9);
        $this->MultiCell(12, 5, utf8_decode(' N° de Orden'),1,0,'C');
        $this->SetFont('Helvetica','B',9);
        $this->SetY(39);
        $this->SetX(21);
        $this->Cell(266, 5, utf8_decode('DESCRIPCION'),1,0,'C',true);
        $this->SetY(44);
        $this->SetX(21);
        $this->Cell(22, 5, utf8_decode('Código'),1,0,'C',true);
        $this->Cell(65, 5, utf8_decode('Denominación'),1,0,'C',true);
        $this->Cell(18, 5, utf8_decode('Marca'),1,0,'C',true);
        $this->Cell(19, 5, utf8_decode('Modelo'),1,0,'C',true);
        $this->Cell(8, 5, utf8_decode('Tipo'),1,0,'C',true);
        $this->Cell(14, 5, utf8_decode('Color'),1,0,'C',true);
        $this->Cell(22, 5, utf8_decode('Serie'),1,0,'C',true);
        $this->Cell(22, 5, utf8_decode('Dimensiones'),1,0,'C',true);
        $this->Cell(6, 5, utf8_decode('Sit'),1,0,'C',true);
        $this->Cell(6, 5, utf8_decode('Est'),1,0,'C',true);
        $this->Cell(18, 5, utf8_decode('Item'),1,0,'C',true);
        $this->Cell(46, 5, utf8_decode('Observaciones'),1,1,'C',true);
        $this->SetX(9);

    }

    public function Footer()
    {
        $this->SetY(-15);
        $this->Cell(0, 20, utf8_decode($this->nombre),'C');  
        $this->SetFont('Arial','I',8);
    }


    function FancyTable($data) {
        $wid = [12,22,65,18,19,8,14,22,22,6,6,18,46,9];

        // Calculate the height of the row
        $h=6;   
        $nb = 0;
        // Draw the cells of the row
        foreach ($data as $key=>$item){
            $this->CheckPageBreak($h);
            if($item->tipo == 'ACTIVO FIJO'){
                $this->SetFont('Helvetica','B',8);
            }else {
                $this->SetFont('Helvetica','',8);
            }
            $this->SetX(9); 
            $temp = 0;
            $nb = max($nb,$this->NbLines($wid[1],$item->descripción));
            $temp = max($nb,$this->NbLines($wid[8],$item->medidas));
            if($nb < $temp){$nb=$temp;}
            $temp = max($nb,$this->NbLines($wid[12],$item->observaciones));
            if($nb < $temp){$nb=$temp;}
            //$h = 5*$nb;
            $h = 5*2;
            

            $t = "";
            if($item->tipo == 'ACTIVO FIJO'){
                $t = 'AF';
            }
            if($item->tipo == 'NO DEPRECIABLE'){
                $t = 'NP';
            }
            if($item->tipo == 'OTROS' || $item->tipo == '' ){
                $t = 'AU';
            }
    
            $w = 60;
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Rect($x,$y,$wid[0],$h);
            $this->Cell($wid[0],5,$key+1,0,'C');

            $this->SetXY($x+$wid[0],$y);
            $this->Rect($x+$wid[0],$y,$wid[1],$h);
            $this->Cell($wid[1],5,$item->codigo,0,'C');

            $this->SetXY($x+$wid[0]+$wid[1],$y);            
            $this->Rect($x+$wid[0]+$wid[1],$y,$wid[2],$h);
            $this->MultiCell($wid[2],5,utf8_decode($item->descripcion),0);

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2],$y,$wid[3],$h);
            $this->Cell($wid[3],5,utf8_decode($item->marca),0);

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3],$y,$wid[4],$h);
            $this->Cell($wid[4],5,utf8_decode($item->modelo),0);

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4],$y,$wid[5],$h);
            $this->Cell($wid[5],5,$t,0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5],$y,$wid[6],$h);
            $this->Cell($wid[6],5,utf8_decode($item->color),0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6],$y,$wid[7],$h);
            $this->Cell($wid[7],5,utf8_decode($item->nro_serie),0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7],$y,$wid[8],$h);
            $this->MultiCell($wid[8],5,utf8_decode($item->medidas),0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8],$y,$wid[9],$h);
            $this->Cell($wid[9],5,utf8_decode("U"),0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8]+$wid[9],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8]+$wid[9],$y,$wid[10],$h);
            $this->Cell($wid[10],5,$item->estado,0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8]+$wid[9]+$wid[10],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8]+$wid[9]+$wid[10],$y,$wid[11],$h);
            $this->Cell($wid[11],5,$item->estado,0,'C');

            $this->SetXY($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8]+$wid[9]+$wid[10]+$wid[11],$y);            
            $this->Rect($x+$wid[0]+$wid[1]+$wid[2]+$wid[3]+$wid[4]+$wid[5]+$wid[6]+$wid[7]+$wid[8]+$wid[9]+$wid[10]+$wid[11],$y,$wid[12],$h);
            $this->MultiCell($wid[12],5,utf8_decode($item->observaciones),0,'L');

            $this->SetXY($x+$wid[3],$y);
            $this->Ln($h);
            $h=0;
            $nb=0;
        }


    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger - 1)
            $this->AddPage($this->CurOrientation);
    }

}




