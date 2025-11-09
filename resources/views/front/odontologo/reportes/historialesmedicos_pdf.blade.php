<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Historial Médico</title>
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
        <h2>Reporte de Historial Médico</h2>
        <div class="meta">Generado por: {{ Auth::user()->name ?? 'Usuario' }} — {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Paciente</th>
                <th>Diagnóstico</th>
                <th>Tratamiento</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($historiales as $h)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $h->paciente->nombres }} {{ $h->paciente->apellidos }}</td>
                    <td>{{ $h->diagnostico }}</td>
                    <td>{{ $h->tratamiento ?? '-' }}</td>
                    <td>{{ $h->observaciones_paciente ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
