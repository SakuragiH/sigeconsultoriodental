<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Horario;
use App\Models\Paciente;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    /**
 * Listado de citas del odontólogo logueado
 */
public function index()
{
    $odontologoId = Auth::user()->odontologo->id;

    $citas = Cita::with(['paciente', 'servicio', 'horario'])
        ->where('odontologo_id', $odontologoId)
        ->orderBy('horario_id', 'asc')
        ->get();

    return view('front.odontologo.citas.index', compact('citas'));
}

// Mostrar formulario para crear nueva cita
    public function create()
    {
        $odontologoId = Auth::user()->odontologo->id;

    // Listado de pacientes ordenados alfabéticamente
    $pacientes = Paciente::orderBy('nombres')->get();

    // Listado de servicios ordenados alfabéticamente
    $servicios = Servicio::orderBy('nombre')->get();

    // Horarios disponibles del odontólogo
    $horarios = Horario::where('odontologo_id', $odontologoId)
        ->where('disponible', true)
        ->orderBy('fecha')
        ->orderBy('hora_inicio')
        ->get();

    return view('front.odontologo.citas.create', compact('pacientes', 'servicios', 'horarios'));
    }

    // Guardar nueva cita
    public function store(Request $request)
    {
        $request->validate([
        'paciente_id'  => 'required|exists:pacientes,id',
        'servicio_id'  => 'required|exists:servicios,id',
        'horario_id'   => 'required|exists:horarios,id',
        'motivo'       => 'nullable|string',
        'observaciones'=> 'nullable|string',
    ]);

    $odontologoId = Auth::user()->odontologo->id;
    $horario = Horario::findOrFail($request->horario_id);

    // Verificamos que el horario pertenezca al odontólogo y esté disponible
    if ($horario->odontologo_id != $odontologoId || !$horario->disponible) {
        return redirect()->back()->with('error', 'Horario inválido o ya reservado.');
    }

    // Creamos la cita
    $cita = Cita::create([
        'paciente_id'   => $request->paciente_id,
        'servicio_id'   => $request->servicio_id,
        'horario_id'    => $request->horario_id,
        'odontologo_id' => $odontologoId,
        'motivo'        => $request->motivo,
        'observaciones' => $request->observaciones,
        'estado'        => 'Pendiente',
    ]);

    // Marcamos el horario como ocupado
    $horario->update(['disponible' => false]);

    return redirect()->route('odontologo.citas.index')->with('success', 'Cita creada correctamente.');
    }

    // Mostrar formulario de edición de cita
    public function edit($id)
    {
        $odontologoId = Auth::user()->odontologo->id;
    $cita = Cita::findOrFail($id);

    // Verificamos que la cita pertenezca al odontólogo logueado
    if ($cita->odontologo_id != $odontologoId) {
        abort(403);
    }

    $pacientes = Paciente::orderBy('nombres')->get();
    $servicios = Servicio::orderBy('nombre')->get();

    // Horarios disponibles + el horario actual de la cita
    $horarios = Horario::where('odontologo_id', $odontologoId)
        ->where(function($q) use ($cita) {
            $q->where('disponible', true)
              ->orWhere('id', $cita->horario_id);
        })
        ->orderBy('fecha')
        ->orderBy('hora_inicio')
        ->get();

    return view('front.odontologo.citas.edit', compact('cita','pacientes','servicios','horarios'));

    }

    // Actualizar una cita existente
    public function update(Request $request, $id)
    {
        $request->validate([
        'paciente_id'   => 'required|exists:pacientes,id',
        'servicio_id'   => 'required|exists:servicios,id',
        'horario_id'    => 'required|exists:horarios,id',
        'motivo'        => 'nullable|string',
        'observaciones' => 'nullable|string',
        'estado'        => 'nullable|in:Pendiente,Confirmada,Cancelada,Realizada',
    ]);

    $odontologoId = Auth::user()->odontologo->id;
    $cita = Cita::findOrFail($id);

    if ($cita->odontologo_id != $odontologoId) {
        abort(403);
    }

    // Si se cambia de horario: liberar el anterior y ocupar el nuevo
    if ($cita->horario_id != $request->horario_id) {
        Horario::where('id', $cita->horario_id)->update(['disponible' => true]);
        Horario::where('id', $request->horario_id)->update(['disponible' => false]);
    }

    $horario = Horario::findOrFail($request->horario_id);

    $cita->update([
        'paciente_id'   => $request->paciente_id,
        'servicio_id'   => $request->servicio_id,
        'horario_id'    => $request->horario_id,
        'motivo'        => $request->motivo,
        'observaciones' => $request->observaciones,
        'fecha'         => $horario->fecha,
        'estado'        => $request->estado ?? $cita->estado,
    ]);

    return redirect()->route('odontologo.citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    // Eliminar una cita
    public function destroy($id)
    {
        $odontologoId = Auth::user()->odontologo->id;
    $cita = Cita::findOrFail($id);

    // Verificar que la cita pertenezca al odontólogo logueado
    if ($cita->odontologo_id != $odontologoId) {
        abort(403, 'No autorizado');
    }

    // Liberar el horario
    Horario::where('id', $cita->horario_id)->update(['disponible' => true]);

    // Eliminar la cita
    $cita->delete();

    return redirect()->route('odontologo.citas.index')
                     ->with('success', 'Cita eliminada correctamente.');
    }

    // Mostrar detalles de una cita
    public function show($id)
    {
        $odontologoId = Auth::user()->odontologo->id;

    // Buscamos la cita, incluyendo relaciones necesarias
    $cita = Cita::with('paciente', 'servicio', 'horario')->findOrFail($id);

    // Verificamos que la cita pertenezca al odontólogo logueado
    if ($cita->odontologo_id != $odontologoId) {
        abort(403, 'No tienes permiso para ver esta cita.');
    }

    return view('front.odontologo.citas.show', compact('cita'));
    }
}
