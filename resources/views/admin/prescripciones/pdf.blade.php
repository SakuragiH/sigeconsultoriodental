<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Prescripción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .logo {
            width: 120px;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        .datos {
            margin-top: 20px;
        }
        .datos p {
            margin: 5px 0;
        }
        .medicamento-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .medicamento-table th, .medicamento-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
        }
        .footer img {
            width: 200px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <p><strong>Consultorio Dental</strong></p>
            <p>Dirección: Calle Ficticia 123</p>
            <p>Tel: 12345678</p>
        </div>
        <div>
            <img src="{{ public_path('images/logo_consultorio.png') }}" class="logo" alt="Logo">
        </div>
    </div>

    <h2>Prescripción Médica</h2>

    <div class="datos">
        <p><strong>Paciente:</strong> {{ $prescripcion->historial->paciente->nombres ?? '-' }} {{ $prescripcion->historial->paciente->apellidos ?? '-' }}</p>
        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($prescripcion->created_at)->format('d/m/Y') }}</p>
        <p><strong>Diagnóstico:</strong> {{ $prescripcion->historial->diagnostico ?? '-' }}</p>
    </div>

    <table class="medicamento-table">
        <thead>
            <tr>
                <th>Medicamento</th>
                <th>Dosis</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $prescripcion->medicamento->nombre ?? '-' }}</td>
                <td>{{ $prescripcion->dosis }}</td>
                <td>{{ $prescripcion->observaciones ?? '-' }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <img src="{{ public_path('images/sello.png') }}" alt="Sello/Firma">
        <p>Dr(a). Nombre del Odontólogo</p>
    </div>
</body>
</html>
