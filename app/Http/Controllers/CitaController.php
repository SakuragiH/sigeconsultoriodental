<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Odontologo;
use App\Models\Paciente;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $citas = Cita::with('paciente', 'odontologo', 'servicio', 'horario')->get();
        return view('admin.citas.index', compact('citas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(request $request)
    {
         $pacientes  = Paciente::all();
        $odontologos= Odontologo::all();
        $servicios  = Servicio::all();

        // Capturamos el odontólogo elegido en el primer envío GET
        $odontologoSeleccionado = $request->get('odontologo_id');

        // Filtramos los horarios disponibles SOLO si hay odontólogo elegido
        $horarios = collect();
        if ($odontologoSeleccionado) {
            $horarios = Horario::where('odontologo_id', $odontologoSeleccionado)
                ->where('disponible', true)                       // solo disponibles
                ->whereDoesntHave('citas')                       // sin cita asignada
                ->orderBy('fecha')
                ->orderBy('hora_inicio')
                ->get();
        }

        return view('admin.citas.create', compact(
            'pacientes', 'odontologos', 'servicios',
            'horarios', 'odontologoSeleccionado'
        ));
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = $request->all();
        //return response()->json($datos);

      $request->validate([
        'paciente_id'   => 'required|exists:pacientes,id',
        'odontologo_id' => 'required|exists:odontologos,id',
        'servicio_id'   => 'required|exists:servicios,id',
        'horario_id'    => 'required|exists:horarios,id',
        'motivo'        => 'nullable|string',
        'observaciones' => 'nullable|string',
    ]);

    Cita::create($request->all());

    // Marcar el horario como no disponible
    Horario::where('id', $request->horario_id)->update(['disponible' => false]);

    return redirect()->route('admin.citas.index')->with('success', 'Cita registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Buscar la cita por id y cargar relaciones necesarias
    $cita = Cita::with(['paciente.usuario', 'odontologo', 'servicio', 'horario'])->find($id);

    // Verificamos que exista
    if (!$cita) {
        return redirect()->route('admin.citas.index')
            ->with('error', 'Cita no encontrada.');
    }

    return view('admin.citas.show', compact('cita'));


    }

    public function updateStatus(Request $request, Cita $cita)
    {
        $request->validate([
            'estado' => 'required|in:Pendiente,Confirmada,Cancelada',
        ]);

        $cita->update(['estado' => $request->estado]);

        return redirect()->back()->with('success', 'Estado de la cita actualizado correctamente.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
         $cita = Cita::findOrFail($id);

    $pacientes   = Paciente::all();
    $odontologos = Odontologo::all();
    $servicios   = Servicio::all();

    // Capturamos el odontólogo seleccionado vía GET (o usamos el actual de la cita)
    $odontologoSeleccionado = $request->get('odontologo_id', $cita->odontologo_id);

    // Horarios disponibles del odontólogo seleccionado
    $horarios = Horario::where('odontologo_id', $odontologoSeleccionado)
        ->where(function($query) use ($cita) {
            $query->where('disponible', true)
                  ->orWhere('id', $cita->horario_id); // incluimos el horario actual
        })
        ->whereDoesntHave('citas', function($q) use ($cita){
            $q->where('id', '!=', $cita->id); // Excluimos esta cita
        })
        ->orderBy('fecha')
        ->orderBy('hora_inicio')
        ->get();

    return view('admin.citas.edit', compact(
        'cita', 'pacientes', 'odontologos', 'servicios', 'horarios', 'odontologoSeleccionado'
    ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

    $request->validate([
        'paciente_id'   => 'required|exists:pacientes,id',
        'odontologo_id' => 'required|exists:odontologos,id',
        'servicio_id'   => 'required|exists:servicios,id',
        'horario_id'    => 'required|exists:horarios,id',
        'motivo'        => 'nullable|string',
        'observaciones' => 'nullable|string',
    ]);

    // Si cambió el horario, liberamos el anterior y bloqueamos el nuevo
    if($request->horario_id != $cita->horario_id){
        Horario::where('id', $cita->horario_id)->update(['disponible' => true]);
        Horario::where('id', $request->horario_id)->update(['disponible' => false]);
    }

    $cita->update($request->all());

    return redirect()->route('admin.citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
    $cita = Cita::findOrFail($id);

    // Liberar el horario asociado
    if($cita->horario_id){
        Horario::where('id', $cita->horario_id)->update(['disponible' => true]);
    }

    $cita->delete();

    return redirect()->route('admin.citas.index')->with('success', 'Cita eliminada correctamente.');
    }
}
