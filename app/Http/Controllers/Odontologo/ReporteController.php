<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Cita;
use App\Models\Horario;
use App\Models\Servicio;
use App\Models\HistorialMedico;
use App\Models\Medicamento;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReporteController extends Controller
{

    /**
     * Mostrar el menú de reportes
     */
    public function index()
    {
        // Pacientes por mes (últimos 12 meses)
        $pacientesPorMes = collect();
        for ($i = 1; $i <= 12; $i++) {
            $mes = Carbon::now()->month($i);
            $cantidad = Paciente::whereMonth('created_at', $i)
                        ->whereYear('created_at', Carbon::now()->year)
                        ->count();
            $pacientesPorMes->put($i, $cantidad);
        }

        // Citas por estado
        $citasPorEstado = Cita::selectRaw('estado, count(*) as total')
                            ->groupBy('estado')
                            ->pluck('total','estado');

        // Retornar a la vista
        return view('front.odontologo.reportes.index', compact('pacientesPorMes', 'citasPorEstado'));
    }

    public function pacientes(Request $request)
{
    $odontologoId = optional(Auth::user()->odontologo)->id;
    if (!$odontologoId) {
        abort(403, 'No se encontró el odontólogo asociado al usuario.');
    }

    $query = Paciente::whereHas('citas', function($q) use ($odontologoId){
        $q->where('odontologo_id', $odontologoId);
    });

    if ($request->filled('q')) {
        $qStr = $request->input('q');
        $query->where(function($sub) use ($qStr) {
            $sub->where('nombres', 'like', "%{$qStr}%")
                ->orWhere('apellidos', 'like', "%{$qStr}%")
                ->orWhere('ci', 'like', "%{$qStr}%")
                ->orWhere('telefono', 'like', "%{$qStr}%");
        });
    }

    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $start = $request->input('fecha_inicio');
        $end = $request->input('fecha_fin');
        $query->whereBetween('created_at', ["{$start} 00:00:00", "{$end} 23:59:59"]);
    }

    $pacientes = $query->orderBy('apellidos')->get();

    return view('front.odontologo.reportes.pacientes', compact('pacientes'));
}

