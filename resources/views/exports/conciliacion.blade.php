<table class="table">
    <thead>
        <tr>
            <th scope="col">Codigo</th>
            <th scope="col">Descripcion</th>
            <th scope="col"> Cod Ubicación</th>
            <th scope="col"> Modelo</th>
            <th scope="col"> Marca</th>
            <th scope="col"> Serie</th>
            <th scope="col"> Medidas</th>
            <th scope="col"> Color</th>
            <th scope="col"> Observaciones</th>
            <th scope="col"> Oficina</th>
            <th scope="col"> Responsable</th>


        </tr>
    </thead>
    <tbody>
        @foreach($data as $item)
        <tr>
            <td>{{ $item->codigo }}</td>
            <td>{{ $item->descripcion }}</td>
            <td>{{ $item->cod_ubicacion }}</td>
            <td>{{ $item->modelo }}</td>
            <td>{{ $item->marca }}</td>
            <td>{{ $item->nro_serie }}</td>

            <td>{{ $item->medidas }}</td>
            <td>{{ $item->color }}</td>
            <td>{{ $item->observaciones }}</td>
            <td>{{ $item->oficina }}</td>
            <td>
                {{ $item->nombres }}
                {{ $item->paterno }}
                {{ $item->materno }}
            </td>

        </tr>
        @endforeach

    </tbody>
</table>