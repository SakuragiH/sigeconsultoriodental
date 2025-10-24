<?php

namespace App\Http\Controllers;

use App\Models\HistorialMedico;
use App\Models\Medicamento;
use App\Models\Prescripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PrescripcionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         // Trae todas las prescripciones con sus relaciones: historial y medicamento
    $prescripciones = Prescripcion::with(['historial.paciente', 'medicamento'])
                        ->orderBy('created_at', 'desc')
                        ->get();

    // Retorna la vista index dentro de la carpeta "prescripciones"
    return view('admin.prescripciones.index', compact('prescripciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Trae todos los historiales médicos para el select
    $historiales = HistorialMedico::with('paciente')->orderBy('created_at', 'desc')->get();

    // Trae todos los medicamentos para el select
    $medicamentos = Medicamento::orderBy('nombre')->get();

    // Retorna la vista create dentro de la carpeta "prescripciones"
    return view('admin.prescripciones.create', compact('historiales', 'medicamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de campos
    $request->validate([
        'historial_id' => 'required|exists:historial_medicos,id',
        'medicamento_id' => 'required|exists:medicamentos,id',
        'dosis' => 'required|string|max:255',
        'observaciones' => 'nullable|string',
    ]);

    // Crear la prescripción
    Prescripcion::create([
        'historial_id' => $request->historial_id,
        'medicamento_id' => $request->medicamento_id,
        'dosis' => $request->dosis,
        'observaciones' => $request->observaciones,
    ]);

    return redirect()
        ->route('admin.prescripciones.index')
        ->with('success', 'Prescripción registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
            // Busca la prescripción por ID, cargando historial y medicamento
        $prescripcion = Prescripcion::with(['historial.paciente', 'medicamento'])->findOrFail($id);

        // Retorna la vista show dentro de la carpeta "prescripciones"
        return view('admin.prescripciones.show', compact('prescripcion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $prescripcion = Prescripcion::findOrFail($id);

        // Traer todos los historiales y medicamentos para los selects
        $historiales = HistorialMedico::with('paciente')->get();
        $medicamentos = Medicamento::all();

        return view('admin.prescripciones.edit', compact('prescripcion', 'historiales', 'medicamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $prescripcion = Prescripcion::findOrFail($id);

    // Validación de campos
    $request->validate([
        'historial_id' => 'required|exists:historial_medicos,id',
        'medicamento_id' => 'required|exists:medicamentos,id',
        'dosis' => 'required|string',
        'observaciones' => 'nullable|string',
    ]);

    // Actualizar los datos
    $prescripcion->historial_id = $request->historial_id;
    $prescripcion->medicamento_id = $request->medicamento_id;
    $prescripcion->dosis = $request->dosis;
    $prescripcion->observaciones = $request->observaciones;
    $prescripcion->save();

    return redirect()
        ->route('admin.prescripciones.index')
        ->with('success', 'Prescripción actualizada correctamente.');
    }

    public function pdf($id)
    {
        $prescripcion = Prescripcion::with(['historial.paciente', 'medicamento'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.prescripciones.pdf', compact('prescripcion'))
                ->setPaper('a4', 'portrait');

        $nombreArchivo = 'Prescripcion_' . $prescripcion->historial->paciente->nombres . '_' . $prescripcion->id . '.pdf';

        return $pdf->download($nombreArchivo);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $prescripcion = Prescripcion::findOrFail($id);

        $prescripcion->delete();

        return redirect()
            ->route('admin.prescripciones.index')
            ->with('success', 'Prescripción eliminada correctamente.');
    }
}
