<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.5;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #2a3f54;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .logo {
            width: 120px;
        }

        .title {
            text-align: center;
            flex-grow: 1;
            font-size: 24px;
            font-weight: bold;
            color: #2a3f54;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #f9f9f9;
        }

        .label {
            font-weight: bold;
            color: #555;
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 30px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <img src="{{ public_path('img/logo.png') }}" class="logo" alt="Logo">
        <div class="title">Historial Médico</div>
        <div style="width: 120px;"></div> <!-- Espacio para balancear el logo -->
    </div>

    <div class="card">
        <p class="label">Paciente:</p>
        <p>{{ $historial->paciente->nombres }} {{ $historial->paciente->apellidos }}</p>
    </div>

    @if($historial->cita)
    <div class="card">
        <p class="label">Cita:</p>
        <p>
            {{ \Carbon\Carbon::parse($historial->cita->horario->fecha)->format('d/m/Y') }} 
            ({{ $historial->cita->horario->hora_inicio }} - {{ $historial->cita->horario->hora_fin }}) - 
            Dr(a). {{ $historial->cita->odontologo->nombres }} {{ $historial->cita->odontologo->apellidos }}
        </p>
    </div>
    @endif

    <div class="card">
        <p class="label">Diagnóstico:</p>
        <p>{{ $historial->diagnostico }}</p>
    </div>

    <div class="card">
        <p class="label">Tratamiento:</p>
        <p>{{ $historial->tratamiento ?? '-' }}</p>
    </div>

    <div class="card">
        <p class="label">Observaciones del paciente:</p>
        <p>{{ $historial->observaciones_paciente ?? '-' }}</p>
    </div>

    <div class="footer">
        Consultorio Dental "Alcala's Dent" • Dirección: Av.Siempre Viva • Teléfono: 62628580 • Email: Apa@gmail.com
    </div>

</body>
</html>
