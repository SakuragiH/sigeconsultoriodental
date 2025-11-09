<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Servicios</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        .header { text-align:center; margin-bottom:10px; }
        .meta { margin-bottom: 6px; font-size: 11px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:6px; text-align:left; vertical-align: middle; }
        th { background-color:#36808B; color:white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Servicios</h2>
        <div class="meta">Generado por: {{ Auth::user()->name ?? 'Usuario' }} — {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $s)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $s->nombre }}</td>
                    <td>{{ $s->precio ? '$'.number_format($s->precio, 2) : '-' }}</td>
                    <td>{{ $s->descripcion ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
