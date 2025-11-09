@extends('adminlte::page')

@section('content_header')
    <h1><b>Odontólogos / Editar odontólogo</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Modifique los datos necesarios</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.odontologos.update', $odontologo->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- ROL -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="rol">Nombre del Rol</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                    </div>
                                    <select name="rol" class="form-control" style="pointer-events: none">
                                        @foreach ($roles as $rol)
                                            <option value="{{ $rol->name }}" 
                                                {{ $rol->name == 'Odontologo' ? 'selected' : '' }}>
                                                {{ $rol->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- NOMBRES -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nombres">Nombres</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="nombres" 
                                           value="{{ old('nombres', $odontologo->nombres) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- APELLIDOS -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="apellidos">Apellidos</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-user-friends"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="apellidos" 
                                           value="{{ old('apellidos', $odontologo->apellidos) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- TELEFONO -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="telefono" 
                                           value="{{ old('telefono', $odontologo->telefono) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- DIRECCION -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="direccion">Dirección</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="direccion" 
                                           value="{{ old('direccion', $odontologo->direccion) }}" required>
                                </div>
                            </div>
                        </div>

                        <!-- ESPECIALIDAD -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="especialidad">Especialidad</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tooth"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="especialidad" 
                                           value="{{ old('especialidad', $odontologo->especialidad) }}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- FORMACION -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="formacion">Formación</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="formacion" 
                                           value="{{ old('formacion', $odontologo->formacion) }}">
                                </div>
                            </div>
                        </div>

                        <!-- FOTO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    </div>
                                    <input type="file" class="form-control" name="foto" id="fotoInput" onchange="previewFoto(event)">
                                </div>

                                <!-- Foto actual -->
                                @if($odontologo->foto)
                                    <p>Foto actual:</p>
                                    <img src="{{ asset('storage/odontologos/'.$odontologo->foto) }}" 
                                         alt="Foto" 
                                         style="max-width: 200px; border-radius: 5px;">
                                @endif

                                <!-- Previsualización -->
                                <img id="preview" src="#" alt="Vista previa" 
                                     style="max-width: 200px; display: none; margin-top: 10px; border-radius: 5px;">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- EMAIL -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" 
                                           value="{{ old('email', $odontologo->usuario->email ?? '') }}" required>
                                </div>
                            </div>

                            <!-- ESTADO -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                        </div>
                                        <select name="estado" class="form-control">
                                            <option value="activo" {{ old('estado', $odontologo->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                            <option value="inactivo" {{ old('estado', $odontologo->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <a href="{{ route('admin.odontologos.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
    function previewFoto(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@stop
