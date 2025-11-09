<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


//rutas para configuracion
Route::get('/admin/configuraciones', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('admin.configuracion.index')->middleware('auth');
Route::post('/admin/configuraciones/create', [App\Http\Controllers\ConfiguracionController::class, 'store'])->name('admin.configuracion.store')->middleware('auth');


//rutas para roles
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth');
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth');
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth');
Route::get('/admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth');
Route::put('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth');
Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth');


// Rutas para Medicamentos
Route::get('/admin/medicamentos', [App\Http\Controllers\MedicamentoController::class, 'index'])->name('admin.medicamentos.index')->middleware('auth');
Route::get('/admin/medicamentos/create', [App\Http\Controllers\MedicamentoController::class, 'create'])->name('admin.medicamentos.create')->middleware('auth');
Route::post('/admin/medicamentos', [App\Http\Controllers\MedicamentoController::class, 'store'])->name('admin.medicamentos.store')->middleware('auth');
Route::get('/admin/medicamentos/{medicamento}/edit', [App\Http\Controllers\MedicamentoController::class, 'edit'])->name('admin.medicamentos.edit')->middleware('auth');
Route::put('/admin/medicamentos/{medicamento}', [App\Http\Controllers\MedicamentoController::class, 'update'])->name('admin.medicamentos.update')->middleware('auth');
Route::delete('/admin/medicamentos/{medicamento}', [App\Http\Controllers\MedicamentoController::class, 'destroy'])->name('admin.medicamentos.destroy')->middleware('auth');


// Rutas para Odontologos
Route::get('/admin/odontologos', [App\Http\Controllers\OdontologoController::class, 'index'])->name('admin.odontologos.index')->middleware('auth');
Route::get('/admin/odontologos/create', [App\Http\Controllers\OdontologoController::class, 'create'])->name('admin.odontologos.create')->middleware('auth');
Route::post('/admin/odontologos/create', [App\Http\Controllers\OdontologoController::class, 'store'])->name('admin.odontologos.store')->middleware('auth');
Route::get('/admin/odontologos/{id}', [App\Http\Controllers\OdontologoController::class, 'show'])->name('admin.odontologos.show')->middleware('auth');
Route::get('/admin/odontologos/{id}/edit', [App\Http\Controllers\OdontologoController::class, 'edit'])->name('admin.odontologos.edit')->middleware('auth');
Route::put('/admin/odontologos/{id}', [App\Http\Controllers\OdontologoController::class, 'update'])->name('admin.odontologos.update')->middleware('auth');
Route::delete('/admin/odontologos/{id}', [App\Http\Controllers\OdontologoController::class, 'destroy'])->name('admin.odontologos.destroy')->middleware('auth');

//rutas para pacientes
Route::get('/admin/pacientes', [App\Http\Controllers\PacienteController::class, 'index'])->name('admin.pacientes.index')->middleware('auth');
Route::get('/admin/pacientes/create', [App\Http\Controllers\PacienteController::class, 'create'])->name('admin.pacientes.create')->middleware('auth');
Route::post('/admin/pacientes/create', [App\Http\Controllers\PacienteController::class, 'store'])->name('admin.pacientes.store')->middleware('auth');
Route::get('/admin/pacientes/{id}', [App\Http\Controllers\PacienteController::class, 'show'])->name('admin.pacientes.show')->middleware('auth');
Route::get('/admin/pacientes/{id}/edit', [App\Http\Controllers\PacienteController::class, 'edit'])->name('admin.pacientes.edit')->middleware('auth');
Route::put('/admin/pacientes/{id}', [App\Http\Controllers\PacienteController::class, 'update'])->name('admin.pacientes.update')->middleware('auth');
Route::delete('/admin/pacientes/{id}', [App\Http\Controllers\PacienteController::class, 'destroy'])->name('admin.pacientes.destroy')->middleware('auth');


//rutas para citas
Route::get('/admin/citas', [App\Http\Controllers\CitaController::class, 'index'])->name('admin.citas.index')->middleware('auth');
Route::get('/admin/citas/create', [App\Http\Controllers\CitaController::class, 'create'])->name('admin.citas.create')->middleware('auth');
Route::post('/admin/citas/create', [App\Http\Controllers\CitaController::class, 'store'])->name('admin.citas.store')->middleware('auth');
Route::get('/admin/citas/{id}', [App\Http\Controllers\CitaController::class, 'show'])->name('admin.citas.show')->middleware('auth');
Route::get('/admin/citas/{id}/edit', [App\Http\Controllers\CitaController::class, 'edit'])->name('admin.citas.edit')->middleware('auth');
Route::put('/admin/citas/{id}', [App\Http\Controllers\CitaController::class, 'update'])->name('admin.citas.update')->middleware('auth');
Route::delete('/admin/citas/{id}', [App\Http\Controllers\CitaController::class, 'destroy'])->name('admin.citas.destroy')->middleware('auth');

//ruta para actualizar estado de cita
Route::patch('citas/{cita}/estado', [App\Http\Controllers\CitaController::class, 'updateStatus'])->name('admin.citas.updateStatus');



//rutas para servicios
Route::get('/admin/servicios', [App\Http\Controllers\ServicioController::class, 'index'])->name('admin.servicios.index')->middleware('auth');
Route::get('/admin/servicios/create', [App\Http\Controllers\ServicioController::class, 'create'])->name('admin.servicios.create')->middleware('auth');
Route::post('/admin/servicios/create', [App\Http\Controllers\ServicioController::class, 'store'])->name('admin.servicios.store')->middleware('auth');
Route::get('/admin/servicios/{id}', [App\Http\Controllers\ServicioController::class, 'show'])->name('admin.servicios.show')->middleware('auth');
Route::get('/admin/servicios/{id}/edit', [App\Http\Controllers\ServicioController::class, 'edit'])->name('admin.servicios.edit')->middleware('auth');
Route::put('/admin/servicios/{id}', [App\Http\Controllers\ServicioController::class, 'update'])->name('admin.servicios.update')->middleware('auth');
Route::delete('/admin/servicios/{id}', [App\Http\Controllers\ServicioController::class, 'destroy'])->name('admin.servicios.destroy')->middleware('auth');

//rutas para horarios
Route::get('/admin/horarios', [App\Http\Controllers\HorarioController::class, 'index'])->name('admin.horarios.index')->middleware('auth');
Route::get('/admin/horarios/create', [App\Http\Controllers\HorarioController::class, 'create'])->name('admin.horarios.create')->middleware('auth');
Route::post('/admin/horarios/create', [App\Http\Controllers\HorarioController::class, 'store'])->name('admin.horarios.store')->middleware('auth');
Route::get('/admin/horarios/{id}', [App\Http\Controllers\HorarioController::class, 'show'])->name('admin.horarios.show')->middleware('auth');
Route::get('/admin/horarios/{id}/edit', [App\Http\Controllers\HorarioController::class, 'edit'])->name('admin.horarios.edit')->middleware('auth');
Route::put('/admin/horarios/{id}', [App\Http\Controllers\HorarioController::class, 'update'])->name('admin.horarios.update')->middleware('auth');
Route::delete('/admin/horarios/{id}', [App\Http\Controllers\HorarioController::class, 'destroy'])->name('admin.horarios.destroy')->middleware('auth');

// Horarios disponibles para citas (AJAX)
Route::get('/admin/citas/horarios-disponibles', [App\Http\Controllers\CitaController::class, 'horariosDisponibles'])->name('admin.citas.horarios');

//rutas historial medico
Route::get('/admin/historialesmedicos', [App\Http\Controllers\HistorialMedicoController::class, 'index'])->name('admin.historialmedico.index')->middleware('auth');
Route::get('/admin/historialesmedicos/create', [App\Http\Controllers\HistorialMedicoController::class, 'create'])->name('admin.historialmedico.create')->middleware('auth');
Route::post('/admin/historialesmedicos/create', [App\Http\Controllers\HistorialMedicoController::class, 'store'])->name('admin.historialmedico.store')->middleware('auth');
Route::get('/admin/historialesmedicos/{id}', [App\Http\Controllers\HistorialMedicoController::class, 'show'])->name('admin.historialmedico.show')->middleware('auth');
Route::get('/admin/historialesmedicos/{id}/edit', [App\Http\Controllers\HistorialMedicoController::class, 'edit'])->name('admin.historialmedico.edit')->middleware('auth');
Route::put('/admin/historialesmedicos/{id}', [App\Http\Controllers\HistorialMedicoController::class, 'update'])->name('admin.historialmedico.update')->middleware('auth');
Route::delete('/admin/historialesmedicos/{id}', [App\Http\Controllers\HistorialMedicoController::class, 'destroy'])->name('admin.historialmedico.destroy')->middleware('auth');

// Descargar archivo adjunto
Route::get('/admin/historialesmedicos/{id}/download', [App\Http\Controllers\HistorialMedicoController::class, 'download'])->name('admin.historialmedico.download')->middleware('auth');

// Descargar PDF del historial
Route::get('/admin/historialesmedicos/{id}/pdf', [App\Http\Controllers\HistorialMedicoController::class, 'pdf'])->name('admin.historialesmedicos.pdf')->middleware('auth');

//rutas para prescrcripciones
Route::get('/admin/prescripciones', [App\Http\Controllers\PrescripcionController::class, 'index'])->name('admin.prescripciones.index')->middleware('auth');
Route::get('/admin/prescripciones/create', [App\Http\Controllers\PrescripcionController::class, 'create'])->name('admin.prescripciones.create')->middleware('auth');
Route::post('/admin/prescripciones/create', [App\Http\Controllers\PrescripcionController::class, 'store'])->name('admin.prescripciones.store')->middleware('auth');
Route::get('/admin/prescripciones/{id}', [App\Http\Controllers\PrescripcionController::class, 'show'])->name('admin.prescripciones.show')->middleware('auth');
Route::get('/admin/prescripciones/{id}/edit', [App\Http\Controllers\PrescripcionController::class, 'edit'])->name('admin.prescripciones.edit')->middleware('auth');
Route::put('/admin/prescripciones/{id}', [App\Http\Controllers\PrescripcionController::class, 'update'])->name('admin.prescripciones.update')->middleware('auth');
Route::delete('/admin/prescripciones/{id}', [App\Http\Controllers\PrescripcionController::class, 'destroy'])->name('admin.prescripciones.destroy')->middleware('auth');

// Generar PDF de prescripción
Route::get('/admin/prescripciones/{id}/pdf', [App\Http\Controllers\PrescripcionController::class, 'pdf'])->name('admin.prescripciones.pdf')->middleware('auth');


//rutas para la parte publica paginas
Route::get('/', function () { return view('welcome'); })->name('inicio');
Route::get('/nosotros', [App\Http\Controllers\PaginasController::class, 'nosotros'])->name('nosotros');
Route::get('/servicios', [App\Http\Controllers\PaginasController::class, 'servicios'])->name('servicios');
Route::get('/contactos', function () { return view('paginas.contactos'); })->name('contactos');


// Rutas para usuario front
Route::prefix('usuario')->middleware(['auth', 'role:Usuario|Paciente'])->group(function () {

    // Index del portal usuario
    Route::get('/', [App\Http\Controllers\UsuarioFrontController::class, 'index'])->name('usuario.index');
    
    // Mostrar formulario de edición de perfil
    Route::get('/perfil/editar', [App\Http\Controllers\UsuarioFrontController::class, 'editarPerfil'])->name('usuario.perfil.editar');
    
    // Guardar cambios en perfil y crear paciente si no existe
    Route::post('/perfil', [App\Http\Controllers\UsuarioFrontController::class, 'guardarPerfil'])->name('usuario.perfil.guardar');
    
    // Citas
    Route::get('/citas', [App\Http\Controllers\UsuarioFrontController::class,'misCitas'])->name('usuario.citas');
    Route::get('/citas/crear', [App\Http\Controllers\UsuarioFrontController::class,'crearCita'])->name('usuario.citas.crear');
    Route::post('/citas/crear', [App\Http\Controllers\UsuarioFrontController::class,'guardarCita'])->name('usuario.citas.guardar');
    
    // API: obtener horarios disponibles por odontólogo
    Route::get('/api/odontologos/{odontologo}/horarios-disponibles', [App\Http\Controllers\UsuarioFrontController::class,'horariosDisponibles']);
    Route::get('/citas/{cita}', [App\Http\Controllers\UsuarioFrontController::class, 'mostrarCita'])->name('usuario.citas.show');

    Route::get('prescripciones', [App\Http\Controllers\UsuarioFrontController::class, 'prescripciones'])
        ->name('usuario.prescripciones.index');

    Route::get('prescripciones/{prescripcion}/pdf', [App\Http\Controllers\UsuarioFrontController::class, 'descargarPrescripcion'])
        ->name('usuario.prescripciones.pdf');


});


// 🦷 Rutas para Odontólogo Front
Route::prefix('odontologo')->middleware(['auth', 'role:Odontologo'])->group(function () {

    // 📊 Dashboard principal
    Route::get('/', [App\Http\Controllers\OdontologoFrontController::class, 'index'])
        ->name('odontologo.index');

    // 👤 Perfil del odontólogo
    Route::get('/perfil', [App\Http\Controllers\OdontologoFrontController::class, 'perfil'])
        ->name('odontologo.perfil');
    Route::post('/perfil', [App\Http\Controllers\OdontologoFrontController::class, 'actualizarPerfil'])
        ->name('odontologo.perfil.guardar');

    // 🕒 Horarios
    Route::get('/horarios', [App\Http\Controllers\OdontologoFrontController::class, 'horarios'])
        ->name('odontologo.horarios');
    Route::get('/horarios/crear', [App\Http\Controllers\OdontologoFrontController::class, 'create'])
        ->name('odontologo.horarios.create');
    Route::post('/horarios', [App\Http\Controllers\OdontologoFrontController::class, 'guardarHorarios'])
        ->name('odontologo.horarios.guardar');
    Route::get('/horarios/{id}/editar', [App\Http\Controllers\OdontologoFrontController::class, 'edit'])
        ->name('odontologo.horarios.edit');
    Route::put('/horarios/{id}', [App\Http\Controllers\OdontologoFrontController::class, 'update'])
        ->name('odontologo.horarios.update');
    Route::delete('/horarios/{id}', [App\Http\Controllers\OdontologoFrontController::class, 'destroy'])
        ->name('odontologo.horarios.delete');

    // 🎓 Formaciones
    Route::get('/formaciones', [App\Http\Controllers\OdontologoFormacionController::class, 'index'])
        ->name('formaciones.index');
    Route::post('/formaciones', [App\Http\Controllers\OdontologoFormacionController::class, 'store'])
        ->name('odontologo.formaciones.store');
    Route::delete('/formaciones/{id}', [App\Http\Controllers\OdontologoFormacionController::class, 'destroy'])
        ->name('odontologo.formaciones.destroy');

        // ======================
    // 🗓 Citas Odontólogo
    // ======================
    Route::get('/citas', [App\Http\Controllers\Odontologo\CitaController::class, 'index'])->name('odontologo.citas.index');
    Route::get('/citas/crear', [App\Http\Controllers\Odontologo\CitaController::class, 'create'])->name('odontologo.citas.create');
    Route::post('/citas', [App\Http\Controllers\Odontologo\CitaController::class, 'store'])->name('odontologo.citas.store');
    Route::get('/citas/{id}/editar', [App\Http\Controllers\Odontologo\CitaController::class, 'edit'])->name('odontologo.citas.edit');
    Route::put('/citas/{id}', [App\Http\Controllers\Odontologo\CitaController::class, 'update'])->name('odontologo.citas.update');
    Route::delete('/citas/{id}', [App\Http\Controllers\Odontologo\CitaController::class, 'destroy'])->name('odontologo.citas.destroy');
    Route::get('/citas/calendario/json', [App\Http\Controllers\Odontologo\CitaController::class, 'calendarioJson'])->name('odontologo.citas.calendario.json');
    // Mostrar detalles de una cita
Route::get('/citas/{id}', [App\Http\Controllers\Odontologo\CitaController::class, 'show'])
    ->name('odontologo.citas.show');

    //Pacientes Odontólogo
    Route::get('/pacientes', [App\Http\Controllers\Odontologo\PacienteController::class, 'index'])->name('odontologo.pacientes.index');
    Route::get('/pacientes/crear', [App\Http\Controllers\Odontologo\PacienteController::class, 'create'])->name('odontologo.pacientes.create');
    Route::post('/pacientes', [App\Http\Controllers\Odontologo\PacienteController::class, 'store'])->name('odontologo.pacientes.store');
    Route::get('/pacientes/{id}', [App\Http\Controllers\Odontologo\PacienteController::class, 'show'])->name('odontologo.pacientes.show');
    Route::get('/pacientes/{id}/editar', [App\Http\Controllers\Odontologo\PacienteController::class, 'edit'])->name('odontologo.pacientes.edit');
    Route::put('/pacientes/{id}', [App\Http\Controllers\Odontologo\PacienteController::class, 'update'])->name('odontologo.pacientes.update');
    Route::delete('/pacientes/{id}', [App\Http\Controllers\Odontologo\PacienteController::class, 'destroy'])->name('odontologo.pacientes.destroy');
    // Ruta para buscar pacientes con AJAX
Route::get('/odontologo/pacientes/buscar', [App\Http\Controllers\Odontologo\PacienteController::class, 'buscar'])->name('pacientes.buscar');


    //Servicios Odontólogo
    Route::get('/servicios', [App\Http\Controllers\Odontologo\ServicioController::class, 'index'])->name('odontologo.servicios.index');
    Route::get('/servicios/crear', [App\Http\Controllers\Odontologo\ServicioController::class, 'create'])->name('odontologo.servicios.create');
    Route::post('/servicios', [App\Http\Controllers\Odontologo\ServicioController::class, 'store'])->name('odontologo.servicios.store');
    Route::get('/servicios/{id}', [App\Http\Controllers\Odontologo\ServicioController::class, 'show'])->name('odontologo.servicios.show');
    Route::get('/servicios/{id}/editar', [App\Http\Controllers\Odontologo\ServicioController::class, 'edit'])->name('odontologo.servicios.edit');
    Route::put('/servicios/{id}', [App\Http\Controllers\Odontologo\ServicioController::class, 'update'])->name('odontologo.servicios.update');
    Route::delete('/servicios/{id}', [App\Http\Controllers\Odontologo\ServicioController::class, 'destroy'])->name('odontologo.servicios.destroy');


// Historiales Médicos Odontólogo
Route::get('/historialesmedicos', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'index'])->name('odontologo.historialesmedicos.index');
Route::get('/historialesmedicos/crear', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'create'])->name('odontologo.historialesmedicos.create');
Route::post('/historialesmedicos', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'store'])->name('odontologo.historialesmedicos.store');
Route::get('/historialesmedicos/{id}', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'show'])->name('odontologo.historialesmedicos.show');
Route::get('/historialesmedicos/{id}/editar', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'edit'])->name('odontologo.historialesmedicos.edit');
Route::put('/historialesmedicos/{id}', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'update'])->name('odontologo.historialesmedicos.update');
Route::delete('/historialesmedicos/{id}', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'destroy'])->name('odontologo.historialesmedicos.destroy');
Route::get('/historialesmedicos/{id}/pdf', [App\Http\Controllers\Odontologo\HistorialMedicoController::class, 'descargarPdf'])
     ->name('odontologo.historialesmedicos.pdf');

