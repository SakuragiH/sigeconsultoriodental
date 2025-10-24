@extends('adminlte::page')

@section('title', 'Detalle de la Cita')

@section('content_header')
    <h1><b>Detalle de la Cita</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Datos de la cita</h3>
            </div>
            <div class="card-body">

                {{-- PACIENTE --}}
                <h5><b>Paciente</b></h5>
                <div class="row">
                    <div class="col-md-3">
                        <label>Nombres</label>
                        <input type="text" class="form-control" value="{{ $cita->paciente->nombres ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" value="{{ $cita->paciente->apellidos ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Email</label>
                        <input type="text" class="form-control" value="{{ $cita->paciente->usuario->email ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" value="{{ $cita->paciente->telefono ?? '-' }}" disabled>
                    </div>
                </div>

                {{-- ODONTÓLOGO --}}
                <h5 class="mt-3"><b>Odontólogo</b></h5>
                <div class="row">
                    <div class="col-md-3">
                        <label>Nombres</label>
                        <input type="text" class="form-control" value="{{ $cita->odontologo->nombres ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" value="{{ $cita->odontologo->apellidos ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Especialidad</label>
                        <input type="text" class="form-control" value="{{ $cita->odontologo->especialidad ?? '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Teléfono</label>
                        <input type="text" class="form-control" value="{{ $cita->odontologo->telefono ?? '-' }}" disabled>
                    </div>
                </div>

                {{-- SERVICIO --}}
                <h5 class="mt-3"><b>Servicio</b></h5>
                <div class="row">
                    <div class="col-md-6">
                        <label>Nombre del servicio</label>
                        <input type="text" class="form-control" value="{{ $cita->servicio->nombre ?? '-' }}" disabled>
                    </div>
                </div>

                {{-- HORARIO --}}
                <h5 class="mt-3"><b>Horario de la Cita</b></h5>
                <div class="row">
                    <div class="col-md-3">
                        <label>Fecha</label>
                        <input type="text" class="form-control" value="{{ $cita->horario ? \Carbon\Carbon::parse($cita->horario->fecha)->format('d/m/Y') : '-' }}" disabled>
                    </div>
                    <div class="col-md-3">
                        <label>Hora</label>
                        <input type="text" class="form-control" value="{{ $cita->horario ? \Carbon\Carbon::parse($cita->horario->hora_inicio)->format('h:i A') . ' - ' . \Carbon\Carbon::parse($cita->horario->hora_fin)->format('h:i A') : '-' }}" disabled>
                    </div>
                </div>

                {{-- ESTADO --}}
                <h5 class="mt-3"><b>Estado de la cita</b></h5>
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <form action="{{ route('admin.citas.updateStatus', $cita->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="estado" class="form-control" onchange="this.form.submit()">
                                <option value="Pendiente" {{ $cita->estado == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Confirmada" {{ $cita->estado == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="Cancelada" {{ $cita->estado == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </form>
                    </div>
                    <div class="col-md-2">
                        <span class="badge 
                            {{ $cita->estado == 'Confirmada' ? 'badge-success' : ($cita->estado == 'Cancelada' ? 'badge-danger' : 'badge-warning') }}">
                            {{ $cita->estado }}
                        </span>
                    </div>
                </div>

                {{-- MOTIVO Y OBSERVACIONES --}}
                <h5 class="mt-3"><b>Detalles adicionales</b></h5>
                <div class="row">
                    <div class="col-md-6">
                        <label>Motivo</label>
                        <textarea class="form-control" disabled>{{ $cita->motivo ?? '-' }}</textarea>
                    </div>
                    <div class="col-md-6">
                        <label>Observaciones</label>
                        <textarea class="form-control" disabled>{{ $cita->observaciones ?? '-' }}</textarea>
                    </div>
                </div>

                <hr>
                <a href="{{ route('admin.citas.index') }}" class="btn btn-secondary">Volver</a>

            </div>
        </div>
    </div>
</div>
@stop

@section('css')
<style>
    select.form-control {
        width: 200px;
    }
    .badge {
        font-size: 14px;
        padding: 5px 10px;
    }
</style>
@stop

@section('js')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
        timer: 2500,
        showConfirmButton: false
    });
</script>
@endif
@stop
