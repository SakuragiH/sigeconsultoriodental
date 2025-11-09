<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Prescripcion;


class UsuarioFrontController extends Controller
{

    // Página principal del usuario
    public function index()
    {
        $user = Auth::user(); // Obtiene el usuario logueado
        return view('front.usuario.index', compact('user')); // Pasa $user a la vista
    }


    // Mostrar formulario de edición de perfil
    public function editarPerfil()
    {
        $user = Auth::user();
        return view('front.usuario.edit', compact('user'));
    }

    // Guardar cambios en el perfil del paciente
public function guardarPerfil(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'ci' => 'required|string|max:20|unique:pacientes,ci,' . ($user->paciente->id ?? 'NULL'),
        'fecha_nacimiento' => 'required|date',
        'telefono' => 'required|string|max:20',
        'direccion' => 'required|string|max:255',
        'genero' => 'required|in:Masculino,Femenino,Otro',
        'foto' => 'nullable|image|max:2048',
    ]);

    if ($user->paciente) {
        $paciente = $user->paciente;
        $paciente->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
        ]);
    } else {
        $paciente = \App\Models\Paciente::create([
            'usuario_id' => $user->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
            'foto' => '',
        ]);
    }

    // Subida de foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/pacientes', $filename);
        $paciente->foto = $filename;
        $paciente->save();
    }

    return redirect()->route('usuario.index')
                 ->with('success', 'Perfil actualizado correctamente.');

}


    // Guardar cambios en perfil / registrar paciente
    public function guardarCita(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'ci' => 'required|string|max:20|unique:pacientes,ci,' . ($user->paciente->id ?? 'NULL'),
        'fecha_nacimiento' => 'required|date',
        'telefono' => 'required|string|max:20',
        'direccion' => 'required|string|max:255',
        'genero' => 'required|in:Masculino,Femenino,Otro',
        'foto' => 'nullable|image|max:2048',
        'servicio_id' => 'required|exists:servicios,id',
        'odontologo_id' => 'required|exists:odontologos,id',
        'horario_id' => 'required|exists:horarios,id',
        'motivo' => 'nullable|string',
        'observaciones' => 'nullable|string',
    ]);

    // ✅ Validar que el horario no esté ocupado
    $existe = \App\Models\Cita::where('odontologo_id', $request->odontologo_id)
        ->where('horario_id', $request->horario_id)
        ->where('estado', '!=', 'Cancelada') // cuenta solo las citas activas
        ->exists();

    if ($existe) {
        return back()
            ->withInput()
            ->withErrors(['horario_id' => 'Este horario ya está ocupado para este odontólogo.']);
    }

    // ========== CREAR/ACTUALIZAR PACIENTE (igual que antes) ==========
    if ($user->paciente) {
        $paciente = $user->paciente;
        $paciente->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
        ]);
    } else {
        $paciente = \App\Models\Paciente::create([
            'usuario_id' => $user->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
            'foto' => '',
        ]);
    }

    // Foto
    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/pacientes', $filename);
        $paciente->foto = $filename;
        $paciente->save();
    }

   // ================== CREAR LA CITA ==================
    $cita = \App\Models\Cita::create([
        'paciente_id' => $paciente->id,
        'odontologo_id' => $request->odontologo_id,
        'servicio_id' => $request->servicio_id,
        'horario_id' => $request->horario_id,
        'motivo' => $request->motivo,
        'observaciones' => $request->observaciones,
        'estado' => 'Pendiente',
    ]);

   return redirect()->route('usuario.citas')
                 ->with('success', 'Cita agendada correctamente.');



}


