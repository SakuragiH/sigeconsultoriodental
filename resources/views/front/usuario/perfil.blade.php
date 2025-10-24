@extends('layouts.usuario')

@section('title','Mi Perfil')

@section('content')
<div class="header">
    <h1>Bienvenido, {{ Auth::user()->name }}</h1>
    <p>Actualiza tus datos personales</p>
</div>

<div class="card">
    <div class="card-header">Mi Perfil</div>
    <form action="{{ route('usuario.perfil.update') }}" method="POST">
        @csrf
        <label>Nombre</label>
        <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control">

        <label>Email</label>
        <input type="email" name="email" value="{{ Auth::user()->email }}" class="form-control">

        <label>Teléfono</label>
        <input type="text" name="telefono" value="{{ Auth::user()->telefono ?? '' }}" class="form-control">

        <label>Dirección</label>
        <input type="text" name="direccion" value="{{ Auth::user()->direccion ?? '' }}" class="form-control">

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Actualizar Perfil</button>
    </form>
</div>
@endsection
