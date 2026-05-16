<h2>Historial de Movimientos</h2>

<table border="1" width="100%" cellpadding="5" cellspacing="0">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Tipo</th>
            <th>Monto</th>
            <th>Categoría</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($movimientos as $m)
        <tr>
            <td>{{ $m->fecha }}</td>
            <td>{{ ucfirst($m->tipo) }}</td>
            <td>${{ number_format($m->monto, 2) }}</td>
            <td>
                {{ $m->categoria->nombre ?? '' }}
                -
                {{ $m->subcategoria->nombre ?? '' }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
