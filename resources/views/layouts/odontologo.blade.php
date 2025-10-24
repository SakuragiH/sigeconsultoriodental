<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Odontólogo')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fuente externa -->
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/odontologo.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Scripts Vite -->
    @vite(['resources/sass/app.scss','resources/js/app.js'])

    <!-- Stack para estilos adicionales -->
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('odontologo.index') }}" class="sidebar-header">
            <i class="fas fa-tooth"></i> Odontólogo
        </a>
        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('odontologo.perfil') ? 'active' : '' }}">
                <a href="{{ route('odontologo.perfil') }}"><i class="fas fa-user"></i><span>Perfil</span></a>
            </li>
            <li class="{{ request()->routeIs('odontologo.pacientes.*') ? 'active' : '' }}">
                <a href="{{ route('odontologo.pacientes.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Pacientes</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('odontologo.horarios') ? 'active' : '' }}">
                <a href="{{ route('odontologo.horarios') }}"><i class="fas fa-clock"></i><span>Horarios</span></a>
            </li>
            <li class="{{ request()->routeIs('odontologo.citas.index') ? 'active' : '' }}">
                <a href="{{ route('odontologo.citas.index') }}"><i class="fas fa-calendar-check"></i><span>Citas</span></a>
            </li>
            <li class="{{ request()->routeIs('odontologo.servicios.*') ? 'active' : '' }}">
                <a href="{{ route('odontologo.servicios.index') }}"><i class="fas fa-concierge-bell"></i><span>Servicios</span></a>
            </li>
            <li class="{{ request()->routeIs('odontologo.historialesmedicos.*') ? 'active' : '' }}">
                <a href="{{ route('odontologo.historialesmedicos.index') }}">
                    <i class="fas fa-notes-medical"></i>
                    <span>Historiales De Pacientes</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('odontologo.medicamentos.*') ? 'active' : '' }}">
                <a href="{{ route('odontologo.medicamentos.index') }}">
                    <i class="fas fa-pills"></i>
                    <span>Medicamentos</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('odontologo.prescripciones.*') ? 'active' : '' }}">
                <a href="{{ route('odontologo.prescripciones.index') }}">
                    <i class="fas fa-prescription-bottle-alt"></i>
                    <span>Prescripciones</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <h1 class="welcome-text">Bienvenido, Dr. {{ Auth::user()->name }}</h1>
            <button id="btn-logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Salir</button>
        </div>

        <!-- Modal logout -->
        <div id="logout-modal" class="modal">
            <div class="modal-box">
                <h3>¿Seguro que quieres salir?</h3>
                <div class="modal-actions">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-confirm">Sí</button>
                    </form>
                    <button id="btn-cancel" class="btn-cancel">No</button>
                </div>
            </div>
        </div>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

    <!-- JS modal logout -->
    <script>
        const btnLogout = document.getElementById('btn-logout');
        const modal = document.getElementById('logout-modal');
        const btnCancel = document.getElementById('btn-cancel');

        btnLogout.addEventListener('click', () => modal.style.display = 'flex');
        btnCancel.addEventListener('click', () => modal.style.display = 'none');
        window.addEventListener('click', (e) => { if(e.target === modal) modal.style.display = 'none'; });
    </script>

    <!-- SweetAlert2 global -->
    <script>
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e){
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#36808B',
                    cancelButtonColor: '#1A1D22',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if(result.isConfirmed){
                        form.submit();
                    }
                });
            });
        });

        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            confirmButtonColor: '#5DA6A6'
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: "{{ session('error') }}",
            confirmButtonColor: '#36808B'
        });
        @endif
    </script>

    <!-- Stack para scripts adicionales -->
    @stack('scripts')
</body>
</html>