public function pacientesPdf(Request $request)
{
    $odontologoId = optional(Auth::user()->odontologo)->id;
    if (!$odontologoId) {
        abort(403, 'No se encontró el odontólogo asociado al usuario.');
    }

    $query = Paciente::whereHas('citas', function($q) use ($odontologoId){
        $q->where('odontologo_id', $odontologoId);
    });

    if ($request->filled('q')) {
        $qStr = $request->input('q');
        $query->where(function($sub) use ($qStr) {
            $sub->where('nombres', 'like', "%{$qStr}%")
                ->orWhere('apellidos', 'like', "%{$qStr}%")
                ->orWhere('ci', 'like', "%{$qStr}%")
                ->orWhere('telefono', 'like', "%{$qStr}%");
        });
    }

    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $start = $request->input('fecha_inicio');
        $end = $request->input('fecha_fin');
        $query->whereBetween('created_at', ["{$start} 00:00:00", "{$end} 23:59:59"]);
    }

    $pacientes = $query->orderBy('apellidos')->get();

    $pdf = Pdf::loadView('front.odontologo.reportes.pacientes_pdf', compact('pacientes'));
    $filename = 'reporte_pacientes_'.now()->format('Ymd_His').'.pdf';
    return $pdf->download($filename);
}


    public function citas() 
    {
    $odontologoId = Auth::user()->odontologo->id;

    // Cargar las citas con sus relaciones
    $citas = Cita::with(['paciente', 'servicio', 'horario'])
                 ->where('odontologo_id', $odontologoId)
                 ->get()
                 ->sortBy(function($cita) {
                     return $cita->horario->fecha; // Ordenamos por fecha de horario
                 });

    return view('front.odontologo.reportes.citas', compact('citas'));
    }


    public function citasPdf(Request $request)
    {
    $odontologoId = optional(Auth::user()->odontologo)->id;
    if (!$odontologoId) {
        abort(403, 'No se encontró el odontólogo asociado al usuario.');
    }

    // Traemos las citas con relaciones
    $citas = Cita::with(['paciente', 'servicio', 'horario'])
                 ->where('odontologo_id', $odontologoId)
                 ->get();

    // Filtrado por búsqueda (opcional)
    if ($request->filled('q')) {
        $qStr = $request->input('q');
        $citas = $citas->filter(function($cita) use ($qStr) {
            $paciente = $cita->paciente;
            return str_contains(strtolower($paciente->nombres), strtolower($qStr)) ||
                   str_contains(strtolower($paciente->apellidos), strtolower($qStr)) ||
                   str_contains(strtolower($paciente->ci ?? ''), strtolower($qStr));
        });
    }

    // Filtrado por rango de fechas (opcional)
    if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
        $start = $request->input('fecha_inicio');
        $end = $request->input('fecha_fin');

        $citas = $citas->filter(function($cita) use ($start, $end) {
            $fechaCita = optional($cita->horario)->fecha;
            return $fechaCita >= $start && $fechaCita <= $end;
        });
    }

    // Ordenar por fecha de horario
    $citas = $citas->sortBy(function($cita) {
        return optional($cita->horario)->fecha;
    });

    // Generar PDF
    $pdf = Pdf::loadView('front.odontologo.reportes.citas_pdf', compact('citas'));
    $filename = 'reporte_citas_'.now()->format('Ymd_His').'.pdf';
    return $pdf->download($filename);
    }

    // Reporte de horarios  
    // Reporte de horarios  
    public function horarios(Request $request) 
    {   
    $odontologoId = Auth::user()->odontologo->id;

    $query = Horario::where('odontologo_id', $odontologoId);

    // Aplicar filtros de formulario (día y fecha)
    if ($request->filled('dia')) {
        $query->where('dia', $request->input('dia'));
    }
    if ($request->filled('fecha')) {
        $query->where('fecha', $request->input('fecha'));
    }

    $horarios = $query->orderBy('fecha')->orderBy('hora_inicio')->get();

    return view('front.odontologo.reportes.horarios', compact('horarios'));
    }

    public function horariosPdf(Request $request)
    {
    $odontologoId = Auth::user()->odontologo->id;

    $query = Horario::where('odontologo_id', $odontologoId);

    // Filtro por buscador de DataTables
    if ($request->filled('q')) {
        $q = $request->input('q');
        $query->where(function($sub) use ($q) {
            $sub->where('dia', 'like', "%{$q}%")
                ->orWhere('fecha', 'like', "%{$q}%");
        });
    }

    $horarios = $query->orderBy('fecha')->orderBy('hora_inicio')->get();

    $pdf = Pdf::loadView('front.odontologo.reportes.horarios_pdf', compact('horarios'));
    $filename = 'reporte_horarios_' . now()->format('Ymd_His') . '.pdf';
    return $pdf->download($filename);
    }




    /**
     * Mostrar reporte de servicios en la vista
     */
    public function servicios(Request $request)
    {
        $query = Servicio::query();

        // Filtrado por buscador
        if ($request->filled('q')) {
            $qStr = $request->input('q');
            $query->where(function($sub) use ($qStr) {
                $sub->where('nombre', 'like', "%{$qStr}%")
                    ->orWhere('descripcion', 'like', "%{$qStr}%")
                    ->orWhere('precio', 'like', "%{$qStr}%");
            });
        }

        $servicios = $query->orderBy('nombre')->get();

        return view('front.odontologo.reportes.servicios', compact('servicios'));
    }

    /**
     * Generar PDF de servicios filtrados por buscador
     */
    public function serviciosPdf(Request $request)
    {
        $query = Servicio::query();

        // Filtrado por buscador (igual que en la vista)
        if ($request->filled('q')) {
            $qStr = $request->input('q');
            $query->where(function($sub) use ($qStr) {
                $sub->where('nombre', 'like', "%{$qStr}%")
                    ->orWhere('descripcion', 'like', "%{$qStr}%")
                    ->orWhere('precio', 'like', "%{$qStr}%");
            });
        }

        $servicios = $query->orderBy('nombre')->get();

        $pdf = Pdf::loadView('front.odontologo.reportes.servicios_pdf', compact('servicios'));
        $filename = 'reporte_servicios_'.now()->format('Ymd_His').'.pdf';
        return $pdf->download($filename);
    }

    // Mostrar listado de historial médico
