<?php

namespace App\Http\Controllers;

use App\Models\OdontologoFormacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OdontologoFormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $odontologo = Auth::user()->odontologo;
        $formaciones = $odontologo->formaciones; // relación en modelo
        return view('front.odontologo.formaciones.index', compact('formaciones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('front.odontologo.formaciones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
          $request->validate([
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png,gif|max:5120',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $odontologo = Auth::user()->odontologo;

        // Guardar archivo en storage/app/public/formaciones
        $file = $request->file('archivo');
        $nombreArchivo = $file->store('formaciones', 'public');

        // Registrar en la base de datos
        OdontologoFormacion::create([
            'odontologo_id' => $odontologo->id,
            'archivo' => $nombreArchivo,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->back()->with('success', 'Formación subida correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show(OdontologoFormacion $odontologoFormacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OdontologoFormacion $odontologoFormacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OdontologoFormacion $odontologoFormacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $formacion = OdontologoFormacion::findOrFail($id);

        // Eliminar archivo del storage si existe
        if (Storage::disk('public')->exists($formacion->archivo)) {
            Storage::disk('public')->delete($formacion->archivo);
        }

        $formacion->delete();

        return redirect()->back()->with('success', 'Formación eliminada correctamente.'); 
    }
}
