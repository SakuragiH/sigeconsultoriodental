<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Medicamentos</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
        .header { text-align:center; margin-bottom:10px; }
        .meta { margin-bottom: 6px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:6px; text-align:left; vertical-align: middle; }
        th { background-color:#36808B; color:white; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Reporte de Medicamentos</h2>
        <div class="meta">
            Generado por: {{ Auth::user()->name ?? 'Usuario' }} — {{ now()->format('Y-m-d H:i') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Dosis</th>
                <th>Frecuencia</th>
                <th>Vía de administración</th>
            </tr>
        </thead>
        <tbody>
            @foreach($medicamentos as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->nombre }}</td>
                    <td>{{ $m->descripcion ?? '-' }}</td>
                    <td>{{ $m->dosis ?? '-' }}</td>
                    <td>{{ $m->frecuencia ?? '-' }}</td>
                    <td>{{ $m->via_administracion ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
