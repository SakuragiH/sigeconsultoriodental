@extends('layouts.app')

@section('content')
<div class="container my-5">

    <!-- Hero / Cabecera -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="hero-title text-center">
                <h1>Sobre Nosotros</h1>
                <p>Conoce nuestro consultorio, nuestra misión y el equipo que cuida de tu sonrisa.</p>
            </div>
        </div>
    </div>

    <!--  Misión, Visión y Valores -->
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="service-card p-4 shadow-sm rounded-4">
                <h5>Misión</h5>
                <p>Brindar atención odontológica de calidad, con un equipo profesional y tecnología moderna, priorizando la salud y bienestar de nuestros pacientes.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card p-4 shadow-sm rounded-4">
                <h5>Visión</h5>
                <p>Ser reconocidos como un consultorio líder en cuidado dental, innovando constantemente y ofreciendo un servicio confiable y accesible.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card p-4 shadow-sm rounded-4">
                <h5>Valores</h5>
                <p>Compromiso, responsabilidad, ética, atención personalizada y confianza son la base de nuestro trabajo diario.</p>
            </div>
        </div>
    </div>

    <!--  Historia del consultorio -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6 mb-3 mb-md-0">
            <img src="{{ asset('images/historia.jpg') }}" class="rounded-4 shadow w-100" alt="Historia del Consultorio">
        </div>
        <div class="col-md-6">
            <h5>Nuestra Historia</h5>
            <p>Fundado hace más de 10 años, Alcala's Dent ha crecido gracias a la confianza de nuestros pacientes y al compromiso de nuestro equipo. Nos enfocamos en ofrecer tratamientos seguros y modernos, en un ambiente cómodo y amigable.</p>
            <p>Desde nuestros inicios, nuestra meta ha sido crear sonrisas saludables y felices, con atención personalizada y un enfoque integral en odontología.</p>
        </div>
    </div>

    <!--  Equipo de Odontólogos -->
    <div class="row g-4 mb-5">
        @foreach($odontologos as $odontologo)
            <div class="col-12">
                <div class="card p-4 shadow-sm border-0"
                     style="border-radius:25px;
                            background: linear-gradient(135deg, #36808B, #5DA6A6, #12403B, #1A1D22);
                            color:#FFFFFF;">
                    <div class="row align-items-start">
                        <!-- Foto -->
                        <div class="col-md-4 text-center mb-3 mb-md-0">
                            <img src="{{ $odontologo->foto ? asset('storage/odontologos/'.$odontologo->foto) : asset('img/default-avatar.png') }}"
                                 class="rounded-circle shadow"
                                 style="width:300px; height:300px; object-fit:cover; border:5px solid #FFFFFF;"
                                 alt="{{ $odontologo->nombres }} {{ $odontologo->apellidos }}">
                        </div>

                        <!-- Información -->
                        <div class="col-md-8">
                            <h2 style="font-size:2.4rem; font-weight:800; margin-bottom:1rem;">
                                {{ $odontologo->nombres }} {{ $odontologo->apellidos }}
                            </h2>

                            @if($odontologo->especialidad)
                                <div class="p-3 mb-2 rounded-3"
                                     style="background:rgba(255,255,255,0.15); font-size:1.3rem; font-weight:600;">
                                    {{ $odontologo->especialidad }}
                                </div>
                            @endif

                            @if($odontologo->telefono)
                                <div class="p-3 mb-2 rounded-3"
                                     style="background:rgba(255,255,255,0.1); font-size:1.2rem;">
                                    <strong>Teléfono:</strong> {{ $odontologo->telefono }}
                                </div>
                            @endif

                            @if($odontologo->direccion)
                                <div class="p-3 mb-2 rounded-3"
                                     style="background:rgba(255,255,255,0.1); font-size:1.2rem;">
                                    <strong>Dirección:</strong> {{ $odontologo->direccion }}
                                </div>
                            @endif

                            @if($odontologo->formaciones->isNotEmpty())
                                <div class="row g-3 mb-3 mt-2">
                                    @foreach($odontologo->formaciones as $formacion)
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3"
                                                 style="background:rgba(255,255,255,0.15); font-size:1.1rem;">
                                                <strong>{{ $formacion->descripcion }}</strong>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <p style="font-size:1.1rem; line-height:1.6; margin-top:1rem;">
                                Este profesional se dedica a brindar atención odontológica de alta calidad, combinando experiencia, innovación y cercanía con los pacientes. Su objetivo es garantizar la salud dental y crear sonrisas sanas y felices.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- CTA final -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <div class="service-box text-center p-4 shadow-sm rounded-4">
                <h2>¿Quieres agendar tu cita?</h2>
                <p>Contáctanos y nuestro equipo te ayudará a programar tu visita de manera rápida y sencilla.</p>
                <a href="/contacto" class="btn btn-primary mt-3">Contáctanos</a>
            </div>
        </div>
    </div>

</div>
@endsection
