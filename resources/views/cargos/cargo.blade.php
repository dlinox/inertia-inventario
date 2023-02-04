@extends('cargos.layout')
@section('content')
<div style="margin-left: 0px; margin-right:0px; font-size:11pt; font-family: sans-serif;">
    <table style="width: 100%; height:100%; border-collapse: collapse; "  cellspacing="0">
        <thead style="background-color: #f3f3f3;">
            <tr style="border-collapse: collapse; background:white;">
                <th colspan="13"><div>&nbsp;</div></th>
            </tr>
            <tr>
                <th rowspan="2" align="center" style="border: solid 1px black; stroke:#000000;">
                    <div style=""><span style="font-size: 11pt; font-weight:bold;">N° de</span> <span style="font-size: 11pt; font-weight:bold;">Orden</span> </div></th>
                <th colspan="12" style="border: solid 1px black; height:26px; background: #cdcdcd4D;">
                    <div style="">
                        <span style="font-size: 11pt; font-weight:bold;">DESCRIPCION</span>                    
                    </div>
                </th>
            </tr>       
            <tr>
                <th style="border: solid 1px black; background: #cdcdcd4D; height:22px;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;"> Código </span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Denominación</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Marca</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Modelo</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Tipo</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Color</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Serie</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Dimensiones</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Sit</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Est</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Item</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 11pt; font-weight:bold;">Observación</span></div> </th>
            </tr>
        </thead>
        <tbody class="salto">
        @foreach ($bienes as $key=>$bien)
            @if ($bien->tipo === 'ACTIVO FIJO')
                <tr class="salto">  
                    <div style="display:block; background:pink; min-weight:36px;">
                    <td valign="center" style="border: solid 1px black; width:10px; text-align:center;"><span style="font-size: 9pt;  font-weight: bold; ">{{$key+1}}</span></td>
                    <td style="border: solid 1px black; width:60px; text-align:center;"><div><span style="font-size: 9pt;  font-weight: bold;">{{$bien->codigo}}</span></div></td>
                    <td style="border: solid 1px black; min-height: 30px; width:220px;">
                        <div style="max-height: 30px; overflow:hidden; font-size: 9pt;  font-weight: bold; margin-top:-3px;">
                            {{$bien->descripcion}}
                        </div>
                    </td>
                    <td style="border: solid 1px black; width:80px;"><div><span style="font-size: 9pt;  font-weight: bold;">{{ $bien->marca }}</span></div></td>
                    <td style="border: solid 1px black; width:80px;"><div><span style="font-size: 9pt;  font-weight: bold;">{{ $bien->modelo }}</span></div></td>
                    <td style="border: solid 1px black; width:30px;" align="center" >
                        <div>
                            <span style="font-size: 9pt; font-weight: bold;">
                                @if ($bien->tipo === 'ACTIVO FIJO')
                                AF
                                @elseif ($bien->tipo === 'NO DEPRECIABLE')
                                ND
                                @elseif ($bien->tipo === 'OTROS')
                                AU
                                @else
                                @endif
                            </span>
                      </div>
                    </td>
                    <td style="border: solid 1px black; width:80px;"><div><span style="font-size: 9pt;  font-weight: bold;">{{ $bien->color }}</span></div></td>
                    <td style="border: solid 1px black; width:80px;"><div style="width:80px; overflow:hidden;"><span style="font-size: 9pt;  font-weight: bold;">{{ $bien->nro_serie }}</span></div></td>
                    <td style="border: solid 1px black; width:70px;" align="center"><div><span style="font-size: 9pt;  font-weight: bold;">{{ $bien->medidas }}</span></div></td>
                    <td style="border: solid 1px black; width:15px;" align="center">
                        <div>
                            <span style="font-size: 9pt; font-weight:bold;">
                                @if ($bien->estado_uso === 'EN USO')
                                U
                                @else
                                D
                                @endif
                            </span>
                        </div>    
                    </td>
                    <td style="border: solid 1px black; width:15px; text-align:center;">
                        <div>
                            <span style="font-size: 9pt;  font-weight: bold;">
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
                            </span>
                    </div>
                </td>
                    <td style="border: solid 1px black; width:60px;" align="center">
                        <div>
                            <span style="font-size: 9pt;  font-weight: bold;">{{$bien->corr_area}} - {{$bien->corr_num}}</span>
                        </div>    
                    </td>
                    <td style="border: solid 1px black; width:200px;">
                        <div style="max-height: 30px; overflow:hidden; font-size: 9pt; width:198px;  font-weight: bold; margin-top:-5px;">
                            {{$bien->observaciones}}
                        </div>
                    </td>
                </div>
            </tr>
            @else
            <tr>
                <div style="">
                    <td valign="center" style="border: solid 1px black; width:10px; text-align:center;"><span style="font-size: 9pt; ">{{$key+1}}</span></td>
                    <td style="border: solid 1px black; width:60px; text-align:center; "><div><span style="font-size: 9pt;">{{$bien->codigo}}</span></div></td>
                    <td style="border: solid 1px black; width:220px;"><div style="max-height: 30px; overflow:hidden; font-size: 9pt; margin-top:8;">{{$bien->descripcion}}</></div></td>
                    <td style="border: solid 1px black; width:80px;"><div><span style="font-size: 9pt;">{{ $bien->marca }}</span></div></td>
                    <td style="border: solid 1px black; width:80px;"><div><span style="font-size: 9pt;">{{ $bien->modelo }}</span></div></td>
                    <td style="border: solid 1px black; width:30px;" align="center"><div><span style="font-size: 9pt;">
                        
                    </span></div></td>
                    <td style="border: solid 1px black; width:80px;"><div><span style="font-size: 9pt;">{{ $bien->color }}</span></div></td>
                    <td style="border: solid 1px black; width:76px;"><div style="width:80px; overflow:hidden;"><span style="font-size: 9pt;">{{ $bien->nro_serie }}</span></div></td>
                    <td style="border: solid 1px black; width:70px;" align="center"><div><span style="font-size: 9pt;">{{ $bien->medidas }}</span></div></td>
                    <td style="border: solid 1px black; width:15px;" align="center"><div><span style="font-size: 9pt;">
                            @if ($bien->estado_uso === 'EN USO')
                            U
                            @else
                            D
                            @endif
                            </span>
                        </div>
                    </td>
                    <td style="border: solid 1px black;  width:15px; text-align:center;">
                        <div>
                            <span style="font-size: 9pt; ">
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
                            </span>
                        </div>
                    </td>
                    <td style="border: solid 1px black; width:60px;" align="center"><div></div><span style="font-size: 9pt;">{{$bien->corr_area}} - {{$bien->corr_num}}</span></div></td>
                    <td style="border: solid 1px black; width:200px;"><div style="max-height: 30px; overflow:hidden; font-size: 9pt; width:198px; margin-top:-8; ">{{$bien->observaciones}}</div></td>
                </div>    
            </tr>
            <tr style="height: 0px;"></tr>

        @endif
        @endforeach

        </tbody>
        <tr>
            <td  style="border: solid 1px black;" colspan="13">
            <div style="padding-top: 5px; padding-bottom: 5px;">
                <div>
                    <span style="font-size: 10pt;">Inventariador(es):</span>
                </div>
                <div>
                    @foreach ($inventaristas as $a)<div style="font-size: 10pt;">{{ $a->nombres }} {{ $a->apellidos }} </div> @endforeach
                </div>
            </div>
            </td>
        </tr>

        <tr>
            <td colspan="13">
                <span style="font-size:10pt;">Fecha y Hora:</span><span> {{ $ldate }} {{$lhour}} </span>
            </td>
        </tr>
        <tr>
            <td colspan="13">
                <div>
                    <span style="font-size:10pt;">(1) Uso (U). Desuso (D).</span>
                </div>
                <div>
                    <span style="font-size:10pt; ">(2) El estado consignado en base a la siguiente escala: Bueno, Regular, Malo, Chatarra y RAEE. En caso de semovientes utilizar escala de acuerdo a su naturaleza</span>
                </div>
                <div>
                    <span style="font-size:10pt; ">(3) Activos Fijos (AF). Bienes no depresiables(ND). Bienes auxiliares(AU)</span>
                </div>
            </td>
        </tr>
    </table>
</div>
    
@endsection