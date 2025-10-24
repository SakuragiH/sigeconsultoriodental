<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Odontologo;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios = Horario::all();
        return view('admin.horarios.index', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $odontologos = Odontologo::all();
        return view('admin.horarios.create', compact('odontologos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
        'odontologo_id' => 'required|exists:odontologos,id',
        'fecha' => 'required|date',
        'dia' => 'required|string',
        'hora_inicio' => 'required|date_format:H:i',
        'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        'disponible' => 'required|boolean',
    ]);

    Horario::create([
        'odontologo_id' => $request->odontologo_id,
        'fecha' => $request->fecha,
        'dia' => $request->dia,
        'hora_inicio' => $request->hora_inicio,
        'hora_fin' => $request->hora_fin,
        'disponible' => $request->disponible,
    ]);


        // Redirigir con mensaje
        return redirect()
        ->route('admin.horarios.index')
        ->with('success', 'Horario registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $horario = Horario::with('odontologo')->findOrFail($id);
    return view('admin.horarios.show', compact('horario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $horario = Horario::findOrFail($id); // Busca el horario o falla
        $odontologos = Odontologo::all();    // Trae todos los odontólogos para el dropdown

        return view('admin.horarios.edit', compact('horario', 'odontologos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validación
    $request->validate([
        'odontologo_id' => 'required|exists:odontologos,id',
        'fecha'         => 'required|date',
        'hora_inicio'   => 'required|date_format:H:i',
        'hora_fin'      => 'required|date_format:H:i|after:hora_inicio',
        'disponible'    => 'required|boolean',
    ]);

    $horario = Horario::findOrFail($id);

    // Calcular el día de la semana automáticamente a partir de la fecha
    $fecha = new \Carbon\Carbon($request->fecha);
    $dias = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
    $dia_semana = $dias[$fecha->dayOfWeek];

    $horario->update([
        'odontologo_id' => $request->odontologo_id,
        'fecha'         => $request->fecha,
        'dia'           => $dia_semana,
        'hora_inicio'   => $request->hora_inicio,
        'hora_fin'      => $request->hora_fin,
        'disponible'    => $request->disponible,
    ]);

    return redirect()
        ->route('admin.horarios.index')
        ->with('success', 'Horario actualizado correctamente.');
    }


        // Devuelve los horarios en formato JSON para FullCalendar
    public function horariosJson()
    {
        $horarios = Horario::with('odontologo')
            ->where('disponible', true)
            ->get();

        // Transformamos para FullCalendar
        $events = $horarios->map(function($horario) {
            return [
                'id' => $horario->id,
                'title' => $horario->odontologo->nombres . ' ' . $horario->odontologo->apellidos,
                'start' => $horario->fecha . 'T' . $horario->hora_inicio,
                'end' => $horario->fecha . 'T' . $horario->hora_fin,
            ];
        });

        return response()->json($events);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $horario = Horario::findOrFail($id);
    $horario->delete();

    return redirect()
        ->route('admin.horarios.index')
        ->with('success', 'Horario eliminado correctamente.');
    }

    
}
