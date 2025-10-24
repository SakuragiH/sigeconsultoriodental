@extends('layouts.odontologo')

@section('title', 'Ver Servicio')
@section('title-section', 'Detalle del Servicio')

@section('content')
<div class="container my-4">
    <div class="row">

        <!-- Nombre -->
        <div class="col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm" style="border-left: 5px solid #36808B;">
                <div class="card-body">
                    <h5 class="card-title field-title">Nombre del Servicio</h5>
                    <p class="card-text">{{ $servicio->nombre }}</p>
                </div>
            </div>
        </div>

        <!-- Precio -->
        <div class="col-md-6 col-sm-12 mb-3">
            <div class="card shadow-sm" style="border-left: 5px solid #5DA6A6;">
                <div class="card-body">
                    <h5 class="card-title field-title">Precio (Bs.)</h5>
                    <p class="card-text">{{ number_format($servicio->precio, 2) }}</p>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <!-- Descripción -->
        <div class="col-md-8 col-sm-12 mb-3">
            <div class="card shadow-sm" style="border-left: 5px solid #12403B;">
                <div class="card-body">
                    <h5 class="card-title field-title">Descripción</h5>
                    <p class="card-text">{{ $servicio->descripcion }}</p>
                </div>
            </div>
        </div>

        <!-- Foto -->
        <div class="col-md-4 col-sm-12 mb-3">
            <div class="card shadow-sm" style="border-left: 5px solid #1A1D22;">
                <div class="card-body text-center">
                    <h5 class="card-title field-title">Foto del Servicio</h5>
                    <img 
                        src="{{ $servicio->foto ? url($servicio->foto) : url('storage/servicios/default.png') }}" 
                        alt="{{ $servicio->nombre }}" 
                        style="max-width:100%; border-radius:5px; height:auto;"
                    >
                </div>
            </div>
        </div>

    </div>

    <!-- Botón regresar -->
    <div class="mt-3">
        <a href="{{ route('odontologo.servicios.index') }}" 
           class="btn" 
           style="background-color:#1A1D22; color:#ffffff;">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

</div>

<style>
    .field-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #12403B;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    /* Cards uniformes */
    .card {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    @media (max-width: 767px) {
        .card {
            margin-bottom: 15px;
        }
    }
</style>
@endsection
