@extends('adminlte::page')

@section('content_header')
    <h1>Editar Medicamento</h1>
@stop

@section('content')
<div class="container">
    <form action="{{ route('admin.medicamentos.update', $medicamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" id="nombre" class="form-control"
                   value="{{ old('nombre', $medicamento->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required>{{ old('descripcion', $medicamento->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="dosis" class="form-label">Dosis</label>
            <input type="text" name="dosis" id="dosis" class="form-control"
                   value="{{ old('dosis', $medicamento->dosis) }}" required>
        </div>

        <div class="mb-3">
            <label for="frecuencia" class="form-label">Frecuencia</label>
            <input type="text" name="frecuencia" id="frecuencia" class="form-control"
                   value="{{ old('frecuencia', $medicamento->frecuencia) }}" required>
        </div>

        <div class="mb-3">
            <label for="via_administracion" class="form-label">Vía de administración</label>
            <input type="text" name="via_administracion" id="via_administracion" class="form-control"
                   value="{{ old('via_administracion', $medicamento->via_administracion) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('admin.medicamentos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@stop

