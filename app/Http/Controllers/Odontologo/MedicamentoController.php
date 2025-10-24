<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    public function index()
    {
        // Obtener todos los medicamentos ordenados por ID descendente
        $medicamentos = Medicamento::orderBy('id', 'desc')->get();

        // Retornar la vista index de medicamentos
        return view('front.odontologo.medicamentos.index', compact('medicamentos'));
    }

     /**
     * Mostrar el formulario para crear un nuevo medicamento.
     */
    public function create()
    {
        // Simplemente retorna la vista de creación
        return view('front.odontologo.medicamentos.create');
    }

    /**
     * Guardar un nuevo medicamento en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:500',
            'dosis' => 'required|string|max:100',
            'frecuencia' => 'required|string|max:100',
            'via_administracion' => 'required|string|max:100',
        ]);

        // Crear el medicamento
        Medicamento::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'dosis' => $request->dosis,
            'frecuencia' => $request->frecuencia,
            'via_administracion' => $request->via_administracion,
        ]);

        // Redirigir a la lista de medicamentos con mensaje de éxito
        return redirect()
        ->route('odontologo.medicamentos.index')
        ->with('success', 'Medicamento registrado correctamente.');
    }

    public function edit($id)
{
    $medicamento = Medicamento::findOrFail($id);
    return view('front.odontologo.medicamentos.edit', compact('medicamento'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'required|string|max:500',
        'dosis' => 'required|string|max:100',
        'frecuencia' => 'required|string|max:100',
        'via_administracion' => 'required|string|max:100',
    ]);

    $medicamento = Medicamento::findOrFail($id);
    $medicamento->update($request->all());

    return redirect()->route('odontologo.medicamentos.index')
                     ->with('success', 'Medicamento actualizado correctamente.');
}

// Mostrar detalle de un medicamento
public function show($id)
{
    $medicamento = Medicamento::findOrFail($id);
    return view('front.odontologo.medicamentos.show', compact('medicamento'));
}

public function destroy($id)
{
    $medicamento = Medicamento::findOrFail($id);
    $medicamento->delete();

    return redirect()->route('odontologo.medicamentos.index')
                     ->with('success', 'Medicamento eliminado correctamente.');
}


}
