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
        <th>Idbienk</th>
        <th>Corr_area</th>
        <th>estado_uso</th>
        <th>num_ambiente</th>
        <th>Responsable</th>
    </tr>
    </thead>
    <tbody>
    @foreach($res as $invoice)
        <tr>
            <td>{{ $invoice->id }}</td>
            <td>{{ $invoice->tipo }}</td>
            <td>{{ $invoice->idreg_anterior }}</td>
            <td>{{ $invoice->cod_ubicacion }}</td>
            <td>{{ utf8_encode($invoice->codigo) }}</td>
            <td>{{ $invoice->descripcion }}</td>
            <td>{{ $invoice->modelo }}</td>
            <td>{{ $invoice->marca }}</td>
            <td>{{ $invoice->medidas }}</td>
            <td>{{ $invoice->color }}</td>
            <td>{{ $invoice->observaciones }}</td>
            <td>{{ $invoice->idbienk }}</td>
            <td>{{ $invoice->corr_area }}</td>
            <td>{{ $invoice->corr_num }}</td>
            <td>{{ $invoice->estado_uso }}</td>
            <td>{{ $invoice->num_ambiente }}</td>
            <td>{{ $invoice->responsable }}</td>
        </tr>
    @endforeach
    </tbody>
</table>