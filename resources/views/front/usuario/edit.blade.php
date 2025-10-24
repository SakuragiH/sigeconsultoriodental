@extends('layouts.usuario')

@section('title', 'Editar Perfil')
@section('title-section', 'Tu Información')

@section('content')
<div class="container my-4">
    <form action="{{ route('usuario.perfil.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <!-- Foto de Perfil -->
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body text-center">
                        <h5 class="card-title field-title">Foto de Perfil</h5>
                        @if($user->paciente && $user->paciente->foto)
                            <img src="{{ asset('storage/pacientes/' . $user->paciente->foto) }}" 
                                alt="Foto de {{ $user->name }}" 
                                class="profile-img mb-2" 
                                style="width:180px; height:180px; object-fit:cover; border-radius:50%; border:4px solid #36808B;">
                        @else
                            <img src="{{ asset('storage/pacientes/usuariopordefecto.png') }}" 
                                alt="Foto por defecto" 
                                class="profile-img mb-2" 
                                style="width:180px; height:180px; object-fit:cover; border-radius:50%; border:4px solid #36808B;">
                        @endif
                        <input type="file" name="foto" id="foto" class="form-control mt-2">
                    </div>
                </div>
            </div>

            <!-- Nombres -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Nombres</h5>
                        <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $user->paciente->nombres ?? $user->name) }}" required>
                        @error('nombres') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Apellidos -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Apellidos</h5>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $user->paciente->apellidos ?? '') }}" required>
                        @error('apellidos') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- CI -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Cédula de Identidad (CI)</h5>
                        <input type="text" name="ci" class="form-control" value="{{ old('ci', $user->paciente->ci ?? '') }}" required>
                        @error('ci') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #1A1D22;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Fecha de Nacimiento</h5>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $user->paciente->fecha_nacimiento ?? '') }}" required>
                        @error('fecha_nacimiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Teléfono -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Teléfono</h5>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $user->paciente->telefono ?? '') }}" required>
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Dirección -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Dirección</h5>
                        <textarea name="direccion" class="form-control" rows="3" required>{{ old('direccion', $user->paciente->direccion ?? '') }}</textarea>
                        @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Género -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Género</h5>
                        <select name="genero" class="form-control" required>
                            <option value="">Seleccione...</option>
                            @foreach(['Masculino', 'Femenino', 'Otro'] as $genero)
                                <option value="{{ $genero }}" {{ (old('genero', $user->paciente->genero ?? '') == $genero) ? 'selected' : '' }}>{{ $genero }}</option>
                            @endforeach
                        </select>
                        @error('genero') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<style>
    /* Estilo de títulos de campos */
    .field-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #12403B;
        margin-bottom: 10px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Hover cards */
    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Botones */
    .btn-primary {
        background-color: #36808B;
        color: #fff;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background-color: #12403B;
        transform: translateY(-2px);
    }

    .btn-secondary {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 600;
        transition: 0.3s;
    }
    .btn-secondary:hover {
        background-color: #e0e0e0;
    }
</style>
@endsection
