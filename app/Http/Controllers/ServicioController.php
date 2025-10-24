<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicios = Servicio::all();
        return view('admin.servicios.index', compact('servicios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.servicios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'nullable|numeric|min:0',
        'descripcion' => 'nullable|string',
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
    ]);

    // Subir la foto
    if($request->hasFile('foto')){
        $image = $request->file('foto');
        $name = time().'_'.$image->getClientOriginalName();
        $path = $image->storeAs('public/servicios', $name); // se guarda en storage/app/public/servicios
        $fotoPath = 'storage/servicios/'.$name;
    } else {
        $fotoPath = null;
    }

    // Crear el servicio
    Servicio::create([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'descripcion' => $request->descripcion,
        'foto' => $fotoPath,
    ]);

    return redirect()
    ->route('admin.servicios.index')
    ->with('success', 'Servicio registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('admin.servicios.show', compact('servicio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $servicio = Servicio::findOrFail($id);
        return view('admin.servicios.edit', compact('servicio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $servicio = Servicio::findOrFail($id);

    // Validación
    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'nullable|numeric|min:0',
        'descripcion' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
    ]);

    // Actualizar la foto si se sube nueva
    if($request->hasFile('foto')){
        // Eliminar foto anterior si existe
        if($servicio->foto && file_exists(public_path($servicio->foto))){
            unlink(public_path($servicio->foto));
        }

        $image = $request->file('foto');
        $name = time().'_'.$image->getClientOriginalName();
        $path = $image->storeAs('public/servicios', $name);
        $fotoPath = 'storage/servicios/'.$name;
    } else {
        $fotoPath = $servicio->foto;
    }

    // Actualizar servicio
    $servicio->update([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'descripcion' => $request->descripcion,
        'foto' => $fotoPath,
    ]);

    return redirect()
    ->route('admin.servicios.index')
    ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $servicio = Servicio::findOrFail($id);

    // Eliminar la foto si existe
    if ($servicio->foto && file_exists(public_path($servicio->foto))) {
        unlink(public_path($servicio->foto));
    }

    $servicio->delete();

    return redirect()
    ->route('admin.servicios.index')
    ->with('success', 'El servicio ha sido eliminado correctamente.');
    }
}
