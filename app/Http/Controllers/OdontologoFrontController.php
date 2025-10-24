<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Servicio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OdontologoFrontController extends Controller
{
    // Dashboard principal del odontólogo
    public function index()
    {
        $user = Auth::user(); // Obtiene el odontólogo logueado
        return view('front.odontologo.index', compact('user'));

    }

    // Perfil del odontólogo
    public function perfil()
    {
        $odontologo = Auth::user()->odontologo;

        // Verificamos que exista el odontólogo asociado al usuario
        if (!$odontologo) {
            return redirect()->back()->with('error', 'No se encontró información del odontólogo.');
        }

        // Traemos las formaciones del odontólogo
        $formaciones = \App\Models\OdontologoFormacion::where('odontologo_id', $odontologo->id)->get();

        // Enviamos ambos a la vista
        return view('front.odontologo.perfil', compact('odontologo', 'formaciones'));
    }

    /**
     * Actualizar perfil del odontólogo.
     */
    public function actualizarPerfil(Request $request)
    {
        $odontologo = Auth::user()->odontologo;

    $request->validate([
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'telefono' => 'nullable|string|max:20',
        'direccion' => 'nullable|string|max:255',
        'especialidad' => 'nullable|string|max:255',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $odontologo->nombres = $request->nombres;
    $odontologo->apellidos = $request->apellidos;
    $odontologo->telefono = $request->telefono;
    $odontologo->direccion = $request->direccion;
    $odontologo->especialidad = $request->especialidad;

    // Subir foto si existe
if ($request->hasFile('foto')) {
    $archivo = $request->file('foto');
    $nombreArchivo = time().'_'.$archivo->getClientOriginalName();

    // Eliminar foto anterior si existe
    if ($odontologo->foto && Storage::exists('public/odontologos/'.$odontologo->foto)) {
        Storage::delete('public/odontologos/'.$odontologo->foto);
    }

    // Guardar nueva foto en storage/app/public/odontologos
    $archivo->storeAs('public/odontologos', $nombreArchivo);

    // Guardamos solo el nombre del archivo en la BD
    $odontologo->foto = $nombreArchivo;
}


    $odontologo->save();

    return redirect()->route('odontologo.perfil')->with('success', 'Perfil actualizado correctamente');
    }

    // Horarios de atención
    public function horarios()
    {
        $odontologoId = Auth::user()->odontologo->id;
        $horarios = Horario::where('odontologo_id', $odontologoId)
                            ->orderBy('fecha')
                            ->orderBy('hora_inicio')
                            ->get();

        return view('front.odontologo.horarios.index', compact('horarios'));
    }

    // Mostrar formulario para crear horario
    public function create()
    {
        return view('front.odontologo.horarios.create');
    }

    public function guardarHorarios(Request $request)
    {
          $request->validate([
        'fecha' => 'required|date',
        'hora_inicio' => 'required',
        'hora_fin' => 'required|after:hora_inicio',
    ]);

    $odontologo_id = Auth::user()->odontologo->id;

    $horaInicio = Carbon::parse($request->hora_inicio);
    $horaFin = Carbon::parse($request->hora_fin);

    // Evitar duplicados en toda la franja
    $existe = Horario::where('odontologo_id', $odontologo_id)
        ->where('fecha', $request->fecha)
        ->where(function($q) use ($horaInicio, $horaFin) {
            $q->whereBetween('hora_inicio', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
              ->orWhereBetween('hora_fin', [$horaInicio->format('H:i'), $horaFin->format('H:i')]);
        })->exists();

    if ($existe) {
        return redirect()->back()->with('error', 'Ya existe un horario en ese rango de tiempo.');
    }

    // Crear bloques de 1 hora
    $current = $horaInicio;
    while ($current->lt($horaFin)) {
        $endBlock = $current->copy()->addHour();
        if ($endBlock->gt($horaFin)) {
            $endBlock = $horaFin->copy();
        }

        Horario::create([
            'odontologo_id' => $odontologo_id,
            'dia' => Carbon::parse($request->fecha)->locale('es')->dayName,
            'fecha' => $request->fecha,
            'hora_inicio' => $current->format('H:i'),
            'hora_fin' => $endBlock->format('H:i'),
            'disponible' => true,
        ]);

        $current->addHour();
    }

    return redirect()->route('odontologo.horarios')->with('success', 'Horario creado correctamente.');
    }

     // Mostrar formulario para editar
    public function edit($id)
    {
        $horario = Horario::findOrFail($id);
        return view('front.odontologo.horarios.edit', compact('horario'));
    }

    // Actualizar horario
    public function update(Request $request, $id)
    {
         $request->validate([
        'fecha' => 'required|date',
        'hora_inicio' => 'required',
        'hora_fin' => 'required|after:hora_inicio',
    ]);

    $horario = Horario::findOrFail($id);
    $odontologo_id = $horario->odontologo_id;

    $horaInicio = Carbon::parse($request->hora_inicio);
    $horaFin = Carbon::parse($request->hora_fin);

    // Evitar duplicados al actualizar (excepto el horario actual)
    $existe = Horario::where('odontologo_id', $odontologo_id)
        ->where('fecha', $request->fecha)
        ->where('id', '!=', $id)
        ->where(function($q) use ($horaInicio, $horaFin) {
            $q->whereBetween('hora_inicio', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
              ->orWhereBetween('hora_fin', [$horaInicio->format('H:i'), $horaFin->format('H:i')]);
        })->exists();

    if ($existe) {
        return redirect()->back()->with('error', 'Ya existe un horario en ese rango de tiempo.');
    }

    // Eliminar solo los bloques libres existentes de este horario
    Horario::where('odontologo_id', $odontologo_id)
           ->where('fecha', $horario->fecha)
           ->where('disponible', true)
           ->delete();

    // Crear nuevos bloques de 1 hora según el rango nuevo
    $current = $horaInicio;
    while ($current->lt($horaFin)) {
        $endBlock = $current->copy()->addHour();
        if ($endBlock->gt($horaFin)) {
            $endBlock = $horaFin->copy();
        }

        // Verificamos si ya existe un bloque reservado para esa hora
        $existeBloque = Horario::where('odontologo_id', $odontologo_id)
            ->where('fecha', $request->fecha)
            ->where('hora_inicio', $current->format('H:i'))
            ->where('hora_fin', $endBlock->format('H:i'))
            ->exists();

        if (!$existeBloque) {
            Horario::create([
                'odontologo_id' => $odontologo_id,
                'dia' => Carbon::parse($request->fecha)->locale('es')->dayName,
                'fecha' => $request->fecha,
                'hora_inicio' => $current->format('H:i'),
                'hora_fin' => $endBlock->format('H:i'),
                'disponible' => true,
            ]);
        }

        $current->addHour();
    }

    return redirect()->route('odontologo.horarios')->with('success', 'Horario actualizado correctamente.');
    }

    // Eliminar horario
    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);

    // Verificamos si el bloque tiene cita reservada
    if (!$horario->disponible) {
        return redirect()
        ->route('odontologo.horarios')
        ->with('error', 'No se puede eliminar este bloque porque ya tiene una cita reservada.');
    }

    $horario->delete();

    return redirect()
    ->route('odontologo.horarios')
    ->with('success', 'Bloque de horario eliminado correctamente.');
    }


    public function calendario()
{
    $user = Auth::user();

    // Traemos los horarios del odontólogo
    $horarios = Horario::where('odontologo_id', $user->id)
                        ->with('cita') // si quieres mostrar citas reservadas
                        ->get();

    $events = $horarios->map(function($h){
        return [
            'title' => $h->disponible ? 'Disponible' : ($h->cita->paciente->nombres ?? 'Reservado'),
            'start' => $h->fecha . 'T' . $h->hora_inicio,
            'end'   => $h->fecha . 'T' . $h->hora_fin,
            'color' => $h->disponible ? 'green' : 'red',
            'extendedProps' => [
                'paciente' => $h->cita->paciente->nombres ?? '',
                'servicio' => $h->cita->servicio->nombre ?? '',
            ]
        ];
    });

    return view('front.odontologo.index', compact('user','events'));
}

    

}
