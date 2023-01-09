<table>
    <thead>
        <tr>
            <th>Id</th>
            <th>Tipo</th>
            <th>Idreg_anterior</th>
            <th>Cod_ubicación</th>
            <th>Codigo</th>
            <th>Descripción</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Medidas</th>
            <th>Color</th>
            <th>Observaciones</th> 
            <th>Idbienk</th>
            <th>Dep</th>
            <th>Corr</th>
            <th>Estado Uso</th>
            <th>N° Ambiente</th>
            <th>DNI</th>
            <th>Responsable</th>
            <th>Dependencia</th>
            <th>Oficina</th>
            <th>inventariador</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->tipo }}</td>
            <td>{{ $invoice->idreg_anterior }}</td>
            <td>{{ $invoice->cod_ubicacion }}</td>
            <td>{{ $invoice->codigo }}</td>
            <td>{{ $invoice->descripcion }}</td>
            <td>{{ $invoice->modelo }}</td>
            <td>{{ $invoice->marca }}</td>
            <td>{{ $invoice->medidas }}</td>
            <td>{{ $invoice->color }}</td>
            <td>{{ $invoice->observaciones) }}</td>
            <td>{{ $invoice->idbienk }}</td>
            <td>{{ $invoice->corr }}</td>
            <td>{{ $invoice->estado_uso) }}</td>
            <td>{{ $invoice->num_ambiente) }}</td>
            <td>{{ $invoice->dni }}</td>
            <td>{{ $invoice->responsable }}</td>
            <td>{{ $invoice->dependencia }}</td>
            <td>{{ $invoice->oficina }}</td>
            <td>{{ $invoice->inventariador) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>