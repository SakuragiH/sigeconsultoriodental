<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Médico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0 30px;
        }

        header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #36808B;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        header img {
            height: 60px;
        }

        header h1 {
            flex: 1;
            text-align: center;
            color: #12403B;
            font-size: 24px;
            margin: 0;
            letter-spacing: 1px;
        }

        section {
            margin-bottom: 20px;
        }

        section h2 {
            background-color: #5DA6A6;
            color: #fff;
            padding: 6px 10px;
            font-size: 14px;
            margin-bottom: 8px;
        }

        section p {
            margin: 4px 0;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #12403B;
            padding-top: 5px;
        }

        .archivo {
            margin-top: 10px;
            padding: 8px;
            border: 1px dashed #36808B;
            background-color: #f2f9fa;
            text-align: center;
        }

        .archivo img {
            max-width: 100%;
            border: 1px solid #36808B;
            border-radius: 5px;
            margin-top: 5px;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <img src="{{ public_path('img/logo.png') }}" alt="Logo">
    <h1>Historial Médico</h1>
</header>

<section>
    <h2>Cita</h2>
    @if($historial->cita)
        <p><span class="bold">Paciente:</span> {{ $historial->cita->paciente->nombreCompleto() }}</p>
        <p><span class="bold">Servicio:</span> {{ $historial->cita->servicio->nombre ?? 'N/A' }}</p>
        <p><span class="bold">Fecha:</span> {{ \Carbon\Carbon::parse($historial->cita->horario->fecha)->format('d/m/Y') }}</p>
        <p><span class="bold">Hora:</span> {{ \Carbon\Carbon::parse($historial->cita->horario->hora_inicio)->format('H:i') }}</p>
        <p><span class="bold">Motivo:</span> {{ $historial->cita->motivo ?? 'Sin motivo' }}</p>
    @else
        <p>Sin cita asociada</p>
    @endif
</section>

<section>
    <h2>Diagnóstico</h2>
    <p>{{ $historial->diagnostico }}</p>
</section>

<section>
    <h2>Tratamiento</h2>
    <p>{{ $historial->tratamiento ?? 'N/A' }}</p>
</section>

<section>
    <h2>Observaciones del Paciente</h2>
    <p>{{ $historial->observaciones_paciente ?? 'N/A' }}</p>
</section>

@if($historial->archivo_path)
<section>
    <h2>Archivo Adjunto</h2>
    <div class="archivo">
        @php
            $ext = pathinfo($historial->archivo_nombre_original, PATHINFO_EXTENSION);
        @endphp
        @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
            <img src="{{ public_path('storage/'.$historial->archivo_path) }}" alt="Archivo Adjunto">
        @else
            {{ $historial->archivo_nombre_original ?? 'Archivo' }}
        @endif
    </div>
</section>
@endif

<footer>
    Consultorio Dental Alcala's Dent | Dirección: Calle Ficticia 123 | Tel: +591 70000000 | Email: contacto@alcala-dent.com
</footer>

</body>
</html>
