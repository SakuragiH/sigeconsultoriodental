<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Pacientes</title>
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
        <h2>Reporte de Pacientes</h2>
        <div class="meta">Generado por: {{ Auth::user()->name ?? 'Usuario' }} — {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Apellido</th>
                <th>Nombre</th>
                <th>CI</th>
                <th>Teléfono</th>
                <th>Fecha Nacimiento</th>
                <th>Registrado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pacientes as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td> <!-- Nro de fila --> <!-- Nro de fila -->
                    <td>{{ $p->apellidos }}</td>
                    <td>{{ $p->nombres }}</td>
                    <td>{{ $p->ci ?? '-' }}</td>
                    <td>{{ $p->telefono ?? '-' }}</td>
                    <td>{{ $p->fecha_nacimiento ? \Carbon\Carbon::parse($p->fecha_nacimiento)->format('d/m/Y') : '-' }}</td>
                    <td>{{ optional($p->created_at)->format('Y-m-d') ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
