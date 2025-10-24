@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="text-center mb-4">Contáctanos</h2>

    <div class="row g-4">
        <!-- Información de contacto -->
        <div class="col-md-6">
            <div class="service-card p-4">
                <h5>Dirección</h5>
                <p>Av. Ejemplo #123, La Paz, Bolivia</p>

                <h5>Teléfonos</h5>
                <p>+591 700-12345 <br> +591 700-67890</p>

                <h5>Emails</h5>
                <p>info@alcalasdental.com <br> citas@alcalasdental.com</p>
            </div>
        </div>

        <!-- Mapa -->
        <div class="col-md-6">
            <div class="service-card p-0">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3857.1234567890!2d-68.123456!3d-16.500000!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x123456789abcdef!2sConsultorio%20Dental%20Alcala's%20Dent!5e0!3m2!1ses!2sbo!4v1690000000000!5m2!1ses!2sbo" 
                    width="100%" 
                    height="350" 
                    style="border:0; border-radius:25px;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection
