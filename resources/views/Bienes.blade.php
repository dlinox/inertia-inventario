<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CARGO </title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');
        *{
            margin:0cm 0cm;
            padding: 0cm 0cm;
            font-size: 11pt;
            font-weight: 400;
            font-family: 'Ubuntu', sans-serif;
        }
    </style>
</head>
<body style="margin: 3.05cm 0cm 3cm 0cm; font-family: 'Ubuntu', sans-serif; " >
    <header style="position: fixed;
        display:flex;
        top: -40;
        left: -10;
        rigth: 0;
        height: 160px;
        /* background:pink; */
        width:100vw;
        color: Black;
        font-family: 'Ubuntu', sans-serif;
        text-align: center;">
        <table>
            <tr style="">
                <td valgin="top">
                    <div style="width:270px; text-align:left; font-family: 'Ubuntu', sans-serif;">
                        <span style="font-size:13pt; stroke:#000000; ">Universidad Nacional de Altiplano</span>
                        <span style="font-size:10pt;">Comisión de Inventario Activos Fijos 2022</span>
                    </div>
                </td>
                <td align="center">
                    <div style=" width:540px; margin-top:50px;">
                        <div><span style="font-size:14pt;"> INVENTARIO PATRIMONIAL 2022 </span></div>
                        <span style="text-align:center; font-size:11pt;">FORMATO DE TOMA DE INVENTARIO DE BIENES MUEBLES Y EQUIPOS</span>
                    </div>
                </td>
                <td>
                    <div style="width: 270px;">
                        <span></span>
                    </div>
                </td>
            </tr>
        </table>
        <div style="height: 10px; widht:100%;">
            <span></span>
        </div>
        <table style="width:100%;">
            <tr>
                <td>
                    <div style="width:188px;">
                        Dependencia
                    </div>
                </td>
                <td width="650px" style=" white-space: nowrap; text-overflow: ellipsis; max-width: 650px;">
                    <div style="text-align: left; overflow:hidden;">: @foreach ($oficina as $o){{ $o->nombre }} - {{ $o->dependencia }}  @endforeach  </div>
                </td>
                <td align="right">
                    <div style=" width:188px; margin-right:.5cm; ">
                        <span>ID: 61.54.1-42262469-1</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <span>[DNI]Apellidos y Nombres</span>
                    </div>
                </td>
                <td style=" width: 100%">
                    <div style="text-align: left">
                            @foreach ($responsable as $re)<span>: [{{ $re->dni }}] {{ $re->paterno }} {{ $re->materno }} {{$re->nombres}} </span> @endforeach
                    </div>
                </td>
                <td>
                    <div >
                    </div>
                </td>
            </tr>

        </table>
        <div>
        </div>
    </header>
    <footer
        style="
        position: fixed;
        bottom: -35;
        left: -10;
        right: -10;
        height: 160px;
        /* background-color: #46c66b; */
        color: black;
        text-align: center;">
        <table style="width: 100%">
            <tr>
                <td valign="top"><span style="font-size: 8pt; width:20px;">NOTA:</span> </td>
                <td valign="top" colspan="3">
                    <div style="text-align:justify; font-size:8pt; width:100%; padding-top:5px; letter-spacing: -0.1pt;">
                        EL TRABAJADOR ES RESPONSABLE DIRECTO DE LAS EXISTENCIAS, PERMANENCIA, CONSERVACIÓN Y BUEN USO DE CADA UNO DE LOS BIENES DESCRITOS POR LO QUE SE RECOMIENDA TOMAR
                        LAS PROVIDENCIASA DEL CASO PARA EVITAR PERDIDAS, SUSTRACCION, DETERIODO, ETC., EN CASO DE CUALQUIER MOVIMIENTO DENTRO O FUERA DE LA ENTIDAD DEBERA SER COMUNICADO AL
                        ENCARGO DE CONTROL PATRIMONIAL, BAJO RESPONSABILIDAD.
                        <span style="font-size:8pt; letter-spacing: -0.1pt; margin-left: 252px; margin-right:20px;">*Medida: Largo x Ancho x Altura </span>
                        <span style="font-size:8pt; letter-spacing: -0.1pt;">**Estado:(N)Nuevo, (R)Regular, (M)Malo, (Y) Chatarra</span>
                    </div>

                </td>
        </table>
        <table style="width: 100%">
            <tr>
                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 30px; margin-left:20px; ">
                        <div style="text-align: center; padding-top: 5px; width:280px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">JEFE INMEDIATO SUPERIOR</span>
                        </div>
                        <dir style="margin-top:0px; margin-left:25px; text-align:left; ">
                            <span style="font-size:10pt;">DNI:</span>
                        </dir>
                    </div>
                </td>

                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 0px;">
                        <div style="text-align: center; padding-top: 5px; width:280px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">RESPONSABLE DE LOS BIENES</span>
                        </div>
                        <dir style="margin-top:0px; text-align:left; margin-left:15px; ">
                            <span style="font-size:10pt;">DNI:</span>
                        </dir>
                    </div>
                </td>

                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 0px;">
                        <div style="text-align: center; width:280px; padding-top: 5px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">INVENTARIADOR(ES)</span>
                        </div>
                        <dir style="margin-top:0px; text-align:left; margin-left:5px;  ">
                            <span style="font-size:10pt;"> &nbsp; </span>
                        </dir>
                    </div>
                </td>

            </tr>
        </table>
    </footer>

    {{-- <div style="height: 10px">
        <span></span>
    </div> --}}
    <div style="margin-left: -10px; margin-right:-10px;  font-size:10pt; ">
    <table style="width: 100%; border-collapse: collapse; ">
        <thead >
        <tr align="center">
            <th>Nro</th>
            <th>Código</th>
            <th>Descripción de Mueble ó Equipo</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Serie</th>
            <th>Medida*</th>
            <th>Color</th>
            <th>Est**</th>
            <th>Item</th>
            <th>Observaciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($bienes as $key=>$bien)
            @if ($bien->tipo === '3')
                <tr>
                    <td style="border: solid 1px black; width:20px; text-align:center;"><span style="font-size: 9pt;  font-weight: bold; ">{{$key+1}}</span></td>
                    <td style="border: solid 1px black; width:80px; text-align:center; "><span style="font-size: 8pt;  font-weight: bold;">{{$bien->codigo}}</span></td>
                    <td style="border: solid 1px black; width:320px;"><span style="font-size: 8pt;  font-weight: bold;">{{ $bien->descripcion}}</span></td>
                    <td style="border: solid 1px black;"><span style="font-size: 8pt;  font-weight: bold;">{{ $bien->modelo }}</span></td>
                    <td style="border: solid 1px black;"><span style="font-size: 8pt;  font-weight: bold;">{{ $bien->marca }}</span></td>
                    <td style="border: solid 1px black;"><span style="font-size: 8pt;  font-weight: bold;">{{ $bien->nro_serie }}</span></td>
                    <td style="border: solid 1px black;width:100px;"><span style="font-size: 8pt;  font-weight: bold;">{{ $bien->medidas }}</span></td>
                    <td style="border: solid 1px black;"><span style="font-size: 8pt;  font-weight: bold;">{{ $bien->color }} </span></td>
                    <td style="border: solid 1px black;  width:30px; text-align:center;"><span style="font-size: 8pt;  font-weight: bold;">
                        @if ($bien->id_estado === 1)
                        N
                        @elseif ($bien->id_estado === 2)
                        R
                        @elseif ($bien->id_estado === 3)
                        B
                        @elseif ($bien->id_estado === 4)
                        M
                        @else
                        Y
                        @endif
                    </span></td>
                    <td style="border: solid 1px black; width:40px; text-align:center;"><span style="font-size: 8pt;  font-weight: bold;"><!--$bien->nro_orden --></span></td>
                    <td style="border: solid 1px black; width:150px;"><span style="font-size: 8pt;  font-weight: bold;">{{$bien->observaciones}}</span></td>
                </tr>
            @else
            <tr>
                <td style="border: solid 1px black; width:20px; text-align:center;"><span style="font-size: 8pt;">{{$key+1}}</span></td>
                <td style="border: solid 1px black; width:80px; text-align:center;"><span style="font-size: 8pt;">{{$bien->codigo}}</span></td>
                <td style="border: solid 1px black; width:320px;"><span style="font-size: 8pt;">{{ $bien->descripcion}}</span></td>
                <td style="border: solid 1px black;"><span style="font-size: 8pt;">{{ $bien->modelo }}</span></td>
                <td style="border: solid 1px black;"><span style="font-size: 8pt;">{{ $bien->marca }}</span></td>
                <td style="border: solid 1px black;"><span style="font-size: 8pt;">{{ $bien->nro_serie }}</span></td>
                <td style="border: solid 1px black; width:100px;"><span style="font-size: 8pt;"> {{ $bien->medidas }} </span></td>
                <td style="border: solid 1px black;"><span style="font-size: 8pt;">{{ $bien->color }} </span></td>
                <td style="border: solid 1px black; width:30px; text-align:center;"><span style="font-size: 8pt;">
                    @if ($bien->id_estado === 1)
                    N
                    @elseif ($bien->id_estado === 2)
                    R
                    @elseif ($bien->id_estado === 3)
                    B
                    @elseif ($bien->id_estado === 4)
                    M
                    @else
                    Y
                    @endif
                </span></td>
                <td style="border: solid 1px black; width:40px; text-align:center;"><span style="font-size: 8pt;"><!-- $bien->nro_orden --> </span></td>
                <td style="border: solid 1px black; width:150px;"><span style="font-size: 8pt;">{{ $bien->observaciones }} </span></td>
            </tr>

        @endif

        @endforeach
        </tbody>

        <tr>
            <td  style="border: solid 1px black;" colspan="11">
            <div style="padding-top: 15px; padding-bottom: 25px;">
                <div>
                    <span style="font-size: 9pt;"">Inventariador(es):</span>
                </div>
                <div>
                    @foreach ($inventaristas as $a)<div style="font-size: 9pt;">{{ $a->nombres }} {{ $a->apellidos }} </div> @endforeach
                </div>
            </div>
            </td>
        </tr>

        <tr>
            <td colspan="11">
                <span>Fecha y Hora:</span><span> {{ $ldate }} {{$lhour}} </span>
            </td>
        </tr>
    </table>
    </div>

    <div style="">


	<script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(775, 20, "Pág $PAGE_NUM / $PAGE_COUNT", $font, 10);
            ');
        }
    	</script>
</body>

</html>
