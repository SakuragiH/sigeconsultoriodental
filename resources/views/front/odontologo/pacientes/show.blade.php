@extends('layouts.odontologo')

@section('title', 'Detalle del Paciente')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle del Paciente</h2>

    <div class="row g-4">

        <!-- Foto -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Foto</h5>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/pacientes/'.$paciente->foto) }}" 
                         alt="Foto del Paciente" 
                         style="max-width:200px; border-radius:8px; border:1px solid #ddd;">
                </div>
            </div>
        </div>

        <!-- Nombres -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Nombres</h5>
                </div>
                <div class="card-body">
                    <p>{{ $paciente->nombres }}</p>
                </div>
            </div>
        </div>

        <!-- Apellidos -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #12403B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#12403B;">Apellidos</h5>
                </div>
                <div class="card-body">
                    <p>{{ $paciente->apellidos }}</p>
                </div>
            </div>
        </div>

        <!-- C.I. -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">C.I.</h5>
                </div>
                <div class="card-body">
                    <p>{{ $paciente->ci }}</p>
                </div>
            </div>
        </div>

        <!-- Teléfono -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Teléfono</h5>
                </div>
                <div class="card-body">
                    <p>{{ $paciente->telefono }}</p>
                </div>
            </div>
        </div>

        <!-- Fecha de Nacimiento -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #12403B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#12403B;">Fecha de Nacimiento</h5>
                </div>
                <div class="card-body">
                    <p><strong>Fecha de Nacimiento:</strong> {{ \Carbon\Carbon::parse($paciente->fecha_nacimiento)->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Género -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Género</h5>
                </div>
                <div class="card-body">
                    <p>{{ $paciente->genero }}</p>
                </div>
            </div>
        </div>

        <!-- Dirección -->
        <div class="col-md-8">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Dirección</h5>
                </div>
                <div class="card-body">
                    <p>{{ $paciente->direccion }}</p>
                </div>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="col-md-12 mt-3">
            <a href="{{ route('odontologo.pacientes.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
</div>

<style>
    /* Hover para las cards */
    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Responsivo */
    @media (max-width: 767px) {
        .card-hover {
            margin-bottom: 15px;
        }
    }
</style>
@endsection
