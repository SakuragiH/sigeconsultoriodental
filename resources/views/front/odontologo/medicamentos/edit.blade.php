@extends('layouts.odontologo')

@section('title', 'Editar Medicamento')
@section('title-section', 'Editar Medicamento')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.medicamentos.update', $medicamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">

            <!-- Nombre -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Nombre del Medicamento</h5>
                        <input type="text" name="nombre" class="form-control" 
                               value="{{ old('nombre', $medicamento->nombre) }}" required>
                        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Descripción -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Descripción</h5>
                        <textarea name="descripcion" class="form-control" rows="3" required>{{ old('descripcion', $medicamento->descripcion) }}</textarea>
                        @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Dosis -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Dosis</h5>
                        <input type="text" name="dosis" class="form-control" 
                               value="{{ old('dosis', $medicamento->dosis) }}" required>
                        @error('dosis') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Frecuencia -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Frecuencia</h5>
                        <input type="text" name="frecuencia" class="form-control" 
                               value="{{ old('frecuencia', $medicamento->frecuencia) }}" required>
                        @error('frecuencia') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Vía de administración -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Vía de Administración</h5>
                        <input type="text" name="via_administracion" class="form-control" 
                               value="{{ old('via_administracion', $medicamento->via_administracion) }}" required>
                        @error('via_administracion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn" style="background-color:#36808B; color:#ffffff;">
                <i class="fas fa-save"></i> Actualizar Medicamento
            </button>
            <a href="{{ route('odontologo.medicamentos.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>

    </form>
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

    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    @media (max-width: 767px) {
        .card-hover {
            margin-bottom: 15px;
        }
    }
</style>
@endsection