// Medicamentos Odontólogo
Route::get('/medicamentos', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'index'])->name('odontologo.medicamentos.index');
Route::get('/medicamentos/crear', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'create'])->name('odontologo.medicamentos.create');
Route::post('/medicamentos', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'store'])->name('odontologo.medicamentos.store');
Route::get('/medicamentos/{id}', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'show'])->name('odontologo.medicamentos.show');
Route::get('/medicamentos/{id}/editar', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'edit'])->name('odontologo.medicamentos.edit');
Route::put('/medicamentos/{id}', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'update'])->name('odontologo.medicamentos.update');
Route::delete('/medicamentos/{id}', [App\Http\Controllers\Odontologo\MedicamentoController::class, 'destroy'])->name('odontologo.medicamentos.destroy');

// Prescripciones Odontólogo
Route::get('/prescripciones', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'index'])->name('odontologo.prescripciones.index');
Route::get('/prescripciones/crear', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'create'])->name('odontologo.prescripciones.create');
Route::post('/prescripciones', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'store'])->name('odontologo.prescripciones.store');
Route::get('/prescripciones/{id}', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'show'])->name('odontologo.prescripciones.show');
Route::get('/prescripciones/{id}/editar', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'edit'])->name('odontologo.prescripciones.edit');
Route::put('/prescripciones/{id}', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'update'])->name('odontologo.prescripciones.update');
Route::delete('/prescripciones/{id}', [App\Http\Controllers\Odontologo\PrescripcionController::class, 'destroy'])->name('odontologo.prescripciones.destroy');

