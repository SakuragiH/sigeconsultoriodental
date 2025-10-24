<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\HistorialMedico;
use App\Models\Paciente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HistorialMedicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Trae todos los historiales con la relación paciente y cita
        $historiales = HistorialMedico::with(['paciente', 'cita'])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Retorna la vista con los datos
        return view('admin.historialesmedicos.index', compact('historiales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Trae los pacientes ordenados por nombre
    $pacientes = Paciente::orderBy('nombres')->get();

    // Trae las citas con su horario, paciente y odontólogo
    $citas = Cita::with(['horario', 'paciente', 'odontologo'])
                ->get()
                ->sortBy(function($cita) {
                    return $cita->horario->fecha . ' ' . $cita->horario->hora_inicio;
                });

    return view('admin.historialesmedicos.create', compact('pacientes', 'citas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación de campos
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'cita_id' => 'nullable|exists:citas,id',
            'diagnostico' => 'required|string',
            'tratamiento' => 'nullable|string',
            'observaciones_paciente' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // máximo 5MB
        ]);

        // Preparar los datos
        $datos = $request->only([
            'paciente_id', 
            'cita_id', 
            'diagnostico', 
            'tratamiento', 
            'observaciones_paciente'
        ]);

        // Manejo de archivo
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $ruta = $archivo->store('historiales_medicos', 'public'); // se guarda en storage/app/public/historiales_medicos
            $datos['archivo_path'] = $ruta;
            $datos['archivo_nombre_original'] = $archivo->getClientOriginalName();
        }

        // Crear el historial médico
        HistorialMedico::create($datos);

        return redirect()
        ->route('admin.historialmedico.index')
        ->with('success', 'Historial médico registrado correctamente.')
        ->with('icono', 'success');
    }

    /**
 * Descargar archivo del historial médico.
 */
    // Descargar archivo adjunto
    public function download($id)
    {
        $historial = HistorialMedico::findOrFail($id);

        if (!$historial->archivo_path || !Storage::disk('public')->exists($historial->archivo_path)) {
            return redirect()->back()->with('error', 'Archivo no encontrado.');
        }

        return Storage::disk('public')->download(
            $historial->archivo_path,
            $historial->archivo_nombre_original
        );
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
          // Busca el historial por ID, cargando paciente y cita
            $historial = HistorialMedico::with(['paciente', 'cita'])->findOrFail($id);

            // Retorna la vista show dentro de la carpeta plural "historialesmedicos"
            return view('admin.historialesmedicos.show', compact('historial'));
    }

    // Generar PDF del historial
    public function pdf($id)
    {
        $historial = HistorialMedico::with(['paciente', 'cita.odontologo', 'cita.horario'])->findOrFail($id);

        $pdf = Pdf::loadView('admin.historialesmedicos.pdf', compact('historial'))
                ->setPaper('a4', 'portrait');

        // Nombre del archivo PDF
        $nombreArchivo = 'Historial_Medico_' . $historial->paciente->nombres . '_' . $historial->id . '.pdf';

        return $pdf->download($nombreArchivo);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $historial = HistorialMedico::findOrFail($id);

        // Trae los pacientes para el select
        $pacientes = Paciente::orderBy('nombres')->get();

        // Trae las citas con su horario, paciente y odontólogo
        $citas = Cita::with(['horario', 'paciente', 'odontologo'])
                    ->get()
                    ->sortBy(function($cita) {
                        return $cita->horario->fecha . ' ' . $cita->horario->hora_inicio;
                    });

        return view('admin.historialesmedicos.edit', compact('historial', 'pacientes', 'citas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $historial = HistorialMedico::findOrFail($id);

    // Validación de campos
    $request->validate([
        'paciente_id' => 'required|exists:pacientes,id',
        'cita_id' => 'nullable|exists:citas,id',
        'diagnostico' => 'required|string',
        'tratamiento' => 'nullable|string',
        'observaciones_paciente' => 'nullable|string',
        'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // máximo 5MB
    ]);

    // Actualiza los datos básicos
    $historial->paciente_id = $request->paciente_id;
    $historial->cita_id = $request->cita_id;
    $historial->diagnostico = $request->diagnostico;
    $historial->tratamiento = $request->tratamiento;
    $historial->observaciones_paciente = $request->observaciones_paciente;

    // Manejo de archivo
    if ($request->hasFile('archivo')) {
        // Elimina archivo anterior si existe
        if ($historial->archivo_path && Storage::disk('public')->exists($historial->archivo_path)) {
            Storage::disk('public')->delete($historial->archivo_path);
        }

        $archivo = $request->file('archivo');
        $ruta = $archivo->store('historiales_medicos', 'public');
        $historial->archivo_path = $ruta;
        $historial->archivo_nombre_original = $archivo->getClientOriginalName();
    }

    $historial->save();

    return redirect()
        ->route('admin.historialmedico.show', $historial->id)
        ->with('success', 'Historial médico actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $historial = HistorialMedico::findOrFail($id);

    // Elimina archivo si existe
    if ($historial->archivo_path && Storage::disk('public')->exists($historial->archivo_path)) {
        Storage::disk('public')->delete($historial->archivo_path);
    }

    $historial->delete();

    return redirect()
        ->route('admin.historialmedico.index')
        ->with('success', 'Historial médico eliminado correctamente.');
    }
}
