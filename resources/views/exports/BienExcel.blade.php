<table style="border: solid 2pt  red;">
    <tr>
      <td></td>
      <td></td>
      <td colspan="8" valign="center" align="center" style="font-size:14pt; text-algin:center;" ><p>Universidad Nacional del Altiplano de Puno</p></td>
      <td></td>
    </tr>

    <tr>
        <td></td>
        <td></td>
        <td colspan="8" valign="center" align="center" style="font-size:14pt; text-algin:center;" > @foreach ($oficina as $ofi)<span>{{ $ofi->nombre }} </span> @endforeach</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="8" valign="center" align="center" style="font-size:14pt; text-algin:center;">Inventario de bienes 2022</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td></td><td></td>
        <td></td><td></td>
        <td></td><td></td>
      </tr>
      <tr>
        <td colspan="2">Oficina:</td>
        <td colspan="6">@foreach ($area as $a)<span>{{ $a->nombre }} </span> @endforeach</td>
        <td colspan="2">N° Reporte:</td>
        <td valign="center" align="right">RU00000001</td>
      </tr>
      <tr>
        <td colspan="2" >Responsable:</td>
        <td colspan="6">@foreach ($responsable as $re)<span>{{ $re->nombres }} {{ $re->paterno }} {{ $re->materno }} </span> @endforeach</td>
        <td colspan="2">Fecha:</td>
        <td valign="center" align="right">{{ $ldate }}</td>
      </tr>
      <tr>
        <td colspan="2">Responsable 2:</td>
        <td colspan="6"><div style="text-align: left;"> <span> @foreach ($responsable2 as $re)<span>{{ $re->nombres }} {{ $re->paterno }} {{ $re->materno }} &nbsp; </span> @endforeach </div>
        </td>
        <td colspan="2">Hora:</td>
        <td valign="center" align="right"> {{$lhour}}</td>
      </tr>
      <tr>
        <td colspan="2">Inventarista:</td>
        <td colspan="6"> @foreach ($inventarista as $inv)<span>{{ $inv->nombres }} {{ $inv->apellidos }} </span> @endforeach </td>
        <td> </td>
        <td> </td>
      </tr>
    </table>

<table>
    <thead>
    <tr>
        <th valign="center" align="center">N°</th>
        <th valign="center" align="left">Codigo</th>
        <th valign="center" align="left">Descripción de mueble o equipo</th>
        <th valign="center" align="left">Modelo</th>
        <th valign="center" align="left">Marca</th>
        <th valign="center" align="left">Serie</th>
        <th valign="center" align="left">Medida*</th>
        <th valign="center" align="left">Color</th>
        <th valign="center" align="left">Est**</th>
        <th valign="center" align="left">Item</th>
        <th valign="center" align="left">Observaciones</th>

    </tr>
    </thead>
    <tbody>
    @foreach($invoices as $key=>$invoice)
        <tr>
            <td valign="top" align="center">{{ $key+1 }}</td>
            <td valign="top" align="left">{{ $invoice->codigo }}</td>
            <td valign="top" align="left">{{ $invoice->nombre }}</td>
            <td valign="top" align="left">{{ $invoice->modelo }}</td>
            <td valign="top" align="left">{{ $invoice->marca }}</td>
            <td valign="top" align="left">{{ $invoice->serie }}</td>
            <td valign="top" align="left"></td>
            <td valign="top" align="left"></td>
            <td valign="top" align="left">
                @if ($invoice->id_estado === 1)
                Nuevo
                @elseif ($invoice->id_estado === 2)
                Bueno
                @elseif ($invoice->id_estado === 3)
                Malo
                @elseif ($invoice->id_estado === 4)
                Muy Malo
                @else ($bien->id_estado === 5)
                Chatarra
            @endif
            </td>
            <td valign="top" align="left">{{ $invoice->numero }}</td>
            <td valign="top" align="left">{{ $invoice->observaciones }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
