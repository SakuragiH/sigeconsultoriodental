{{-- resources/views/front/usuario/citas/create.blade.php --}}
@extends('layouts.usuario')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Rellene todos los datos</h1>

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('usuario.citas.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Datos del Paciente --}}
        <div class="card shadow-sm card-hover mb-4 p-4" style="border-left: 5px solid #36808B;">
            <h3 class="field-title mb-3">Datos del Paciente</h3>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nombres" class="form-label">Nombres</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" value="{{ old('nombres', $user->paciente->nombres ?? $user->name) }}" required>
                </div>
                <div class="col-md-6">
                    <label for="apellidos" class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ old('apellidos', $user->paciente->apellidos ?? '') }}" required>
                </div>

                <div class="col-md-4">
                    <label for="ci" class="form-label">C.I.</label>
                    <input type="text" name="ci" id="ci" class="form-control" value="{{ old('ci', $user->paciente->ci ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $user->paciente->fecha_nacimiento ?? '') }}" required>
                </div>
                <div class="col-md-4">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" value="{{ old('telefono', $user->paciente->telefono ?? '') }}" required>
                </div>

                <div class="col-md-6">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" value="{{ old('direccion', $user->paciente->direccion ?? '') }}" required>
                </div>
                <div class="col-md-3">
                    <label for="genero" class="form-label">Género</label>
                    <select name="genero" id="genero" class="form-select" required>
                        <option value="">Seleccione...</option>
                        @foreach(['Masculino','Femenino','Otro'] as $gen)
                            <option value="{{ $gen }}" {{ (old('genero', $user->paciente->genero ?? '') == $gen) ? 'selected' : '' }}>{{ $gen }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto" class="form-control">
                </div>
            </div>
        </div>

        {{-- Detalles de la Cita --}}
        <div class="card shadow-sm card-hover mb-4 p-4" style="border-left: 5px solid #5DA6A6;">
            <h3 class="field-title mb-3">Detalles de Cita</h3>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="odontologo_id" class="form-label">Odontólogo</label>
                    <select class="form-select" id="odontologo_id" name="odontologo_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($odontologos as $odontologo)
                            <option value="{{ $odontologo->id }}">{{ $odontologo->nombres }} {{ $odontologo->apellidos }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="filtro_fecha" class="form-label">Buscar horarios disponibles de:</label>
                    <select id="filtro_fecha" class="form-select">
                        <option value="hoy">Hoy</option>
                        <option value="manana">Mañana</option>
                        <option value="semana_actual">Semana actual</option>
                        <option value="semana_siguiente">Semana siguiente</option>
                        <option value="este_mes">Este mes</option>
                        <option value="proximo_mes">Próximo mes</option>
                    </select>
                </div>


                <div class="col-md-12">
                    <label class="form-label">Horarios Disponibles</label>
                    <div id="lista_horarios" class="row g-2">
                        <p class="text-muted">Seleccione un odontólogo primero</p>
                    </div>
                    <input type="hidden" name="horario_id" id="horario_id" required>
                    @error('horario_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="col-md-4">
                    <label for="servicio_id" class="form-label">Servicio</label>
                    <select class="form-select" name="servicio_id" id="servicio_id" required>
                        <option value="">Seleccione...</option>
                        @foreach($servicios as $servicio)
                            <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="motivo" class="form-label">Motivo</label>
                    <textarea name="motivo" id="motivo" class="form-control" rows="2">{{ old('motivo') }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="observaciones" class="form-label">Observaciones</label>
                    <textarea name="observaciones" id="observaciones" class="form-control" rows="2">{{ old('observaciones') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Botones --}}
        <div class="d-flex gap-2 mb-5">
            <button type="submit" class="btn btn-success"><i class="fas fa-calendar-check"></i> Agendar Cita</button>
            <a href="{{ route('usuario.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancelar</a>
        </div>
    </form>
</div>

{{-- Script para cargar horarios --}}
<script>
document.getElementById('odontologo_id').addEventListener('change', cargarHorarios);
document.getElementById('filtro_fecha').addEventListener('change', cargarHorarios);

function cargarHorarios() {
    const odontologoId = document.getElementById('odontologo_id').value;
    const filtro = document.getElementById('filtro_fecha').value;
    const contenedor = document.getElementById('lista_horarios');
    const inputHidden = document.getElementById('horario_id');

    contenedor.innerHTML = '<p class="text-muted">Cargando horarios...</p>';
    inputHidden.value = '';

    if (!odontologoId) {
        contenedor.innerHTML = '<p class="text-muted">Seleccione un odontólogo primero</p>';
        return;
    }

    fetch(`/usuario/api/odontologos/${odontologoId}/horarios-disponibles?filtro=${filtro}`)
        .then(res => res.json())
        .then(data => {
            contenedor.innerHTML = '';
            if (data.length === 0) {
                contenedor.innerHTML = '<p class="text-muted">Sin horarios disponibles</p>';
                return;
            }

            data.forEach(dia => {
                const col = document.createElement('div');
                col.classList.add('col-12', 'mb-3');

                let html = `<div class="card p-3 shadow-sm">
                                <h5 class="mb-2 text-primary">${dia.dia} - ${dia.fecha}</h5>
                                <div class="d-flex flex-wrap gap-2">`;

                dia.bloques.forEach(h => {
                    html += `<button type="button" class="btn btn-outline-success horario-btn" data-id="${h.id}">
                                ${h.hora_inicio} - ${h.hora_fin}
                             </button>`;
                });

                html += `</div></div>`;
                col.innerHTML = html;
                contenedor.appendChild(col);
            });

            document.querySelectorAll('.horario-btn').forEach(btn => {
                btn.addEventListener('click', e => {
                    document.querySelectorAll('.horario-btn').forEach(b => b.classList.remove('active'));
                    e.target.classList.add('active');
                    inputHidden.value = e.target.dataset.id;
                });
            });
        })
        .catch(() => {
            contenedor.innerHTML = '<p class="text-danger">Error al cargar horarios</p>';
        });
}

</script>


{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '¡Cita Agendada!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#12403B'
    }).then(() => {
        window.location.href = "{{ route('usuario.citas') }}";
    });
</script>
@endif

{{-- Estilos --}}
<style>
.field-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #12403B;
    margin-bottom: 15px;
}
.card-hover {
    transition: transform 0.3s, box-shadow 0.3s;
    cursor: pointer;
}
.card-hover:hover {
    transform: scale(1.02);
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.horario-btn {
    border-radius: 10px;
    padding: 8px 14px;
    transition: all 0.2s ease;
}
.horario-btn.active {
    background-color: #12403B !important;
    color: white !important;
}
</style>

@endsection
