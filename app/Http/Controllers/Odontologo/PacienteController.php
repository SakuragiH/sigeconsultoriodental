<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    public function index()
    {
        // Obtener todos los pacientes
        $pacientes = Paciente::all();

        // Retornar la vista con los pacientes
        return view('front.odontologo.pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        return view('front.odontologo.pacientes.create');
    }

     public function store(Request $request)
    {
         $data = $request->validate([
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'ci' => 'required|unique:pacientes,ci',
        'fecha_nacimiento' => 'required|date',
        'telefono' => 'required|string|max:20',
        'direccion' => 'required|string',
        'genero' => 'required|in:Masculino,Femenino,Otro',
        'foto' => 'nullable|image|max:2048',
    ]);

    $data['usuario_id'] = Auth::id(); // ID del odontólogo logueado

    if ($request->hasFile('foto')) {
        $file = $request->file('foto');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('pacientes', $filename, 'public');
        $data['foto'] = $filename; // guardamos solo el nombre
    } else {
        $data['foto'] = 'default-avatar.png'; // si quieres una foto por defecto
    }

    Paciente::create($data);

    return redirect()->route('odontologo.pacientes.index')->with('success', 'Paciente creado correctamente.');
    }

    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('front.odontologo.pacientes.show', compact('paciente'));
    }



    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        return view('front.odontologo.pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $data = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'ci' => 'required|unique:pacientes,ci,'.$paciente->id,
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string',
            'genero' => 'required|in:Masculino,Femenino,Otro',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Si se sube nueva foto
        if ($request->hasFile('foto')) {
            // Opcional: borrar la foto anterior
            if ($paciente->foto && $paciente->foto != 'default-avatar.png' && file_exists(storage_path('app/public/pacientes/'.$paciente->foto))) {
                unlink(storage_path('app/public/pacientes/'.$paciente->foto));
            }

            $file = $request->file('foto');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('pacientes', $filename, 'public');
            $data['foto'] = $filename; // solo el nombre, igual que en store
        } else {
            $data['foto'] = $paciente->foto; // mantener foto anterior
        }

        $paciente->update($data);

        return redirect()->route('odontologo.pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }






    /**
     * Búsqueda AJAX de pacientes para Select2
     */
    public function buscar(Request $request)
    {
        $q = $request->input('q');

        $pacientes = Paciente::where('nombres', 'like', "%$q%")
            ->orWhere('apellidos', 'like', "%$q%")
            ->limit(20) // límite para no saturar
            ->get();

        return response()->json($pacientes);
    }
}
