<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Movimientos - MoneyTrack</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; padding: 20px; }
        h2 { color: #0f172a; border-bottom: 2px solid #d97706; padding-bottom: 8px; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #0f172a; color: white; padding: 10px 8px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px; border-bottom: 1px solid #e5e7eb; }
        tr:nth-child(even) { background: #f8fafc; }
        .ingreso { color: #059669; font-weight: bold; }
        .egreso { color: #dc2626; font-weight: bold; }
        .footer { margin-top: 20px; text-align: center; color: #9ca3af; font-size: 10px; }
    </style>
</head>
<body>
    <h2>Historial de Movimientos</h2>

    <table>
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
                <td>{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                <td class="{{ $m->tipo }}">{{ ucfirst($m->tipo) }}</td>
                <td class="{{ $m->tipo }}">${{ number_format($m->monto, 2) }}</td>
                <td>
                    {{ $m->categoria->nombre ?? '' }}
                    @if ($m->subcategoria->nombre ?? false)
                        / {{ $m->subcategoria->nombre }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        MoneyTrack - Generado el {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
