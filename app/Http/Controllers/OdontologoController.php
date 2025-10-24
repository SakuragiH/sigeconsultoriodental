<?php

namespace App\Http\Controllers;

use App\Models\Odontologo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class OdontologoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $odontologos = Odontologo::all();
        return view('admin.odontologos.index', compact('odontologos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.odontologos.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$datos = $request->all();
        //return response()->json($datos);
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'formacion' => 'required|string|max:255',
            'foto' => 'required|image',
            'rol' => 'required',
            'email' => 'required|email|unique:users,email', 
            ]);

            $rolNombre = 'Odontologo'; // rol fijo para este módulo

            // Verificar que el rol exista
            if(!Role::where('name', $rolNombre)->exists()){
                return redirect()->back()
                    ->with('error', 'No existe el rol '.$rolNombre.', por favor créelo primero.');
            }

            $usuario = new User();  
            $usuario->name = $request->nombres." ".$request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->telefono);
            $usuario->save();

            $usuario->assignRole($rolNombre);

            //crear odontologo
            $odontologo = new Odontologo();
            $odontologo->usuario_id = $usuario->id;
            $odontologo->nombres = $request->nombres;
            $odontologo->apellidos = $request->apellidos;
            $odontologo->telefono = $request->telefono;
            $odontologo->direccion = $request->direccion;
            $odontologo->especialidad = $request->especialidad;
            $odontologo->formacion = $request->formacion;
            
            // Manejo de la subida de la foto
            $foto = $request->file('foto');
            $nombreArchivo = time().'_'.$foto->getClientOriginalName();
            $rutaDestino = public_path('uploads/fotos_odontologos');
            $foto->move($rutaDestino, $nombreArchivo);
            $fotopath = 'uploads/fotos_odontologos/'.$nombreArchivo;
            $odontologo->foto = $fotopath;

            $odontologo->save();

            return redirect()->route('admin.odontologos.index')
            ->with('success', 'Odontólogo creado exitosamente.')
            ->with('icono', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $odontologo = Odontologo::find($id);
        return view('admin.odontologos.show', compact('odontologo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $odontologo = Odontologo::find($id);
        $roles = Role::all();
        return view('admin.odontologos.edit', compact('odontologo', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $odontologo = Odontologo::find($id);
        $usuario = User::find($odontologo->usuario_id);

        // Validación
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'especialidad' => 'required|string|max:255',
            'formacion' => 'nullable|string|max:255',
            'foto' => 'nullable|image',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
        ]);

        // Actualizar usuario
        $usuario->name = $request->nombres . " " . $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->telefono); // opcional, según tu lógica
        $usuario->save();

        $usuario->syncRoles($request->rol);

        // Actualizar odontólogo
        $odontologo->usuario_id = $usuario->id;
        $odontologo->nombres = $request->nombres;
        $odontologo->apellidos = $request->apellidos;
        $odontologo->telefono = $request->telefono;
        $odontologo->direccion = $request->direccion;
        $odontologo->especialidad = $request->especialidad;
        $odontologo->formacion = $request->formacion;

        // Manejo de foto
        if ($request->hasFile('foto')) {
            // Eliminar foto anterior si existe
            if ($odontologo->foto && file_exists(public_path($odontologo->foto))) {
                unlink(public_path($odontologo->foto));
            }

            // Subir nueva foto
            $foto = $request->file('foto');
            $nombreArchivo = time() . '_' . $foto->getClientOriginalName();
            $rutaDestino = public_path('uploads/fotos_odontologos');
            $foto->move($rutaDestino, $nombreArchivo);
            $odontologo->foto = 'uploads/fotos_odontologos/' . $nombreArchivo;
        }

        $odontologo->save();

        return redirect()->route('admin.odontologos.index')
            ->with('success', 'Se actualizó los datos del odontólogo exitosamente.')
            ->with('icono', 'success');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $odontologo = Odontologo::find($id);
        $usuario = User::find($odontologo->usuario_id);

        // Eliminar foto si existe
        if ($odontologo->foto && file_exists(public_path($odontologo->foto))) {
            unlink(public_path($odontologo->foto));
        }

        // Eliminar odontólogo y usuario asociado
        $odontologo->delete();
        $usuario->delete();

        return redirect()->route('admin.odontologos.index')
            ->with('success', 'Odontólogo eliminado exitosamente.')
            ->with('icono', 'success');
    }
}
