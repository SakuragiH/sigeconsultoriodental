<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prescripción #{{ $prescripcion->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; line-height: 1.5; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; color: #12403B; }
        .header p { margin: 0; font-size: 14px; }
        .section { margin-bottom: 15px; }
        .section h3 { margin-bottom: 5px; color: #12403B; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 8px; text-align: left; }
        .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Consultorio Dental Alcalas</h1>
        <p>Prescripción Médica</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($prescripcion->created_at)->format('d/m/Y') }}</p>
    </div>

    <div class="section">
        <h3>Paciente</h3>
        <p>{{ $prescripcion->historial->paciente->nombres ?? '' }} {{ $prescripcion->historial->paciente->apellidos ?? '' }}</p>
        <p>CI: {{ $prescripcion->historial->paciente->ci ?? '' }}</p>
    </div>

    <div class="section">
        <h3>Medicamento</h3>
        <table>
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Dosis</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $prescripcion->medicamento->nombre }}</td>
                    <td>{{ $prescripcion->dosis }}</td>}
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Observaciones</h3>
        <p>{{ $prescripcion->observaciones ?? 'Ninguna' }}</p>
    </div>

    <div class="footer">
        <p>Documento generado automáticamente por el sistema de Consultorio Dental Alcalas</p>
    </div>
</body>
</html>
