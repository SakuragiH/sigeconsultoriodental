<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','Alcalas Dent')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/usuario.css') }}"> <!-- Aquí cargamos el CSS separado -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/sass/app.scss','resources/js/app.js'])
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('usuario.index') }}" class="sidebar-header">
            <i class="fas fa-user-circle"></i> {{ Auth::user()->paciente->nombres ?? Auth::user()->name }}
        </a>

        <ul class="sidebar-menu">
            <li class="{{ request()->routeIs('usuario.perfil.editar') ? 'active' : '' }}">
                <a href="{{ route('usuario.perfil.editar') }}">
                    <i class="fas fa-user"></i> <span>Tu información</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('usuario.citas') ? 'active' : '' }}">
                <a href="{{ route('usuario.citas') }}">
                    <i class="fas fa-calendar-check"></i> <span>Tus Citas</span>
                </a>
            </li>

            <li class="{{ request()->routeIs('usuario.citas.crear') ? 'active' : '' }}">
                <a href="{{ route('usuario.citas.crear') }}">
                    <i class="fas fa-plus-circle"></i> <span>Agendar Cita</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('usuario.prescripciones.index') ? 'active' : '' }}">
                <a href="{{ route('usuario.prescripciones.index') }}">
                    <i class="fas fa-prescription-bottle-alt"></i> <span>Prescripciones</span>
                </a>
            </li>

        </ul>
    </aside>

    <!-- Top Bar -->
    <header class="top-bar">
        <h2 id="module-title">Inicio</h2>
        <button class="logout-btn" id="logout-btn">
            <i class="fas fa-sign-out-alt"></i> Salir
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script>
        // Cambiar título automáticamente según la ruta actual
        const routeName = "{{ Route::currentRouteName() }}";
        const moduleTitle = document.getElementById('module-title');
        const titles = {
            'usuario.index': 'Inicio',
            'usuario.perfil.editar': 'Tu información',
            'usuario.citas': 'Tus Citas',
            'usuario.citas.crear': 'Agendar Cita',
            'usuario.prescripciones.index': 'Prescripciones'
        };
        if (titles[routeName]) moduleTitle.textContent = titles[routeName];

        // Confirmación al cerrar sesión
        document.getElementById('logout-btn').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                title: '¿Deseas cerrar sesión?',
                text: "Tu sesión actual se cerrará.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#36808B',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, salir',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('logout-form').submit();
            });
        });
    </script>
</body>
</html>
