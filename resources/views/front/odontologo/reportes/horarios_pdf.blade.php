<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Horarios</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        .header { text-align:center; margin-bottom:10px; }
        .meta { margin-bottom: 6px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:6px; text-align:left; }
        th { background-color:#36808B; color:white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Horarios</h2>
        <div class="meta">Generado por: {{ Auth::user()->name ?? 'Usuario' }} — {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Día</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($horarios as $h)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $h->dia }}</td>
                    <td>{{ $h->fecha ? \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') : '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($h->hora_inicio)->format('H:i') }} - {{ \Carbon\Carbon::parse($h->hora_fin)->format('H:i') }}</td>
                    <td>{{ $h->disponible ? 'Disponible' : 'Bloqueado' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
