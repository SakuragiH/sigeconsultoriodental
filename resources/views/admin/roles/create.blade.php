@extends('adminlte::page')

@section('title', 'Crear Rol')

@section('content_header')
    <h1>Crear Rol</h1>
    <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Volver a la lista</a>
@stop

@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.roles.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre del Rol</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>

                <button type="submit" class="btn btn-success">Crear Rol</button>
            </form>
        </div>
    </div>
@stop


