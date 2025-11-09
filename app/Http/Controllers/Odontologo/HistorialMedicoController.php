<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\HistorialMedico;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HistorialMedicoController extends Controller
{
    public function index()
    {

         $historiales = HistorialMedico::with([
        'cita' => function($query) {
            $query->with(['servicio', 'horario', 'paciente']);
        }
    ])
    ->orderBy('created_at', 'desc')
    ->get();

    return view('front.odontologo.historialesmedicos.index', compact('historiales'));
    
    }


    public function create()
    {
         // Traer citas que aún no tengan historial médico
    $citas = Cita::with(['paciente', 'horario', 'servicio'])
        ->whereDoesntHave('historialesMedicos')
        ->orderByDesc('created_at') // usamos la fecha de creación de la cita como referencia
        ->get();

    return view('front.odontologo.historialesmedicos.create', compact('citas'));
    }


    public function store(Request $request)
    {
         // ✅ Validación
    $request->validate([
        'cita_id' => 'required|exists:citas,id',
        'diagnostico' => 'required|string',
        'tratamiento' => 'nullable|string',
        'observaciones_paciente' => 'nullable|string',
        'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
    ]);

    // ✅ Obtener la cita
    $cita = Cita::with('paciente')->findOrFail($request->cita_id);

    // ✅ Crear el historial médico
    $historial = new HistorialMedico();
    $historial->cita_id = $cita->id;
    $historial->paciente_id = $cita->paciente->id;
    $historial->diagnostico = $request->diagnostico;
    $historial->tratamiento = $request->tratamiento;
    $historial->observaciones_paciente = $request->observaciones_paciente;

    // ✅ Subir archivo (si existe)
    if ($request->hasFile('archivo')) {
        $archivo = $request->file('archivo');
        $ruta = $archivo->store('historiales', 'public');

        $historial->archivo_path = $ruta;
        $historial->archivo_nombre_original = $archivo->getClientOriginalName();
    }

    $historial->save();

    return redirect()
        ->route('odontologo.historialesmedicos.index')
        ->with('success', 'Historial médico registrado correctamente.');
    }

    public function edit($id)
    {
        // Traer el historial con su cita y paciente
        $historial = HistorialMedico::with(['cita.servicio', 'cita.horario', 'cita.paciente'])->findOrFail($id);

        // No necesitas traer todas las citas porque el historial ya está asociado a una
        $cita = $historial->cita;

        return view('front.odontologo.historialesmedicos.edit', compact('historial', 'cita'));
    }

    public function update(Request $request, $id)
    {
        // Traer el historial
        $historial = HistorialMedico::findOrFail($id);

        // Validación
        $request->validate([
            'diagnostico' => 'required|string',
            'tratamiento' => 'nullable|string',
            'observaciones_paciente' => 'nullable|string',
            'archivo' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120', // max 5MB
        ]);

        // Actualizar campos
        $historial->diagnostico = $request->diagnostico;
        $historial->tratamiento = $request->tratamiento;
        $historial->observaciones_paciente = $request->observaciones_paciente;

        // Manejar archivo si suben uno nuevo
        if ($request->hasFile('archivo')) {

            // Borrar archivo anterior si existe
            if ($historial->archivo_path && \Illuminate\Support\Facades\Storage::exists('public/'.$historial->archivo_path)) {
                \Illuminate\Support\Facades\Storage::delete('public/'.$historial->archivo_path);
            }

            $file = $request->file('archivo');
            $filename = time().'_'.$file->getClientOriginalName();
            $filePath = $file->storeAs('historialesmedicos', $filename, 'public');

            $historial->archivo_path = $filePath;
            $historial->archivo_nombre_original = $file->getClientOriginalName();
        }

        // Guardar cambios
        $historial->save();

        return redirect()->route('odontologo.historialesmedicos.index')
                        ->with('success', 'Historial actualizado correctamente.');
    }


    public function show($id)
    {
        // Traemos el historial con la cita, paciente, servicio y horario
        $historial = HistorialMedico::with([
            'cita.servicio',
            'cita.horario',
            'cita.paciente'
        ])->findOrFail($id);

        return view('front.odontologo.historialesmedicos.show', compact('historial'));
    }


    public function destroy($id)
    {
        // Buscar el historial
        $historial = HistorialMedico::findOrFail($id);

        // Borrar archivo si existe
        if ($historial->archivo_path && \Illuminate\Support\Facades\Storage::exists('public/' . $historial->archivo_path)) {
            \Illuminate\Support\Facades\Storage::delete('public/' . $historial->archivo_path);
        }

        // Borrar historial de la base de datos
        $historial->delete();

        // Redirigir con mensaje
        return redirect()->route('odontologo.historialesmedicos.index')
                        ->with('success', 'Historial eliminado correctamente.');
    }

    public function descargarPdf($id)
    {
        $historial = HistorialMedico::with([
            'cita.servicio',
            'cita.horario',
            'cita.paciente'
        ])->findOrFail($id);

        // Generar PDF usando una vista específica
        $pdf = Pdf::loadView('front.odontologo.historialesmedicos.pdf', compact('historial'));

            // Descargar el PDF con nombre dinámico
            return $pdf->download('HistorialMedico_'.$historial->id.'.pdf');
    }


}
