@extends('layouts.app')

@section('content')
<div class="container my-5">

    <!-- Hero / Cabecera -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="hero-title text-center">
                <h1>Sobre Nosotros</h1>
                <p>Conoce nuestro consultorio, nuestra misión y el equipo que cuida de tu sonrisa. Nos esforzamos cada día por ofrecerte un entorno seguro, familiar y acogedor, donde cada paciente se sienta escuchado, acompañado y en confianza. Nuestro objetivo es brindarte siempre una mano amiga, combinando la atención humana con la tecnología moderna para garantizar tratamientos de calidad, confort y resultados duraderos. En nuestro consultorio, tu bienestar y tu sonrisa son nuestra mayor motivación.</p>
            </div>
        </div>
    </div>

    <!-- 🌟 Misión, Visión y Valores -->
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="service-card p-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ asset('images/nosotros/mision.jpg') }}" 
                     alt="Misión del consultorio" 
                     class="w-100" 
                     style="height: 220px; object-fit: cover;">
                <div class="p-4">
                    <h5>Misión</h5>
                    <p>Brindar atención odontológica de calidad, con un equipo profesional y tecnología moderna, priorizando la salud y bienestar de nuestros pacientes.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-card p-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ asset('images/nosotros/vision.jpg') }}" 
                     alt="Visión del consultorio" 
                     class="w-100" 
                     style="height: 220px; object-fit: cover;">
                <div class="p-4">
                    <h5>Visión</h5>
                    <p>Ser reconocidos como un consultorio líder en cuidado dental, innovando constantemente y ofreciendo un servicio confiable y accesible.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="service-card p-0 shadow-sm rounded-4 overflow-hidden">
                <img src="{{ asset('images/nosotros/valores.jpg') }}" 
                     alt="Valores del consultorio" 
                     class="w-100" 
                     style="height: 220px; object-fit: cover;">
                <div class="p-4">
                    <h5>Valores</h5>
                    <p>Compromiso, responsabilidad, ética, atención personalizada y confianza son la base de nuestro trabajo diario.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Historia del consultorio -->
    <div class="row align-items-center mb-5 historia-consultorio p-4 rounded-4 shadow-lg" 
         style="background: linear-gradient(135deg, #36808B, #5DA6A6); color: #FFFFFF;">
        <div class="col-md-6 mb-3 mb-md-0">
            <img src="{{ asset('images/nosotros/consul1.jpeg') }}" 
                 class="rounded-4 shadow w-100 historia-img" 
                 alt="Historia del Consultorio">
        </div>

        <div class="col-md-6 historia-texto">
            <h5 style="font-weight:700; font-size:1.8rem; margin-bottom:1rem; color:#FFFFFF;">Nuestra Historia</h5>
            <p style="font-size:1.05rem; line-height:1.6; color:#EAF6F6;">
                Fundado hace más de 10 años, Alcala's Dent ha crecido gracias a la confianza de nuestros pacientes y al compromiso de nuestro equipo. Nos enfocamos en ofrecer tratamientos seguros y modernos, en un ambiente cómodo y amigable.
            </p>
            <p style="font-size:1.05rem; line-height:1.6; color:#EAF6F6;">
                Desde nuestros inicios, nuestra meta ha sido crear sonrisas saludables y felices, con atención personalizada y un enfoque integral en odontología.
            </p>
        </div>
    </div>

    <!-- Equipo de Odontólogos -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 shadow-sm rounded-4"
                 style="background: linear-gradient(135deg, #1A1D22, #12403B, #5DA6A6, #36808B);
                        color: #FFFFFF;">
                <div class="text-center position-relative">
                    <h2 style="font-size:2rem; font-weight:800; margin-bottom:0.5rem; display:inline-block; position:relative; color:#FFFFFF;">
                        Conoce a Nuestro Equipo Profesional
                        <span style="display:block; width:60px; height:4px; background:#FFFFFF; margin:8px auto 0; border-radius:2px;"></span>
                    </h2>
                    <p style="font-size:1rem; color:#EAF6F6;">
                        Cada uno de nuestros odontólogos está comprometido con tu bienestar, combinando experiencia, atención personalizada y tecnología de vanguardia.
                    </p>
                </div>
            </div>
        </div>
    </div>

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

                            <!-- Formaciones -->
                            @if($odontologo->formaciones->isNotEmpty())
                                <div class="row g-3 mb-3 mt-2">
                                    @foreach($odontologo->formaciones as $formacion)
                                        <div class="col-md-6">
                                            <div class="p-3 rounded-3"
                                                 style="background:rgba(255,255,255,0.15); font-size:1.1rem;">
                                                <strong>{{ $formacion->descripcion }}</strong>
                                                @php
                                                    $ext = pathinfo($formacion->archivo, PATHINFO_EXTENSION);
                                                @endphp
                                                @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                                                    <img src="{{ asset('storage/'.$formacion->archivo) }}" 
                                                         alt="Formación" style="width:100%; border-radius:8px; margin-top:5px;">
                                                @elseif(strtolower($ext) === 'pdf')
                                                    <iframe src="{{ asset('storage/'.$formacion->archivo) }}" width="100%" height="150px" style="margin-top:5px;"></iframe>
                                                @endif
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
                <p>Te invitamos a formar parte de nuestra familia dental. Regístrate para acceder a la reserva de citas en línea, consultar nuestros servicios personalizados y mantener contacto directo con nuestro equipo profesional.</p>
                <div class="d-flex justify-content-center gap-3 mt-3 flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-primary">Registrarme</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light">Ya tengo una cuenta</a>
                </div>
                <p class="mt-3" style="font-size: 0.95rem; color: #EAF6F6;">
                    Si ya estás registrado, inicia sesión para agendar tu próxima cita y acceder a todos nuestros servicios.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection
