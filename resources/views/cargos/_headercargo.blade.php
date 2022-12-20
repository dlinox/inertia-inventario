<html><head>
    <script>
    function subst() {
      var vars={};
      var x=document.location.search.substring(1).split('&');
      for(var i in x) {var z=x[i].split('=',2);vars[z[0]] = unescape(z[1]);}
      var x=['frompage','topage','page','webpage','section','subsection','subsubsection'];
      for(var i in x) {
        var y = document.getElementsByClassName(x[i]);
        for(var j=0; j<y.length; ++j) y[j].textContent = vars[x[i]];
      }
    }
    </script></head><body style="border:0; margin: 0;" onload="subst()">
    <table style="border-bottom: 1px solid black; width: 100%">
      <tr>
        <td class="section"></td>
        <td style="text-align:right">
          Page <span class="page"></span> of <span class="topage"></span>
        </td>
      </tr>
    </table>
    </body></html>








{{-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cargo en PDF</title>
</head>

<body style="border:0; margin: 0; font-family: 'Helvetica'; letter-spacing:0.05rem; margin-left:5px"  >
    <table>
        <tr style="">
            <td valgin="top">
                <div style="width:370px; text-align:left;">
                    <div><span style="font-size:16pt; stroke:#000000;">Universidad Nacional del Altiplano</span></div>
                    <span style="font-size:12pt;">Comisión de Inventario Activos Fijos 2022</span>
                </div>
            </td>
            <td align="center">
                <div style=" width:690px; margin-top:50px;" style="font-weight:bold;">
                    <div><span style="font-size:16pt;"> FORMATO DE FICHA DE LEVANTAMIENTO DE INFORMACIÓN </span></div>
                    <span style="text-align:center; font-size:14pt;">INVENTARIO PATRIMONIAL 2022</span>
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
    <table style="width:100%; margin-right:10px;">
        <tr>
            <td style="width: 220px;">
                <div style="">
                    <span style="text-align:center; font-size:14pt;">Dependencia</span>                        
                </div>
            </td>
            <td colspan="2" width="540px" style=" white-space: nowrap; text-overflow: ellipsis; max-width: 550px;">               
                <div style="text-align: left; overflow:hidden;">:<span style="font-size:14pt;"> @foreach ($oficina as $o){{ $o->nombre }} - {{ $o->dependencia }}  @endforeach </span> </div>
            </td>
            <td align="right" width="250px" style="">
                <div style="margin-right:7px;">
                    <span style="text-align:center; font-size:14pt;">ID: @foreach ($oficina as $o){{ $o->iduoper }}@endforeach @foreach ($responsable as $re) {{ $re->dni }}-{{$num_doc}} @endforeach</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <div style="margin-top: 0px;">
                    <span style="text-align:center; font-size:14pt;">[DNI]Apellidos y Nombres</span>
                </div>
            </td>
            <td style="width:680px;">
                <div style="text-align: left">
                    <span style="text-align:center; font-size:14pt;">
                        @foreach ($responsable as $re)<span>: [{{ $re->dni }}] {{ $re->paterno }} {{ $re->materno }} {{$re->nombres}} </span> @endforeach
                    </span>
                </div>
            </td>
            <td colspan="2" align="right" style="margin-right:5px;">
                <div style="margin-right:7px;">
                    <span style="margin-right:0.20cm; font-size:13.5pt;">TIPO DE VERIFICACIÓN:</span><span style="font-size:13.5pt; margin-right:0.20cm;" > FÍSICA ( X ) </span> <span style="font-size:13.5pt;" > DIGITAL ( &nbsp; ) </span>                         
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
</body></html> --}}