@extends('layouts.odontologo')

@section('title', 'Agregar Formación')

@section('content')
<div class="page-title">
    <h2>Subir nueva formación</h2>
</div>

<div class="form-container">
    <form action="{{ route('odontologo.formaciones.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="archivo">Archivo (PDF, imagen, etc)</label>
            <input type="file" name="archivo" id="archivo" accept=".jpg,.jpeg,.png,.gif,.pdf" required>
            @error('archivo')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Preview opcional de imagen -->
        <div class="form-group" id="preview-container" style="display:none; margin-bottom:15px;">
            <p>Vista previa de la imagen:</p>
            <img id="preview-img" src="#" alt="Preview" style="max-width:300px; border-radius:5px;">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción / Título</label>
            <input type="text" name="descripcion" id="descripcion" value="{{ old('descripcion') }}">
            @error('descripcion')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-submit"><i class="fas fa-upload"></i> Subir</button>
    </form>
</div>
@endsection

@section('js')
<script>
    const archivoInput = document.getElementById('archivo');
    const previewContainer = document.getElementById('preview-container');
    const previewImg = document.getElementById('preview-img');

    archivoInput.addEventListener('change', function() {
        const file = this.files[0];
        if(file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endsection
