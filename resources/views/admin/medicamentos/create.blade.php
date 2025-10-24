@extends('adminlte::page')

@section('title', 'Crear Medicamento')

@section('content_header')
    <h1>Crear Medicamento</h1>
    <a href="{{ route('admin.medicamentos.index') }}" class="btn btn-secondary">Volver a la lista</a>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.medicamentos.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" class="form-control" value="{{ old('descripcion') }}" required>
                </div>
                <div class="form-group">
                    <label>Dosis</label>
                    <input type="text" name="dosis" class="form-control" value="{{ old('dosis') }}" required>
                </div>
                <div class="form-group">
                    <label>Frecuencia</label>
                    <input type="text" name="frecuencia" class="form-control" value="{{ old('frecuencia') }}" required>
                </div>
                <div class="form-group">
                    <label>Vía de Administración</label>
                    <input type="text" name="via_administracion" class="form-control" value="{{ old('via_administracion') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Guardar Medicamento</button>
            </form>
        </div>
    </div>
@stop
