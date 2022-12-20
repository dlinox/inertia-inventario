@extends('cargos.layout')
@section('content')
<div style="margin-left: 0px; margin-right:0px;  font-size:10pt; font-family: Arial; letter-spacing: 0.07rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th rowspan="2" align="center" style="border: solid 1px black; background-color: #cdcdcd4D; stroke:#000000;">
                    <div style=""><span style="font-size: 8.5pt; font-weight:bold;">N° de</span> </div><div> <span style="font-size: 8.5pt; font-weight:bold;">Orden</span> </div></th>
                <th colspan="12" style="border: solid 1px black; background: #cdcdcd4D;">
                    <div style="">
                        <span style="font-size: 8.5pt; font-weight:bold;">DESCRIPCION</span>                    
                    </div>
                </th>
            </tr>
            <tr align="center">
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;"> Nro </span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Registro</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Ubic. - Resp. - Item</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Código</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Tipo</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Cod. interno</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Serie</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Dimensiones</span> </div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Sit</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Est</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Item</span></div> </th>
                <th style="border: solid 1px black; background: #cdcdcd4D;"> <div style=""> <span style="font-size: 8.5pt; font-weight:bold;">Observación</span></div> </th>
            </tr>
        </thead>
    </table>
</div>
@endsection