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
            <input type="file" name="archivo" id="archivo" required>
            @error('archivo')
                <span class="error">{{ $message }}</span>
            @enderror
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
