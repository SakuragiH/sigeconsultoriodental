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
                <div class="row">
                    <!-- NOMBRES -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombres">Nombres</label>
                            <input type="text" class="form-control" value="{{ $odontologo->nombres }}" disabled>
                        </div>
                    </div>

                    <!-- APELLIDOS -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" value="{{ $odontologo->apellidos }}" disabled>
                        </div>
                    </div>

                    <!-- EMAIL -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" value="{{ $odontologo->usuario->email ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- TELEFONO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" value="{{ $odontologo->telefono ?? '-' }}" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- FORMACION -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="formacion">Formación</label>
                            <input type="text" class="form-control" value="{{ $odontologo->formacion ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- ESPECIALIDAD -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" class="form-control" value="{{ $odontologo->especialidad ?? '-' }}" disabled>
                        </div>
                    </div>

                    <!-- ESTADO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" value="{{ ucfirst($odontologo->estado) }}" disabled>
                        </div>
                    </div>

                    <!-- FOTO -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="foto">Foto</label>
                            <div>
                                @if($odontologo->foto)
                                    <img src="{{ url($odontologo->foto) }}" alt="Foto Odontólogo" width="120" class="img-thumbnail">
                                @else
                                    <span class="text-muted">Sin foto</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- DIRECCION -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" value="{{ $odontologo->direccion ?? '-' }}" disabled>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-12">
                        <a href="{{ route('admin.odontologos.index') }}" class="btn btn-secondary">Volver</a>
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


