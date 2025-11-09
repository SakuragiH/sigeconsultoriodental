<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Citas</title>
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
        <h2>Reporte de Citas</h2>
        <div class="meta">Generado por: {{ Auth::user()->name ?? 'Usuario' }} — {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Paciente</th>
                <th>Servicio</th>
                <th>Fecha</th>
                <th>Horario</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($citas as $cita)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cita->paciente->nombres ?? '-' }} {{ $cita->paciente->apellidos ?? '' }}</td>
                    <td>{{ $cita->servicio->nombre ?? '-' }}</td>
                    <td>{{ $cita->horario->fecha ? \Carbon\Carbon::parse($cita->horario->fecha)->format('d/m/Y') : '-' }}</td>
                    <td>{{ $cita->horario->hora_inicio ?? '-' }} - {{ $cita->horario->hora_fin ?? '-' }}</td>
                    <td>{{ $cita->estado ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
