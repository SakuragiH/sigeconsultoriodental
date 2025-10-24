<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use App\Models\HistorialMedico;
use App\Models\Medicamento;
use App\Models\Prescripcion;
use Illuminate\Http\Request;

class PrescripcionController extends Controller
{
    public function index()
{
    // Obtener todas las prescripciones con sus relaciones para mostrar en la tabla
    $prescripciones = Prescripcion::with(['historial.cita.paciente', 'medicamento'])->get();

    // Retornar la vista con las prescripciones
    return view('front.odontologo.prescripciones.index', compact('prescripciones'));
}

/**
     * Mostrar el formulario para crear una nueva prescripción.
     */
    public function create()
    {
        $historiales = HistorialMedico::with('cita.paciente')->get();
        $medicamentos = Medicamento::all();

        return view('front.odontologo.prescripciones.create', compact('historiales', 'medicamentos'));
    }

    /**
     * Almacenar una nueva prescripción en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'historial_id' => 'required|exists:historial_medicos,id',
            'medicamento_id' => 'required|exists:medicamentos,id',
            'dosis' => 'required|string|max:255',
            'observaciones' => 'nullable|string',
        ]);

        Prescripcion::create([
            'historial_id' => $request->historial_id,
            'medicamento_id' => $request->medicamento_id,
            'dosis' => $request->dosis,
            'observaciones' => $request->observaciones,
        ]);

        return redirect()->route('odontologo.prescripciones.index')
                         ->with('success', 'Prescripción registrada correctamente.');
    }

    // Mostrar detalle de una prescripción
    public function show($id)
    {
        $prescripcion = Prescripcion::with(['historial.cita.paciente', 'medicamento'])->findOrFail($id);
        return view('front.odontologo.prescripciones.show', compact('prescripcion'));
    }


    // Editar Prescripción
public function edit($id)
{
    $prescripcion = Prescripcion::findOrFail($id);
    $medicamentos = Medicamento::all(); // Para el select
    return view('front.odontologo.prescripciones.edit', compact('prescripcion', 'medicamentos'));
}

// Actualizar Prescripción
public function update(Request $request, $id)
{
    $prescripcion = Prescripcion::findOrFail($id);

    $request->validate([
        'medicamento_id' => 'required|exists:medicamentos,id',
        'dosis' => 'required|string|max:255',
        'observaciones' => 'nullable|string',
    ]);

    $prescripcion->update([
        'medicamento_id' => $request->medicamento_id,
        'dosis' => $request->dosis,
        'observaciones' => $request->observaciones,
    ]);

    return redirect()->route('odontologo.prescripciones.index')
                     ->with('success', 'Prescripción actualizada correctamente.');
}

public function destroy($id)
{
    $prescripcion = Prescripcion::findOrFail($id);
    $prescripcion->delete();

    return redirect()->route('odontologo.prescripciones.index')
                     ->with('success', 'Prescripción eliminada correctamente.');
}

}
