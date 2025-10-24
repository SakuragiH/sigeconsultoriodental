@extends('layouts.odontologo')

@section('title', 'Nuevo Paciente')
@section('title-section', 'Registrar Paciente')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.pacientes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <!-- Nombres -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Nombres</h5>
                        <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" required>
                        @error('nombres') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Apellidos -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Apellidos</h5>
                        <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" required>
                        @error('apellidos') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- C.I. -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">C.I.</h5>
                        <input type="text" name="ci" class="form-control" value="{{ old('ci') }}" required>
                        @error('ci') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Teléfono -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #1A1D22;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Teléfono</h5>
                        <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" required>
                        @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Fecha de Nacimiento -->
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Fecha de Nacimiento</h5>
                        <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
                        @error('fecha_nacimiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Género -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Género</h5>
                        <select name="genero" class="form-control" required>
                            <option value="">Seleccione género...</option>
                            <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                            <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                            <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
                        </select>
                        @error('genero') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Dirección -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Dirección</h5>
                        <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" required>
                        @error('direccion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="col-md-6 mb-3">
                <div class="card shadow-sm card-hover" style="border-left:5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Foto</h5>
                        <input type="file" name="foto" accept="image/*" onchange="previewFoto(event)">
                        <div style="margin-top:10px;">
                            <img id="foto-preview" src="{{ asset('img/default-avatar.png') }}" 
                                 alt="" 
                                 style="max-width:200px; border-radius:8px; border:1px solid #ddd;">
                        </div>
                        @error('foto') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn" style="background-color:#36808B; color:#fff;">
                Guardar Paciente
            </button>
            <a href="{{ route('odontologo.pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

<script>
function previewFoto(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('foto-preview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
