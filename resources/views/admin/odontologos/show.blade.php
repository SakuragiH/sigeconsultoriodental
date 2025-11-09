@extends('adminlte::page')

@section('title', 'Detalle del Odontólogo')

@section('content_header')
    <h1><b>Detalle del Odontólogo</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Datos registrados</h3>
            </div>
            <div class="card-body">

                <!-- PRIMERA FILA: NOMBRES, APELLIDOS, EMAIL, TELEFONO -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Nombres</label>
                        <input type="text" class="form-control" value="{{ $odontologo->nombres }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" value="{{ $odontologo->apellidos }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Email</label>
                        <input type="email" class="form-control" value="{{ $odontologo->usuario->email ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" value="{{ $odontologo->telefono ?? '-' }}" disabled>
                    </div>
                </div>

                <!-- SEGUNDA FILA: FORMACION, ESPECIALIDAD, ESTADO, FOTO -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label>Formación</label>
                        <input type="text" class="form-control" value="{{ $odontologo->formacion ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Especialidad</label>
                        <input type="text" class="form-control" value="{{ $odontologo->especialidad ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Estado</label>
                        <input type="text" class="form-control" value="{{ ucfirst($odontologo->estado) ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Foto</label>
                        <div>
                            @if($odontologo->foto)
                                <img src="{{ asset('storage/odontologos/'.$odontologo->foto) }}" 
                                     alt="Foto Odontólogo" 
                                     class="img-thumbnail">
                            @else
                                <span class="text-muted">Sin foto</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- TERCERA FILA: DIRECCIÓN -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label>Dirección</label>
                        <input type="text" class="form-control" value="{{ $odontologo->direccion ?? '-' }}" disabled>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.odontologos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    .img-thumbnail {
        object-fit: cover;
        height: 120px;
        width: 120px;
    }
</style>
@stop

@section('js')
@stop
