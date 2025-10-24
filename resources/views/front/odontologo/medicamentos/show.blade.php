@extends('layouts.odontologo')

@section('title', 'Detalle del Medicamento')

@section('content')
<div class="container">
    <h2 class="mb-4">Detalle del Medicamento</h2>

    <div class="row g-4">

        <!-- Nombre -->
        <div class="col-md-6">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Nombre</h5>
                </div>
                <div class="card-body">
                    <p>{{ $medicamento->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Descripción -->
        <div class="col-md-6">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Descripción</h5>
                </div>
                <div class="card-body">
                    <p>{{ $medicamento->descripcion }}</p>
                </div>
            </div>
        </div>

        <!-- Dosis -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #12403B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#12403B;">Dosis</h5>
                </div>
                <div class="card-body">
                    <p>{{ $medicamento->dosis }}</p>
                </div>
            </div>
        </div>

        <!-- Frecuencia -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #36808B;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#36808B;">Frecuencia</h5>
                </div>
                <div class="card-body">
                    <p>{{ $medicamento->frecuencia }}</p>
                </div>
            </div>
        </div>

        <!-- Vía de Administración -->
        <div class="col-md-4">
            <div class="card shadow-sm card-hover" style="border-top: 4px solid #5DA6A6;">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0" style="color:#5DA6A6;">Vía de Administración</h5>
                </div>
                <div class="card-body">
                    <p>{{ $medicamento->via_administracion }}</p>
                </div>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="col-md-12 mt-3">
            <a href="{{ route('odontologo.medicamentos.index') }}" class="btn btn-secondary">
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
