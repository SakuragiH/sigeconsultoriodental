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

    <div class="row g-4">
        <!-- Perfil usuario a la izquierda -->
        <div class="col-lg-4 d-flex justify-content-center">
            <div class="card shadow-lg border-0 p-4 profile-card-left">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="{{ $user->paciente && $user->paciente->foto ? asset('storage/pacientes/' . $user->paciente->foto) : asset('storage/pacientes/usuariopordefecto.png') }}" 
                         alt="{{ $user->paciente->nombres ?? $user->name }}" 
                         class="rounded-circle mb-3 profile-pic-left">

                    <h3 class="text-white mb-2">{{ $user->paciente->nombres ?? $user->name }} {{ $user->paciente->apellidos ?? '' }}</h3>

                    @if($user->paciente)
                        <p class="text-white mb-1"><i class="fas fa-id-card me-2"></i>{{ $user->paciente->ci }}</p>
                        <p class="text-white mb-1"><i class="fas fa-birthday-cake me-2"></i>{{ $user->paciente->fecha_nacimiento }}</p>
                        <p class="text-white mb-1"><i class="fas fa-phone me-2"></i>{{ $user->paciente->telefono }}</p>
                        <p class="text-white mb-1"><i class="fas fa-map-marker-alt me-2"></i>{{ $user->paciente->direccion }}</p>
                        <p class="text-white mb-1"><i class="fas fa-venus-mars me-2"></i>{{ $user->paciente->genero }}</p>
                    @else
                        <p class="text-white">Aún no has completado tu perfil.</p>
                    @endif

                    <a href="{{ route('usuario.perfil.editar') }}" class="btn btn-light btn-sm mt-3">
                        <i class="fas fa-user"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>

        <!-- Cards a la derecha -->
        <div class="col-lg-8">
            <div class="row g-4">
                <div class="col-md-6">
                    <a href="{{ route('usuario.citas.crear') }}" class="text-decoration-none">
                        <div class="card shadow-lg hover-card text-center p-4 dashboard-card" style="background: linear-gradient(135deg, #12403B, #36808B);">
                            <i class="fas fa-calendar-check fa-3x mb-3 text-white"></i>
                            <h5 class="card-title text-white">Agendar Cita</h5>
                            <p class="card-text text-white-50">Reserva tu cita de manera rápida y fácil.</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('usuario.prescripciones.index') }}" class="text-decoration-none">
                        <div class="card shadow-lg hover-card text-center p-4 dashboard-card" style="background: linear-gradient(135deg, #5DA6A6, #36808B);">
                            <i class="fas fa-prescription-bottle-alt fa-3x mb-3 text-white"></i>
                            <h5 class="card-title text-white">Prescripciones</h5>
                            <p class="card-text text-white-50">Accede y descarga tus recetas médicas.</p>
                        </div>
                    </a>
                </div>

                <div class="col-md-6">
                    <div id="btnRecomendaciones" class="card shadow-lg hover-card text-center p-4 dashboard-card" style="background: linear-gradient(135deg, #36808B, #1A1D22); cursor:pointer;">
                        <i class="fas fa-smile-beam fa-3x mb-3 text-white"></i>
                        <h5 class="card-title text-white">Recomendaciones</h5>
                        <p class="card-text text-white-50">Consejos y hábitos para tu salud dental.</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <a href="{{ route('servicios') }}" class="text-decoration-none">
                        <div class="card shadow-lg hover-card text-center p-4 dashboard-card" style="background: linear-gradient(135deg, #12403B, #5DA6A6);">
                            <i class="fas fa-hospital-symbol fa-3x mb-3 text-white"></i>
                            <h5 class="card-title text-white">Servicios</h5>
                            <p class="card-text text-white-50">Explora todos nuestros servicios disponibles.</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- NUEVO BLOQUE DE TIPS DEBAJO DE TODO -->
    <div class="row g-4 mt-4 collapse" id="panelRecomendaciones">
        @php
            $tips = [
                ['icon'=>'fas fa-brush','title'=>'Cepillado Correcto','text'=>'Cepíllate los dientes al menos dos veces al día durante 2 minutos con pasta con flúor.'],
                ['icon'=>'fas fa-stream','title'=>'Hilo Dental','text'=>'Usa hilo dental o cepillos interdentales una vez al día para limpiar entre dientes.'],
                ['icon'=>'fas fa-tooth','title'=>'Chequeos Regulares','text'=>'Visita al odontólogo cada 6 meses para limpieza y detección temprana de problemas.'],
                ['icon'=>'fas fa-candy-cane','title'=>'Reducir Azúcares','text'=>'Evita refrescos y dulces para prevenir caries y desgaste del esmalte.'],
                ['icon'=>'fas fa-wine-bottle','title'=>'Enjuague Bucal','text'=>'Usa enjuague con flúor para fortalecer el esmalte y reducir bacterias.'],
                ['icon'=>'fas fa-shield-alt','title'=>'Protección Deportiva','text'=>'Usa protector bucal en deportes de contacto para evitar fracturas y lesiones.'],
                ['icon'=>'fas fa-smoking-ban','title'=>'No Fumar','text'=>'Evita tabaco y fumar, aumenta riesgo de enfermedad periodontal y manchas.'],
                ['icon'=>'fas fa-heart','title'=>'Cuidado de Encías','text'=>'Masajea y cepilla suavemente las encías para prevenir inflamación y sangrado.'],
                ['icon'=>'fas fa-apple-alt','title'=>'Alimentación Saludable','text'=>'Consume frutas, verduras y lácteos ricos en calcio y vitamina D para dientes fuertes.'],
            ];
        @endphp

        @foreach($tips as $tip)
        <div class="col-md-4">
            <div class="card shadow-lg text-center p-3 tip-card" style="background: linear-gradient(135deg, #36808B, #5DA6A6);">
                <i class="{{ $tip['icon'] }} fa-2x mb-2 text-white"></i>
                <h6 class="card-title text-white">{{ $tip['title'] }}</h6>
                <p class="card-text text-white-50">{{ $tip['text'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script>
    const btn = document.getElementById('btnRecomendaciones');
    const panel = document.getElementById('panelRecomendaciones');

    btn.addEventListener('click', function() {
        panel.classList.toggle('show');
        panel.scrollIntoView({ behavior: 'smooth' });
    });
</script>

<style>
    body {
        background: linear-gradient(180deg, #f0f2f5 0%, #e0f2f1 100%);
        min-height: 100vh;
    }
    .profile-card-left {
        border-radius: 20px;
        background: linear-gradient(135deg, #36808B, #5DA6A6);
        transition: transform 0.3s, box-shadow 0.3s;
        width: 100%;
    }
    .profile-card-left:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.25);
    }
    .profile-pic-left {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border: 4px solid #fff;
        transition: transform 0.3s;
    }
    .profile-pic-left:hover {
        transform: scale(1.05);
    }
    .dashboard-card {
        border-radius: 20px;
        transition: transform 0.4s, box-shadow 0.4s;
    }
    .dashboard-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.25);
    }
    .tip-card {
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
    }
    .tip-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
    }
    #panelRecomendaciones {
        transition: all 0.5s ease;
    }
    #panelRecomendaciones.show {
        display: flex !important;
        flex-wrap: wrap;
    }
</style>
@endsection
