@extends('layouts.usuario')

@section('content')
<div class="container mt-5">

    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Listo!',
                text: '{{ session('success') }}',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif

    <!-- Perfil: foto + info -->
    <div class="card shadow-sm card-hover p-4 mb-4" style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
        <div class="d-flex flex-wrap align-items-center">
            @if($user->paciente && $user->paciente->foto)
                <img src="{{ asset('storage/pacientes/' . $user->paciente->foto) }}" 
                     alt="Foto de {{ $user->paciente->nombres ?? $user->name }}" 
                     class="rounded-circle me-4 mb-3" 
                     style="width:180px; height:180px; object-fit:cover; border:4px solid #fff;">
            @else
                <img src="{{ asset('storage/pacientes/usuariopordefecto.png') }}" 
                     alt="Foto por defecto" 
                     class="rounded-circle me-4 mb-3" 
                     style="width:180px; height:180px; object-fit:cover; border:4px solid #fff;">
            @endif

            <div class="flex-grow-1">
                <h2 class="field-title text-white mb-3">
                    {{ $user->paciente->nombres ?? $user->name }} {{ $user->paciente->apellidos ?? '' }}
                </h2>

                @if($user->paciente)
                    <div class="info-field mb-2"><strong>C.I.:</strong> {{ $user->paciente->ci }}</div>
                    <div class="info-field mb-2"><strong>Fecha de Nacimiento:</strong> {{ $user->paciente->fecha_nacimiento }}</div>
                    <div class="info-field mb-2"><strong>Teléfono:</strong> {{ $user->paciente->telefono }}</div>
                    <div class="info-field mb-2"><strong>Dirección:</strong> {{ $user->paciente->direccion }}</div>
                    <div class="info-field mb-2"><strong>Género:</strong> {{ $user->paciente->genero }}</div>
                @else
                    <p class="text-white">Aún no has completado tu perfil.</p>
                @endif

                <a href="{{ route('usuario.perfil.editar') }}" class="btn btn-sm mt-2">
                    <i class="fas fa-user"></i> Editar Perfil
                </a>
            </div>
        </div>
    </div>

    <!-- Dashboard cards -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card shadow-sm text-center hover-card" style="background-color: var(--primary-color);">
                <div class="card-body">
                    <i class="fas fa-tooth fa-2x mb-2"></i>
                    <h5 class="card-title">Servicios</h5>
                    <p class="card-text">Ver nuestros servicios disponibles.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm text-center hover-card" style="background-color: var(--secondary-color);">
                <div class="card-body">
                    <i class="fas fa-notes-medical fa-2x mb-2"></i>
                    <h5 class="card-title">Historial Médico</h5>
                    <p class="card-text">Consulta tus registros médicos.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm text-center hover-card" style="background-color: var(--dark-color);">
                <div class="card-body">
                    <i class="fas fa-prescription-bottle-alt fa-2x mb-2"></i>
                    <h5 class="card-title">Prescripciones</h5>
                    <p class="card-text">Descarga tus recetas médicas.</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm text-center hover-card" style="background-color: var(--text-dark);">
                <div class="card-body">
                    <i class="fas fa-smile-beam fa-2x mb-2"></i>
                    <h5 class="card-title">Recomendaciones</h5>
                    <p class="card-text">Consejos de cuidado dental y hábitos saludables.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