public function crearCita()
{
    $user = Auth::user();
    $servicios = \App\Models\Servicio::all();
    $odontologos = \App\Models\Odontologo::with('horarios')->get(); // Trae los horarios de cada odontólogo

    return view('front.usuario.citas.create', compact('user','servicios','odontologos'));
}


    public function horariosDisponibles(Request $request, $odontologoId)
    {
        $hoy = Carbon::today();
    $filtro = $request->get('filtro', 'semana_actual');

    switch($filtro) {
        case 'hoy':
            $fechaInicio = $hoy;
            $fechaFin = $hoy;
            break;
        case 'manana':
            $fechaInicio = $hoy->copy()->addDay();
            $fechaFin = $fechaInicio;
            break;
        case 'semana_actual':
            $fechaInicio = $hoy->copy()->startOfWeek();
            $fechaFin = $hoy->copy()->endOfWeek();
            break;
        case 'semana_siguiente':
            $fechaInicio = $hoy->copy()->addWeek()->startOfWeek();
            $fechaFin = $hoy->copy()->addWeek()->endOfWeek();
            break;
        case 'este_mes':
            $fechaInicio = $hoy->copy()->startOfMonth();
            $fechaFin = $hoy->copy()->endOfMonth();
            break;
        case 'proximo_mes':
            $fechaInicio = $hoy->copy()->addMonth()->startOfMonth();
            $fechaFin = $hoy->copy()->addMonth()->endOfMonth();
            break;
        default:
            $fechaInicio = $hoy;
            $fechaFin = $hoy->copy()->addWeeks(2);
    }

    $horarios = Horario::where('odontologo_id', $odontologoId)
        ->where('disponible', true)
        ->whereBetween('fecha', [$fechaInicio, $fechaFin])
        ->whereDoesntHave('citas')
        ->orderBy('fecha')
        ->orderBy('hora_inicio')
        ->get();

    $agrupados = $horarios->groupBy('fecha')->map(function ($bloques, $fecha) {
        $fechaCarbon = Carbon::parse($fecha);
        return [
            'fecha' => $fechaCarbon->format('d/m/Y'),
            'dia' => ucfirst($fechaCarbon->translatedFormat('l')),
            'bloques' => $bloques->map(function ($h) {
                return [
                    'id' => $h->id,
                    'hora_inicio' => Carbon::parse($h->hora_inicio)->format('h:i A'),
                    'hora_fin' => Carbon::parse($h->hora_fin)->format('h:i A')
                ];
            })

        ];
    })->values();

    return response()->json($agrupados);
    }


    // Listar todas las citas del usuario
    public function misCitas()
    {
     $user = Auth::user();

    // Si el usuario aún no es paciente
    if (!$user->paciente) {
        $events = collect(); // calendario vacío
        $noPaciente = true;
    } else {
        $citas = $user->paciente->citas()->with(['servicio', 'odontologo', 'horario'])->get();
        $events = $citas->map(function($cita){
            return [
                'title' => $cita->servicio->nombre ?? 'Cita',
                'start' => $cita->horario->fecha . 'T' . $cita->horario->hora_inicio,
                'end'   => $cita->horario->fecha . 'T' . $cita->horario->hora_fin,
                'color' => $cita->estado == 'Pendiente' ? 'orange' : ($cita->estado == 'Confirmada' ? 'green' : 'red'),
                'extendedProps' => [
                    'odontologo' => $cita->odontologo->nombres . ' ' . $cita->odontologo->apellidos,
                    'motivo' => $cita->motivo,
                    'observaciones' => $cita->observaciones,
                ]
            ];
        });
        $noPaciente = false;
    }

    return view('front.usuario.citas.index', compact('user', 'events', 'noPaciente'));
    }

    /**
     * Mostrar las prescripciones del paciente logueado
     */
    public function prescripciones()
    {
        $user = Auth::user();
    $paciente = $user->paciente;

    if (!$paciente) {
        $prescripciones = collect();
        $info = 'No se encontraron prescripciones porque aún no eres paciente.';
        return view('front.usuario.prescripciones.index', compact('prescripciones', 'info'));
    }

    // Obtener todas las prescripciones a través de los historiales médicos
    $prescripciones = $paciente->historialesMedicos()
        ->with('prescripciones.medicamento')
        ->get()
        ->pluck('prescripciones')
        ->flatten();

    if ($prescripciones->isEmpty()) {
        $info = 'Aún no tienes prescripciones.';
        return view('front.usuario.prescripciones.index', compact('prescripciones', 'info'));
    }

    return view('front.usuario.prescripciones.index', compact('prescripciones'));
    }

    /**
     * Descargar prescripción en PDF
     */
    public function descargarPrescripcion(Prescripcion $prescripcion)
    {
         $user = Auth::user();
    $paciente = $user->paciente;

    if (!$paciente) {
        abort(403, 'No tienes permiso para descargar esta prescripción.');
    }

    // Cargar IDs de historiales médicos del paciente
    $historialesIds = $paciente->historialesMedicos()->pluck('id');

    if (!$historialesIds->contains($prescripcion->historial_id)) {
        abort(403, 'No tienes permiso para descargar esta prescripción.');
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('front.usuario.prescripciones.pdf', compact('prescripcion'));
    return $pdf->download("Prescripcion_{$prescripcion->id}.pdf");
    }



    
}
