<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Paciente;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


 public function horariosDisponibles($odontologoId)
    {
         $horarios = Horario::where('odontologo_id', $odontologoId)
        ->where('disponible', true)
        ->whereDoesntHave('citas')
        ->orderBy('fecha')
        ->orderBy('hora_inicio')
        ->get(['id', 'fecha', 'hora_inicio', 'hora_fin']); // agregamos fecha

    $horarios->transform(function($h) {
        $fecha = Carbon::parse($h->fecha);
        $h->dia = ucfirst($fecha->translatedFormat('l')); // lunes, martes, etc.
        $h->fecha_formateada = $fecha->format('d/m/Y');
        return $h;
    });

    return response()->json($horarios);
    }


    // Mostrar detalles de una cita específica
    public function mostrarCita($id)
    {
    $user = Auth::user();
    $cita = $user->paciente->citas()->with('odontologo', 'servicio', 'horario')->findOrFail($id);

    return view('front.usuario.citas.show', compact('cita'));
    }


    // Listar todas las citas del usuario
    public function misCitas()
    {
    $user = Auth::user();

    // Tomamos solo las citas activas del paciente
    $citas = $user->paciente->citas()->with(['servicio', 'odontologo', 'horario'])->get();

    // Transformamos para FullCalendar
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

    return view('front.usuario.citas.index', compact('user','events'));
    }




    
}