// =========================
    // RUTAS DE REPORTES
    // =========================
    Route::prefix('reportes')->group(function () {
        Route::get('/', [App\Http\Controllers\Odontologo\ReporteController::class, 'index'])
            ->name('odontologo.reportes.index');
        Route::get('/pacientes', [App\Http\Controllers\Odontologo\ReporteController::class, 'pacientes'])
            ->name('odontologo.reportes.pacientes');
            // ya dentro del Route::prefix('reportes')->group(function () { ... });
        Route::get('/pacientes/pdf', [App\Http\Controllers\Odontologo\ReporteController::class, 'pacientesPdf'])
            ->name('odontologo.reportes.pacientes.pdf');

        Route::get('/citas', [App\Http\Controllers\Odontologo\ReporteController::class, 'citas'])
            ->name('odontologo.reportes.citas');
            // Ruta para exportar PDF de citas
        Route::get('/citas/pdf', [App\Http\Controllers\Odontologo\ReporteController::class, 'citasPdf'])
            ->name('odontologo.reportes.citas.pdf');

        Route::get('/horarios', [App\Http\Controllers\Odontologo\ReporteController::class, 'horarios'])
            ->name('odontologo.reportes.horarios');
            
        Route::get('/horarios/pdf', [App\Http\Controllers\Odontologo\ReporteController::class, 'horariosPdf'])
            ->name('odontologo.reportes.horarios.pdf');

        Route::get('/servicios', [App\Http\Controllers\Odontologo\ReporteController::class, 'servicios'])
            ->name('odontologo.reportes.servicios');
        Route::get('/servicios/pdf', [App\Http\Controllers\Odontologo\ReporteController::class, 'serviciosPdf'])
        ->name('odontologo.reportes.servicios.pdf');
        
        Route::get('/historialesmedicos', [App\Http\Controllers\Odontologo\ReporteController::class, 'historialesMedicos'])
            ->name('odontologo.reportes.historialesmedicos');
        Route::get('/historialesmedicos/pdf', [App\Http\Controllers\Odontologo\ReporteController::class, 'historialesMedicosPdf'])
            ->name('odontologo.reportes.historialesmedicos.pdf');

        Route::get('/medicamentos', [App\Http\Controllers\Odontologo\ReporteController::class, 'medicamentos'])
            ->name('odontologo.reportes.medicamentos');
        Route::get('/medicamentos/pdf', [App\Http\Controllers\Odontologo\ReporteController::class, 'medicamentosPdf'])
            ->name('odontologo.reportes.medicamentos.pdf');
    });



});

