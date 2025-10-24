<?php

namespace App\Http\Controllers\Odontologo;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    public function index() 
    {
        $servicios = Servicio::orderBy('nombre')->get();
        return view('front.odontologo.servicios.index', compact('servicios'));
    }
    
    public function create() 
    {
         return view('front.odontologo.servicios.create');
    }
    
    public function store(Request $request) 
    {
         $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'nullable|numeric|min:0',
        'descripcion' => 'nullable|string',
        'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if($request->hasFile('foto')){
        $image = $request->file('foto');
        $name = time().'_'.$image->getClientOriginalName();
        $image->storeAs('public/servicios', $name); // archivo real en storage/app/public/servicios
        $fotoPath = 'storage/servicios/'.$name;    // ruta para BD
    } else {
        $fotoPath = null;
    }

    Servicio::create([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'descripcion' => $request->descripcion,
        'foto' => $fotoPath, // Guardamos la ruta completa
    ]);

    return redirect()->route('odontologo.servicios.index')->with('success', 'Servicio creado correctamente.');
    }
    
    public function show($id) 
    {
        // Obtener el servicio, lanzar 404 si no existe
    $servicio = Servicio::findOrFail($id);

    // Retornar la vista 'show' pasando el servicio
    return view('front.odontologo.servicios.show', compact('servicio'));
    }
    
    public function edit($id) 
    {
        $servicio = Servicio::findOrFail($id);
        return view('front.odontologo.servicios.edit', compact('servicio'));
    }
    
    public function update(Request $request, $id) 
    {
        $servicio = Servicio::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'precio' => 'nullable|numeric|min:0',
        'descripcion' => 'nullable|string',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if($request->hasFile('foto')){
        // Eliminar foto anterior si existe
        if($servicio->foto && file_exists(public_path($servicio->foto))){
            unlink(public_path($servicio->foto));
        }

        $image = $request->file('foto');
        $name = time().'_'.$image->getClientOriginalName();
        $image->storeAs('public/servicios', $name);
        $fotoPath = 'storage/servicios/'.$name;
    } else {
        $fotoPath = $servicio->foto; // mantener la anterior
    }

    $servicio->update([
        'nombre' => $request->nombre,
        'precio' => $request->precio,
        'descripcion' => $request->descripcion,
        'foto' => $fotoPath,
    ]);

    return redirect()->route('odontologo.servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }
    
    public function destroy($id) 
    {
       // Buscar el servicio
    $servicio = Servicio::findOrFail($id);

    // Eliminar la imagen si existe
    if ($servicio->foto && file_exists(public_path($servicio->foto))) {
        unlink(public_path($servicio->foto));
    }

    // Eliminar el registro de la BD
    $servicio->delete();

    // Redirigir con mensaje
    return redirect()
        ->route('odontologo.servicios.index')
        ->with('success', 'Servicio eliminado correctamente.'); 
    }
}
