@extends('layouts.app')

@section('content')
<div class="container dental-home mt-1">

    <div class="hero-title">
    <h1>¡Sonríe con confianza en Alcala's Dent! </h1>
    <p>Tu salud dental es nuestra prioridad. Descubre nuestros servicios y agenda tu cita hoy mismo.</p>
    <p class="chatbot-prompt">¡¡¡¡¡¡¡Prueba nuestro chatbot y consulta cualquier duda!!!!!!</p>
</div>




    <!--  Hero / Carrusel + ChatBot IA -->
<div class="row align-items-start mb-5">
    <!-- Carrusel de imágenes a la izquierda -->
    <div class="col-md-7 mb-3 mb-md-0">
        <!-- Contenedor para el borde degradado -->
        <div class="carousel-border p-1">
            <div id="carouselConsultorio" class="carousel slide shadow" data-bs-ride="carousel" data-bs-interval="2000" style="height: 400px;">
                <div class="carousel-inner h-100">
                    <div class="carousel-item active h-100">
                        <img src="{{ asset('images/inicio/consul1.jpeg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Consultorio 1">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="{{ asset('images/inicio/consul2.jpeg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Consultorio 2">
                    </div>
                    <div class="carousel-item h-100">
                        <img src="{{ asset('images/inicio/consul3.jpeg') }}" class="d-block w-100 h-100" style="object-fit: cover;" alt="Consultorio 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselConsultorio" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselConsultorio" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>

        <!-- ChatBot IA a la derecha -->
        <div class="col-md-5">
            <div class="chatbot-card shadow">
                <div class="chatbot-header">
                    <h5>Hola </h5>
                    <p>Soy tu asistente virtual. Escribe aquí tus dudas y agenda tu cita.</p>
                </div>
                <div class="chatbot-body" id="chatbot-body">
                    <!-- Mensajes aparecerán aquí -->
                </div>
                <div class="chatbot-input">
                    <input type="text" id="chatbot-input" placeholder="Escribe tu mensaje..." />
                    <button id="chatbot-send">Enviar</button>
                </div>
            </div>
        </div>



            <!-- 🦷 Sección de Servicios -->
        <div class="row justify-content-center mb-5">
            <div class="col-md-10">
                <div class="service-box text-center">
                    <h2>Nuestros Servicios</h2>
                    <p>Ofrecemos una amplia gama de tratamientos dentales con profesionales calificados para cuidar tu sonrisa.</p>
                </div>
            </div>
        </div>


    <!-- 📦 Servicios destacados (resumen) -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="service-card">
                <img src="{{ asset('images/limpieza.jpg') }}" alt="Limpieza Dental">
                <div class="p-3">
                    <h5>Limpieza Dental</h5>
                    <p>Realizamos limpiezas profesionales para mantener tu boca saludable y prevenir problemas.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card">
                <img src="{{ asset('images/blanqueamiento.jpg') }}" alt="Blanqueamiento">
                <div class="p-3">
                    <h5>Blanqueamiento Dental</h5>
                    <p>Deja tu sonrisa más brillante con nuestros tratamientos seguros y efectivos.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card">
                <img src="{{ asset('images/ortodoncia.jpg') }}" alt="Ortodoncia">
                <div class="p-3">
                    <h5>Ortodoncia</h5>
                    <p>Mejora la alineación de tus dientes con tratamientos modernos de ortodoncia.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ Ventajas del consultorio -->
    <div class="row text-center g-4 mb-5">
        <div class="col-md-3">
            <div class="service-card p-4 shadow-sm">
                <h6>Atención Profesional</h6>
                <p>Equipo calificado y atento para tu bienestar.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="service-card p-4 shadow-sm">
                <h6>Equipamiento Moderno</h6>
                <p>Utilizamos tecnología de punta en todos los tratamientos.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="service-card p-4 shadow-sm">
                <h6>Ambiente Seguro</h6>
                <p>Espacios cómodos y esterilizados para tu tranquilidad.</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="service-card p-4 shadow-sm">
                <h6>Horarios Flexibles</h6>
                <p>Nos adaptamos a tus tiempos y necesidades.</p>
            </div>
        </div>
    </div>

    <!-- 👨‍⚕️ Nuestro equipo (resumido) -->
    <div class="row text-center g-4 mb-5">
        <div class="col-md-4">
            <div class="service-card p-3 shadow-sm">
                <img src="{{ asset('images/dentista1.jpg') }}" class="rounded-circle mb-2" style="width:100px;height:100px;" alt="Dr. Juan Pérez">
                <h6>Dr. Juan Pérez</h6>
                <p>Ortodoncia</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card p-3 shadow-sm">
                <img src="{{ asset('images/dentista2.jpg') }}" class="rounded-circle mb-2" style="width:100px;height:100px;" alt="Dra. María López">
                <h6>Dra. María López</h6>
                <p>Odontología General</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="service-card p-3 shadow-sm">
                <img src="{{ asset('images/dentista3.jpg') }}" class="rounded-circle mb-2" style="width:100px;height:100px;" alt="Dr. Carlos Díaz">
                <h6>Dr. Carlos Díaz</h6>
                <p>Estética Dental</p>
            </div>
        </div>
    </div>

</div>


@endsection