// Ruta API para obtener todos los horarios (para uso interno o AJAX)
Route::get('/horarios', [App\Http\Controllers\HorarioController::class, 'apiHorarios']);

//API GOGOLE LOGIN
Route::get('auth/google', function () {
    return Socialite::driver('google')->redirect();
})->name('google.login');



// Ruta: auth/google/callback
Route::get('auth/google/callback', function () {
    try {
        $googleUser = Socialite::driver('google')->user();

        // Buscar si el usuario ya existe en la base de datos
        $user = User::where('email', $googleUser->getEmail())->first();

        // Si no existe, crearlo automáticamente como Usuario
        if (!$user) {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password' => bcrypt(uniqid()), // contraseña aleatoria
            ]);

            // Asignar rol Usuario, no Paciente todavía
            $user->assignRole('Usuario');
        }

        // Iniciar sesión del usuario
        Auth::login($user);

        // Redirigir según rol
        if ($user->hasRole('Usuario')) {
            return redirect()->route('usuario.index'); // Portal front usuario
        }

        if ($user->hasRole('Paciente')) {
            return redirect()->route('usuario.index'); // Front panel paciente
        }

        if ($user->hasRole('Odontologo')) {
            return redirect()->route('odontologo.index'); // Panel odontólogo
        }

        if ($user->hasRole('Administrador')) {
            return redirect()->route('admin.dashboard'); // Panel admin
        }

        // Rol por defecto
        return redirect()->route('usuario.index');

    } catch (Exception $e) {
        return redirect('/login')->with('error', 'Error al iniciar sesión con Google.');
    }
});


















