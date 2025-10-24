@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">

    <!-- Título centrado con menos altura -->
    <div class="d-flex justify-content-center mb-4">
    <div class="hero-title text-center rounded-4 p-3" 
         style="background: linear-gradient(90deg, #36808B, #5DA6A6, #12403B); 
                color:#fff; 
                max-width: 2000px; width: 85%;">
        <h1 class="fw-bold mb-1" style="font-family: 'Poppins', sans-serif; font-size:1.8rem;">
            Nuestros Servicios
        </h1>
        <p class="mb-0" style="font-family: 'Poppins', sans-serif; font-size:0.95rem;">
            Descubre todos los tratamientos y servicios odontológicos que ofrecemos para cuidar tu sonrisa.
        </p>
    </div>
</div>


    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse ($servicios as $servicio)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="card service-card text-center h-100 rounded-4 p-3 shadow-sm border-0">
                        
                        <div class="service-img-wrapper rounded-4 mb-3" style="overflow: hidden; border: 2px solid #5DA6A6;">
                            <img 
                                src="{{ $servicio->foto 
                                    ? (str_starts_with($servicio->foto, 'storage') 
                                        ? url($servicio->foto) 
                                        : url('storage/'.$servicio->foto)) 
                                    : asset('storage/servicios/default.png') }}" 
                                alt="{{ $servicio->nombre }}" 
                                class="img-fluid w-100" 
                                style="height: 220px; object-fit: cover; transition: transform 0.5s ease;">
                        </div>

                        <h5 class="fw-bold mb-2 servicio-nombre" style="color:#12403B;">
                            {{ $servicio->nombre }}
                        </h5>

                        <p class="mb-2 servicio-desc text-muted" style="font-size: 0.95rem;">
                            {{ Str::limit($servicio->descripcion, 100) }}
                        </p>

                        <p class="fw-bold servicio-precio" style="color:#eeeeee; font-size:1.1rem;">
                            Bs {{ number_format($servicio->precio, 2) }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No hay servicios disponibles por el momento.</p>
                </div>
            @endforelse
        </div>

        <!-- Mensaje de registro -->
        <div class="registro-alert text-center mt-4 rounded-3 px-3 py-3" 
             style="background-color:#1A1D22; color:#fff; font-family: 'Poppins', sans-serif;">
            <p class="mb-0 fw-semibold">
                Para agendar un servicio o consultar cualquier tratamiento, 
                <a href="{{ route('register') }}" class="text-white text-decoration-underline">regístrate</a> o 
                <a href="{{ route('login') }}" class="text-white text-decoration-underline">inicia sesión</a>.
            </p>
        </div>
    </div>
</div>

<style>
    .service-card {
        cursor: pointer;
        transition: all 0.3s ease;
        border-radius: 1rem;
        background: linear-gradient(135deg, #36808B, #5DA6A6, #12403B);
        color: #ffffff;
        box-shadow: 0 6px 12px rgba(26, 29, 34, 0.15);
    }

    .service-card:hover {
        transform: translateY(-5px) scale(1.03);
        box-shadow: 0 12px 25px rgba(26, 29, 34, 0.3);
    }

    .service-card:hover .service-img-wrapper img {
        transform: scale(1.05);
    }

    .servicio-nombre { font-family: 'Poppins', sans-serif; font-size: 1.3rem; }
    .servicio-desc { min-height: 50px; }
    .servicio-precio { font-weight: 600; }

    @media (max-width: 992px) { .service-card img { height: 200px; } }
    @media (max-width: 768px) { .service-card img { height: 180px; } }
    @media (max-width: 576px) { .service-card img { height: 160px; } }
</style>
@endsection
