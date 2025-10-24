@extends('layouts.odontologo')

@section('title', 'Agregar Servicio')
@section('title-section', 'Agregar Servicio')

@section('content')
<div class="container my-4">
    <form action="{{ route('odontologo.servicios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">

            <!-- Nombre -->
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #36808B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Nombre del Servicio</h5>
                        <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required>
                        @error('nombre') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Precio -->
            <div class="col-md-6 col-sm-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #5DA6A6;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Precio (Bs.)</h5>
                        <input type="number" step="0.01" class="form-control" name="precio" value="{{ old('precio') }}">
                        @error('precio') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

        </div>

        <div class="row">

            <!-- Descripción -->
            <div class="col-md-8 col-sm-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #12403B;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Descripción</h5>
                        <textarea class="form-control" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                        @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
            </div>

            <!-- Foto -->
            <div class="col-md-4 col-sm-12 mb-3">
                <div class="card shadow-sm card-hover" style="border-left: 5px solid #1A1D22;">
                    <div class="card-body">
                        <h5 class="card-title field-title">Foto del Servicio</h5>
                        <input type="file" class="form-control" name="foto" accept="image/*" id="fotoInput" required>
                        @error('foto') <small class="text-danger">{{ $message }}</small> @enderror

                        <!-- Previsualización -->
                        <div class="mt-3">
                            <img id="fotoPreview" src="#" alt="Vista previa" style="display:none; width:100%; max-width:250px; height:auto; object-fit:cover; border-radius:5px;">
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-start flex-wrap gap-2 mt-3">
            <button type="submit" class="btn" style="background-color:#36808B; color:#ffffff;">
                <i class="fas fa-save"></i> Guardar Servicio
            </button>
            <a href="{{ route('odontologo.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>

    </form>
</div>

<script>
    document.getElementById('fotoInput').addEventListener('change', function(event){
        const [file] = event.target.files;
        if(file){
            const preview = document.getElementById('fotoPreview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>

<style>
    /* Estilo de títulos de campos */
    .field-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #12403B;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }

    /* Hover cards */
    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    /* Responsivo: se ajusta a móviles */
    @media (max-width: 767px) {
        .card-hover {
            margin-bottom: 15px;
        }
    }
</style>
@endsection
