<!DOCTYPE html>
<html lang="es">
<head>
    <style>
        *{
            margin:0cm 0cm;
            padding: 0cm 0cm;
            font-size: 11pt;
            font-weight: 400;
            font-family: 'Ubuntu', sans-serif;
        }
        .page-break {
	        page-break-after: always;
	    }
    </style>
</head>

@if ($responsable2 === null)
<body style="margin: 3.25cm 0cm 3.5cm 0cm; font-family: 'Ubuntu', sans-serif; " >
@else    
<body style="margin: 3.75cm 0cm 3.5cm 0cm; font-family: 'Ubuntu', sans-serif; " >
@endif
    <div class="container">
    <header style="position: fixed;
        display:flex;
        top: -40;
        left: -10;
        rigth: 0;
        height: 240px;
        /* background:pink; */
        width:100vw;
        color: Black;
        font-family: 'Ubuntu', sans-serif;
        text-align: center;">
        <table>
            <tr style="">
                <td valgin="top">
                    <div style="width:270px; text-align:left; font-family: 'Ubuntu', sans-serif;">
                        <span style="font-size:13pt; stroke:#000000; ">Universidad Nacional del Altiplano</span>
                        <span style="font-size:10pt;">Comisión de Inventario Activos Fijos 2022</span>
                    </div>
                </td>
                <td align="center">
                    <div style=" width:540px; margin-top:50px;">
                        <div><span style="font-size:13pt;"> FORMATO DE FICHA DE LEVANTAMIENTO DE INFORMACIÓN </span></div>
                        <span style="text-align:center; font-size:11pt;">INVENTARIO PATRIMONIAL 2022</span>
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
                        <span style="text-align:center; font-size:11pt;">Dependencia</span>                        
                    </div>
                </td>
                <td colspan="2" width="220px" style=" white-space: nowrap; text-overflow: ellipsis; max-width: 550px;">
                    <div style="text-align: left; overflow:hidden;">:<span style="font-size:11pt;"> @foreach ($oficina as $o){{ $o->nombre }} - {{ $o->dependencia }}  @endforeach </span> </div>
                </td>
                <td align="right" width="220px">
                    <div style="  margin-right:1cm;">
                        <span style="text-align:center; font-size:11pt;">ID: @foreach ($oficina as $o){{ $o->iduoper }}@endforeach @foreach ($responsable as $re) {{ $re->dni }}-{{$num_doc}} @endforeach</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="margin-top: 0px;">
                        <span style="text-align:center; font-size:11pt;">[DNI]Apellidos y Nombres</span>
                    </div>
                </td>
                <td style="" >
                    <div style="text-align: left">
                        <span style="text-align:center; font-size:11pt;">
                            @foreach ($responsable as $re)<span>: [{{ $re->dni }}] {{ $re->paterno }} {{ $re->materno }} {{$re->nombres}} </span> @endforeach
                        </span>
                    </div>
                </td>
                <td colspan="2" align="right" style=" margin-right:1cm;" >
                    <div style=" margin-right:1cm;">
                            <span style="margin-right:0.25cm; font-size:11pt;">TIPO DE VERIFICACIÓN:</span><span style="font-size:11pt; margin-right:0.25cm;" > FÍSICA ( X ) </span> <span style="font-size:11pt;" > DIGITAL ( &nbsp; ) </span>                         
                    </div>
                </td>
            </tr>
            @if ($responsable2 !== null)
            <tr>
                <td>
                </td>
                <td style="" >
                    <div style="text-align: left">
                           <span>: [{{ $responsable2->dni }}] {{ $responsable2->paterno }} {{ $responsable2->materno }} {{$responsable2->nombres}} </span>
                    </div>
                </td>
                <td colspan="2" align="right" style=" margin-right:1cm;" >
                </td>
            </tr>
            @endif
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
        height: 180px;
        /* background-color: #46c66b; */
        color: black;
        text-align: center;">
        <table style="width: 100%">
            <tr>
                <td valign="top">
                    <div>
                        <span style="font-size:9pt;">- El usuario declara haber mostrado todos los bienes muebles que se encuentran bajo su responsabilidad y no contar con más bienes muebles materia de inventario.</span>
                    </div>
                    <div>
                        <span style="font-size:9pt;">- El usuario es responsable de la permanencia y conservación de cada uno de los bienes muebles dscritos, recomendánse tomar las precausiones del caso para evitar sustracciones deteriodos, etc.</span>
                    </div>
                    <div>
                        <span style="font-size:9pt;">- Cualquier necesidad de traslado del bien mueble dentro o fuera del local de la Entidad u Organización de la Entidad, es previamente comunicado al encargado de la OCP.</span>
                    </div>
                </td>
            </tr>   
        </table>
        <table style="width: 100%">
            <tr>
                {{-- <td align="center">
                    <div style=" margin-top: 50px; padding: 0 30px; margin-left:20px; ">
                        <div style="text-align: center; padding-top: 5px; width:280px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">JEFE INMEDIATO SUPERIOR</span>
                        </div>
                        <dir style="margin-top:0px; margin-left:25px; text-align:left; ">
                            <span style="font-size:10pt;">DNI:</span>
                        </dir>
                    </div>
                </td> --}}

                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 30px; margin-left:100px;">
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
                        <div style="text-align: center; width:300px; padding-top: 5px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">INVENTARIADOR(ES)</span>
                        </div>
                        <dir style="margin-top:0px; text-align:left; margin-left:5px;  ">
                            <span style="font-size:10pt;"> &nbsp; </span>
                        </dir>
                    </div>
                </td>

            </tr>
        </table>
        <span></span>
    </footer>

    {{-- <div style="height: 10px">
        <span></span>
    </div> --}}
    <div style="margin-left: -10px; margin-right:-10px;  font-size:10pt; ">
    <table style="width: 100%; border-collapse: collapse; ">
        <thead >
            <tr>
                <th rowspan="2" align="center" style="border: solid 1px black; background: #cdcdcd4D; stroke:#000000; ">
                    <div><span style="font-size: 7pt; font-weight:bold;">N° de</span> </div><div> <span style="font-size: 7pt; font-weight:bold;">Orden</span> </div></th>
                <th colspan="12" style="border: solid 1px black; background: #cdcdcd4D;">
                    <span style="font-size: 7pt; font-weight:bold;">DESCRIPCION</span>                    
                </th>
            </tr>
            <tr align="center">
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;"> Código </span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Denominación</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Marca</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Modelo</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Tipo</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Color</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Serie</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Dimensiones</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Sit</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Est</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Item</span> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 7pt; font-weight:bold;">Observación</span> </th>
            </tr>
        </thead>
        <tbody>
        @foreach ($bienes as $key=>$bien)
            @if ($bien->tipo === 'ACTIVO FIJO')
                <tr>
                    <td style="border: solid 1px black; width:20px; text-align:center;"><span style="font-size: 7pt;  font-weight: bold; ">{{$key+1}}</span></td>
                    <td style="border: solid 1px black; width:80px; text-align:center; "><span style="font-size: 7pt;  font-weight: bold;">{{$bien->codigo}}</span></td>
                    <td style="border: solid 1px black; width:200px;"><span style="font-size: 7pt;  font-weight: bold;">{{ $bien->descripcion}}</span></td>
                    <td style="border: solid 1px black; width:80px;"><span style="font-size: 7pt;  font-weight: bold;">{{ $bien->marca }}</span></td>
                    <td style="border: solid 1px black; width:80px; "><span style="font-size: 7pt;  font-weight: bold;">{{ $bien->modelo }}</span></td>
                    <td style="border: solid 1px black;" align="center" ><span style="font-size: 7pt;  font-weight: bold;">
                        @if ($bien->tipo === 'ACTIVO FIJO')
                        AF
                        @elseif ($bien->tipo === 'NO DEPRECIABLE')
                        ND
                        @elseif ($bien->tipo === 'OTROS')
                        AU
                        @else
                        @endif
                    </span></td>
                    <td style="border: solid 1px black; width:80px;"><span style="font-size: 7pt;  font-weight: bold;">{{ $bien->color }}</span></td>
                    <td style="border: solid 1px black; width:80px;"><div style="width:80px; overflow:hidden;"><span style="font-size: 7pt;  font-weight: bold;">{{ $bien->nro_serie }}</span></div></td>
                    <td style="border: solid 1px black;width:80px;" align="center"><span style="font-size: 7pt;  font-weight: bold;">{{ $bien->medidas }}</span></td>
                    <td style="border: solid 1px black;" align="center">
                        @if ($bien->estado_uso === 'EN USO')
                        U
                        @else
                        D
                        @endif
                    </td>
                    <td style="border: solid 1px black; width:30px; text-align:center;"><span style="font-size: 7pt;  font-weight: bold;">
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
                    <td style="border: solid 1px black; width:60px;" align="center"><span style="font-size: 7pt;  font-weight: bold;">{{$bien->corr_area}} - {{$bien->corr_num}}</span></td>
                    <td style="border: solid 1px black; width:150px;"><span style="font-size: 7pt;  font-weight: bold;">{{$bien->observaciones}}</span></td>
                </tr>
            @else
                
                <tr>
                    <td style="border: solid 1px black; width:20px; text-align:center;"><span style="font-size: 7pt; ">{{$key+1}}</span></td>
                    <td style="border: solid 1px black; width:80px; text-align:center; "><span style="font-size: 7pt;">{{$bien->codigo}}</span></td>
                    <td style="border: solid 1px black; width:200px;"><span style="font-size: 7pt;">{{ $bien->descripcion}}</span></td>
                    <td style="border: solid 1px black; width:80px;"><span style="font-size: 7pt;">{{ $bien->marca }}</span></td>
                    <td style="border: solid 1px black; width:80px;"><span style="font-size: 7pt;">{{ $bien->modelo }}</span></td>
                    <td style="border: solid 1px black;" align="center"><span style="font-size: 7pt;">
                        @if ($bien->tipo === 'ACTIVO FIJO')
                        AF
                        @elseif ($bien->tipo === 'NO DEPRECIABLE')
                        ND
                        @elseif ($bien->tipo === 'OTROS')
                        AU
                        @else
                        @endif
                    </span></td>
                    <td style="border: solid 1px black;"><span style="font-size: 7pt;">{{ $bien->color }}</span></td>
                    <td style="border: solid 1px black;"><div style="width:80px; overflow:hidden;"><span style="font-size: 7pt;">{{ $bien->nro_serie }}</span></div></td>
                    <td style="border: solid 1px black;width:80px;" align="center"><span style="font-size: 7pt;">{{ $bien->medidas }}</span></td>
                    <td style="border: solid 1px black;" align="center">
                        @if ($bien->estado_uso === 'EN USO')
                        U
                        @else
                        D
                        @endif
                    </td>
                    <td style="border: solid 1px black;  width:30px; text-align:center;"><span style="font-size: 7pt; ">
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
                    <td style="border: solid 1px black; width:60px;" align="center"><span style="font-size: 7pt;">{{$bien->corr_area}} - {{$bien->corr_num}}</span></td>
                    <td style="border: solid 1px black; width:150px;"><span style="font-size: 7pt;">{{$bien->observaciones}}</span></td>
                </tr>

        @endif

        @endforeach
        </tbody>

        <tr>
            <td  style="border: solid 1px black;" colspan="13">
            <div style="padding-top: 15px; padding-bottom: 25px;">
                <div>
                    <span style="font-size: 7pt;">Inventariador(es):</span>
                </div>
                <div>
                    @foreach ($inventaristas as $a)<div style="font-size: 7pt;">{{ $a->nombres }} {{ $a->apellidos }} </div> @endforeach
                </div>
            </div>
            </td>
        </tr>

        <tr>
            <td colspan="13">
                <span>Fecha y Hora:</span><span> {{ $ldate }} {{$lhour}} </span>
            </td>
        </tr>
        <tr>
            <td colspan="13">
                <div>
                    <span style="font-size:9pt; letter-spacing: -0.1pt; ">(1) Uso (U). Desuso(D)</span>
                </div>
                <div>
                    <span style="font-size:9pt; letter-spacing: -0.1pt; ">(2) El estado consignado en base a la siguiente escala: Bueno, Regular, Malo, Chatarra y RAEE. En caso de semovientes utilizar escala de acuerdo a su naturaleza</span>
                </div>
                <div>
                    <span style="font-size:9pt; letter-spacing: -0.1pt; ">(3) Activos Fijos (AF). Bienes no depresiables(ND). Bienes auxiliares(AU)</span>
                </div>
            </td>
        </tr>
    </table>
    </div>

        <script type="text/php">
            if ( isset($pdf) ) {
                $pdf->page_script('
                    $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                    $pdf->text(360, 125, "Pág $PAGE_NUM de $PAGE_COUNT", $font, 40);
                ');
            }
    	</script>
    </div>
</body>

</html>
