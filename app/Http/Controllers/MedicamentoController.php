<?php

namespace App\Http\Controllers;

use App\Models\Medicamento;
use Illuminate\Http\Request;

class MedicamentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $medicamentos = Medicamento::all();
    return view('admin.medicamentos.index', compact('medicamentos'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.medicamentos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|unique:medicamentos',
            'descripcion' => 'required',
            'dosis' => 'required',
            'frecuencia' => 'required',
            'via_administracion' => 'required'
        ]);

        $medicamento = new Medicamento();
        $medicamento->nombre = $request->nombre;
        $medicamento->descripcion = $request->descripcion;
        $medicamento->dosis = $request->dosis;
        $medicamento->frecuencia = $request->frecuencia;
        $medicamento->via_administracion = $request->via_administracion;
        $medicamento->save();

        return redirect()->route('admin.medicamentos.index')
            ->with('success', 'Medicamento creado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medicamento $medicamento)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medicamento $medicamento)
    {
        return view('admin.medicamentos.edit', compact('medicamento'));
    }

    public function update(Request $request, Medicamento $medicamento)
    {
        $request->validate([
            'nombre' => 'required|unique:medicamentos,nombre,' . $medicamento->id,
            'descripcion' => 'required',
            'dosis' => 'required',
            'frecuencia' => 'required',
            'via_administracion' => 'required'
        ]);

        $medicamento->update($request->only('nombre','descripcion','dosis','frecuencia','via_administracion'));

        return redirect()->route('admin.medicamentos.index')
            ->with('success', 'Medicamento actualizado exitosamente.')
            ->with('icono', 'success');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medicamento $medicamento)
    {
        $medicamento->delete();

        return redirect()->route('admin.medicamentos.index')
            ->with('success', 'Medicamento eliminado exitosamente.')
            ->with('icono', 'success');
    }
}
