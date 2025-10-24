@extends('adminlte::page')

@section('title', 'Registrar Cita')

@section('content_header')
    <h1><b>Citas / Registrar nueva cita</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Complete los datos</h3>
      </div>
      <div class="card-body">

        {{-- FILTRO ODONTÓLOGO --}}
        <form method="GET">
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <label>Odontólogo <b>(*)</b></label>
                <select name="odontologo_id" class="form-control" onchange="this.form.submit();" required>
                  <option value="">Seleccione un odontólogo...</option>
                  @foreach($odontologos as $o)
                    <option value="{{ $o->id }}" {{ ($odontologoSeleccionado == $o->id) ? 'selected' : '' }}>
                      {{ $o->nombres }} {{ $o->apellidos }}
                    </option>
                  @endforeach
                </select>
                <small class="text-muted">Seleccione el odontólogo para ver horarios disponibles.</small>
              </div>
            </div>
          </div>
        </form>

        {{-- FORMULARIO PRINCIPAL --}}
        <form action="{{ route('admin.citas.store') }}" method="POST">
          @csrf

          <input type="hidden" name="odontologo_id" value="{{ $odontologoSeleccionado }}">

          <div class="row">
            {{-- PACIENTE --}}
            <div class="col-md-4">
              <div class="form-group">
                <label>Paciente <b>(*)</b></label>
                <select name="paciente_id" class="form-control" required>
                  <option value="">Seleccione...</option>
                  @foreach($pacientes as $p)
                    <option value="{{ $p->id }}" {{ old('paciente_id')==$p->id?'selected':'' }}>
                      {{ $p->nombres }} {{ $p->apellidos }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>

            {{-- SERVICIO --}}
            <div class="col-md-4">
              <div class="form-group">
                <label>Servicio <b>(*)</b></label>
                <select name="servicio_id" class="form-control" required>
                  <option value="">Seleccione...</option>
                  @foreach($servicios as $s)
                    <option value="{{ $s->id }}" {{ old('servicio_id')==$s->id?'selected':'' }}>
                      {{ $s->nombre }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>

          {{-- HORARIOS DISPONIBLES --}}
          @if($odontologoSeleccionado)
          <div class="row mt-2">
            <div class="col-md-6">
              <div class="form-group">
                <label>Horario disponible <b>(*)</b></label>
                <select name="horario_id" class="form-control" required>
                  <option value="">Seleccione...</option>
                  @foreach($horarios as $h)
                    <option value="{{ $h->id }}" {{ old('horario_id')==$h->id?'selected':'' }}>
                      {{ \Carbon\Carbon::parse($h->fecha)->format('d/m/Y') }} - {{ $h->hora_inicio }} a {{ $h->hora_fin }}
                    </option>
                  @endforeach
                </select>
                @if($horarios->isEmpty())
                  <small class="text-danger">No hay horarios disponibles para este odontólogo.</small>
                @endif
              </div>
            </div>
          </div>
          @endif

          {{-- MOTIVO Y OBSERVACIONES --}}
          <div class="row mt-2">
            <div class="col-md-6">
              <div class="form-group">
                <label>Motivo</label>
                <textarea name="motivo" class="form-control">{{ old('motivo') }}</textarea>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label>Observaciones</label>
                <textarea name="observaciones" class="form-control">{{ old('observaciones') }}</textarea>
              </div>
            </div>
          </div>

          <hr>
          <button type="submit" class="btn btn-primary">Registrar</button>
          <a href="{{ route('admin.citas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>

      </div>
    </div>
  </div>
</div>
@stop
