<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Movimientos</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        h1 { text-align: center; color: #0f172a; font-size: 20px; margin-bottom: 4px; }
        .sub { text-align: center; color: #64748b; font-size: 13px; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background: #0f172a; color: white; padding: 8px 10px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 6px 10px; border-bottom: 1px solid #e2e8f0; }
        .ingreso { color: #059669; font-weight: bold; }
        .egreso { color: #dc2626; font-weight: bold; }
        .resumen { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .resumen div { text-align: center; flex: 1; }
        .resumen .label { font-size: 11px; color: #64748b; }
        .resumen .value { font-size: 16px; font-weight: bold; }
        .footer { text-align: center; color: #94a3b8; font-size: 10px; margin-top: 30px; }
    </style>
</head>
<body>
    <h1>MoneyTrack</h1>
    <p class="sub">Reporte de Movimientos - Generado el {{ now()->format('d/m/Y H:i') }}</p>

    <div class="resumen">
        <div>
            <div class="label">Total Ingresos</div>
            <div class="value" style="color:#059669">${{ number_format($totalIngresos, 2, ',', '.') }}</div>
        </div>
        <div>
            <div class="label">Total Egresos</div>
            <div class="value" style="color:#dc2626">${{ number_format($totalEgresos, 2, ',', '.') }}</div>
        </div>
        <div>
            <div class="label">Saldo</div>
            <div class="value" style="color:{{ $saldo >= 0 ? '#059669' : '#dc2626' }}">${{ number_format($saldo, 2, ',', '.') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Categoría</th>
                <th>Subcategoría</th>
                <th align="right">Monto</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movimientos as $m)
            <tr>
                <td>{{ \Carbon\Carbon::parse($m->fecha)->format('d/m/Y') }}</td>
                <td class="{{ $m->tipo }}">{{ ucfirst($m->tipo) }}</td>
                <td>{{ $m->categoria->nombre ?? '-' }}</td>
                <td>{{ $m->subcategoria->nombre ?? '-' }}</td>
                <td align="right" class="{{ $m->tipo }}">${{ number_format($m->monto, 2, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="5" align="center">No hay movimientos registrados</td></tr>
            @endforelse
        </tbody>
    </table>

    <p class="footer">Grupo 7 TUP- UTN FRRe &mdash; MoneyTrack</p>
</body>
</html>
