<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class PacienteController extends Controller
{
    public function index()
    {
        $pacientes = Paciente::all();
        return view('admin.pacientes.index', compact('pacientes'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.pacientes.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'ci' => 'required|unique:pacientes',
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rol' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        // Crear usuario
        $usuario = User::create([
            'name' => $request->nombres.' '.$request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->telefono)
        ]);
        $usuario->assignRole($request->rol);

        // Manejo de foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreArchivo = time().'_'.$foto->getClientOriginalName();
            $foto->storeAs('public/pacientes', $nombreArchivo);
        } else {
            $nombreArchivo = 'usuariopordefecto.png';
        }

        // Crear paciente
        Paciente::create([
            'usuario_id' => $usuario->id,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
            'foto' => $nombreArchivo,
        ]);

        return redirect()->route('admin.pacientes.index')
            ->with('success', 'Paciente creado exitosamente.')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        $roles = Role::all();
        return view('admin.pacientes.show', compact('paciente', 'roles'));
    }

    public function edit($id)
    {
        $paciente = Paciente::findOrFail($id);
        $roles = Role::all();
        return view('admin.pacientes.edit', compact('paciente', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $usuario = $paciente->usuario;

        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'ci' => 'required|unique:pacientes,ci,'.$id,
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
            'rol' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
        ]);

        // Actualizar usuario
        $usuario->update([
            'name' => $request->nombres.' '.$request->apellidos,
            'email' => $request->email,
            'password' => Hash::make($request->telefono)
        ]);
        $usuario->syncRoles($request->rol);

        // Manejo de foto
        if ($request->hasFile('foto')) {
            if ($paciente->foto && $paciente->foto != 'usuariopordefecto.png') {
                Storage::delete('public/pacientes/' . $paciente->foto);
            }
            $foto = $request->file('foto');
            $nombreArchivo = time().'_'.$foto->getClientOriginalName();
            $foto->storeAs('public/pacientes', $nombreArchivo);
            $paciente->foto = $nombreArchivo;
        }

        // Actualizar paciente
        $paciente->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'ci' => $request->ci,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion,
            'genero' => $request->genero,
            'foto' => $paciente->foto ?? 'usuariopordefecto.png',
        ]);

        return redirect()->route('admin.pacientes.index')
            ->with('success', 'Paciente se actualizó exitosamente.')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $usuario = $paciente->usuario;

        if ($paciente->foto && $paciente->foto != 'usuariopordefecto.png') {
            Storage::delete('public/pacientes/' . $paciente->foto);
        }

        if ($usuario) {
            $usuario->syncRoles([]);
            $usuario->delete();
        }

        $paciente->delete();

        return redirect()->route('admin.pacientes.index')
            ->with('success', 'Paciente eliminado exitosamente.')
            ->with('icono', 'success');
    }
}
