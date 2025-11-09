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
        $user = Auth::user();
$odontologoId = $user->odontologo->id;

$citas = Cita::with(['paciente', 'servicio', 'horario'])
    ->where('odontologo_id', $odontologoId)
    ->orderBy('horario_id', 'asc')
    ->get();

$events = $citas->map(function($cita) {
    return [
        'title' => $cita->servicio->nombre ?? 'Servicio',
        'start' => $cita->horario->fecha . 'T' . $cita->horario->hora_inicio,
        'end'   => $cita->horario->fecha . 'T' . $cita->horario->hora_fin,
        'extendedProps' => [
            'paciente' => $cita->paciente->nombres . ' ' . $cita->paciente->apellidos,
            'odontologo' => $cita->odontologo->nombres . ' ' . $cita->odontologo->apellidos,
            'motivo' => $cita->motivo ?? '',
            'observaciones' => $cita->observaciones ?? '',
            'estado' => $cita->estado,
        ],
    ];
});

return view('front.odontologo.index', compact('user', 'events', 'citas'));


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
         $horario = null; // Para que el blade no marque error
            return view('front.odontologo.horarios.create', compact('horario'));
    }


    // Guardar nuevo horario
    public function guardarHorarios(Request $request)
    {
          $request->validate([
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        'hora_inicio' => 'required',
        'hora_fin' => 'required|after:hora_inicio',
        'dias' => 'required|array|min:1',
    ]);

    $odontologo_id = Auth::user()->odontologo->id;

    $fechaInicio = Carbon::parse($request->fecha_inicio);
    $fechaFin = Carbon::parse($request->fecha_fin);
    $horaInicio = Carbon::parse($request->hora_inicio);
    $horaFin = Carbon::parse($request->hora_fin);

    // Generamos horarios por rango
    for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->addDay()) {
        $diaSemana = ucfirst($fecha->translatedFormat('l')); // Ej: Lunes, Martes...

        if (in_array($diaSemana, $request->dias)) {

            // Generar bloques de una hora
            $current = $horaInicio->copy();
            while ($current->lt($horaFin)) {
                $endBlock = $current->copy()->addHour();
                if ($endBlock->gt($horaFin)) $endBlock = $horaFin->copy();

                // Verificamos duplicados solo por bloque
                $bloqueExiste = Horario::where('odontologo_id', $odontologo_id)
                    ->where('fecha', $fecha->toDateString())
                    ->where('hora_inicio', $current->format('H:i'))
                    ->where('hora_fin', $endBlock->format('H:i'))
                    ->exists();

                if (!$bloqueExiste) {
                    Horario::create([
                        'odontologo_id' => $odontologo_id,
                        'dia' => $diaSemana,
                        'fecha' => $fecha->toDateString(),
                        'hora_inicio' => $current->format('H:i'),
                        'hora_fin' => $endBlock->format('H:i'),
                        'disponible' => true,
                    ]);
                }

                $current->addHour();
            }
        }
    }

    return redirect()->route('odontologo.horarios')
                     ->with('success', 'Horarios recurrentes creados correctamente.');
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
        'disponible' => 'required|boolean',
    ]);

    $horario = Horario::findOrFail($id);
    $odontologo_id = $horario->odontologo_id;

    // Si solo cambia la disponibilidad, actualizar y salir
    if ($request->fecha == $horario->fecha &&
        $request->hora_inicio == $horario->hora_inicio &&
        $request->hora_fin == $horario->hora_fin) {

        $horario->disponible = $request->disponible;
        $horario->save();

        return redirect()->route('odontologo.horarios')
                         ->with('success', 'Horario actualizado correctamente.');
    }

    // Validar duplicados si cambia fecha/hora
    $horaInicio = Carbon::parse($request->hora_inicio);
    $horaFin = Carbon::parse($request->hora_fin);

    $existe = Horario::where('odontologo_id', $odontologo_id)
        ->where('fecha', $request->fecha)
        ->where('id', '!=', $horario->id)
        ->where(function($q) use ($horaInicio, $horaFin) {
            $q->whereBetween('hora_inicio', [$horaInicio->format('H:i'), $horaFin->format('H:i')])
              ->orWhereBetween('hora_fin', [$horaInicio->format('H:i'), $horaFin->format('H:i')]);
        })->exists();

    if ($existe) {
        return redirect()->back()->with('error', 'Ya existe un horario en ese rango de tiempo.');
    }

    // Eliminar bloques libres antiguos
    Horario::where('odontologo_id', $odontologo_id)
           ->where('fecha', $horario->fecha)
           ->where('disponible', true)
           ->delete();

    // Crear nuevos bloques según rango de hora
    $current = $horaInicio;
    while ($current->lt($horaFin)) {
        $endBlock = $current->copy()->addHour();
        if ($endBlock->gt($horaFin)) $endBlock = $horaFin->copy();

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
                'disponible' => $request->disponible,
            ]);
        }

        $current->addHour();
    }

    return redirect()->route('odontologo.horarios')
                     ->with('success', 'Horario actualizado correctamente.');
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