public function historialesMedicos(Request $request) 
{
    $odontologoId = optional(Auth::user()->odontologo)->id;
    if (!$odontologoId) {
        abort(403, 'No se encontró el odontólogo asociado al usuario.');
    }

    $query = HistorialMedico::with('paciente')
                ->whereHas('paciente', function($q) use ($odontologoId) {
                    $q->whereHas('citas', function($q2) use ($odontologoId){
                        $q2->where('odontologo_id', $odontologoId);
                    });
                });

    // Aplicar búsqueda
    if ($request->filled('q')) {
        $qStr = $request->input('q');
        $query->whereHas('paciente', function($q2) use ($qStr) {
            $q2->where('nombres', 'like', "%{$qStr}%")
               ->orWhere('apellidos', 'like', "%{$qStr}%")
               ->orWhere('ci', 'like', "%{$qStr}%");
        });
    }

    $historiales = $query->orderBy('created_at', 'desc')->get();

    return view('front.odontologo.reportes.historialesmedicos', compact('historiales'));
}

// PDF de historial médico
public function historialesMedicosPdf(Request $request) 
{
    $odontologoId = optional(Auth::user()->odontologo)->id;
    if (!$odontologoId) {
        abort(403, 'No se encontró el odontólogo asociado al usuario.');
    }

    $query = HistorialMedico::with('paciente')
                ->whereHas('paciente', function($q) use ($odontologoId) {
                    $q->whereHas('citas', function($q2) use ($odontologoId){
                        $q2->where('odontologo_id', $odontologoId);
                    });
                });

    // Aplicar búsqueda
    if ($request->filled('q')) {
        $qStr = $request->input('q');
        $query->whereHas('paciente', function($q2) use ($qStr) {
            $q2->where('nombres', 'like', "%{$qStr}%")
               ->orWhere('apellidos', 'like', "%{$qStr}%")
               ->orWhere('ci', 'like', "%{$qStr}%");
        });
    }

    $historiales = $query->orderBy('created_at', 'desc')->get();

    $pdf = Pdf::loadView('front.odontologo.reportes.historialesmedicos_pdf', compact('historiales'));
    $filename = 'reporte_historiales_'.now()->format('Ymd_His').'.pdf';
    return $pdf->download($filename);
}


   public function medicamentos()
{
    $medicamentos = \App\Models\Medicamento::all();
    return view('front.odontologo.reportes.medicamentos', compact('medicamentos'));
}

public function medicamentosPdf(Request $request)
{
    $medicamentos = \App\Models\Medicamento::all();

    // Filtrado por buscador (opcional)
    if ($request->filled('q')) {
        $qStr = $request->input('q');
        $medicamentos = $medicamentos->filter(function($m) use ($qStr) {
            return str_contains(strtolower($m->nombre), strtolower($qStr)) ||
                   str_contains(strtolower($m->descripcion ?? ''), strtolower($qStr)) ||
                   str_contains(strtolower($m->dosis ?? ''), strtolower($qStr)) ||
                   str_contains(strtolower($m->frecuencia ?? ''), strtolower($qStr)) ||
                   str_contains(strtolower($m->via_administracion ?? ''), strtolower($qStr));
        });
    }

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('front.odontologo.reportes.medicamentos_pdf', compact('medicamentos'));
    $filename = 'reporte_medicamentos_' . now()->format('Ymd_His') . '.pdf';
    return $pdf->download($filename);
}

}
