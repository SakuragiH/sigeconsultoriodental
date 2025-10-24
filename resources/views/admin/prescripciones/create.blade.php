@extends('adminlte::page')

@section('content_header')
    <h1><b>Prescripciones / Registro de nueva prescripción</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.prescripciones.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <!-- Historial Médico -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="historial_id">Historial Médico</label><b> (*)</b>
                                <select name="historial_id" class="form-control" required>
                                    <option value="">Seleccione un historial...</option>
                                    @foreach($historiales as $historial)
                                        <option value="{{ $historial->id }}"
                                            {{ old('historial_id') == $historial->id ? 'selected' : '' }}>
                                            {{ $historial->paciente->nombres ?? '-' }} {{ $historial->paciente->apellidos ?? '-' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('historial_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Medicamento -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="medicamento_id">Medicamento</label><b> (*)</b>
                                <select name="medicamento_id" class="form-control" required>
                                    <option value="">Seleccione un medicamento...</option>
                                    @foreach($medicamentos as $medicamento)
                                        <option value="{{ $medicamento->id }}"
                                            {{ old('medicamento_id') == $medicamento->id ? 'selected' : '' }}>
                                            {{ $medicamento->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('medicamento_id')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Dosis -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dosis">Dosis</label><b> (*)</b>
                                <input type="text" name="dosis" class="form-control" value="{{ old('dosis') }}" placeholder="Ingrese dosis..." required>
                                @error('dosis')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="observaciones">Observaciones</label>
                                <input type="text" name="observaciones" class="form-control" value="{{ old('observaciones') }}" placeholder="Ingrese observaciones...">
                                @error('observaciones')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ route('admin.prescripciones.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@stop
