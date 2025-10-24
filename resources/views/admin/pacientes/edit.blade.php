@extends('adminlte::page')

@section('content_header')
    <h1><b>Pacientes / Editar paciente</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualice los datos del paciente</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pacientes.update', $paciente->id) }}" method="post" enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" value="Paciente" readonly>
                                    <input type="hidden" name="rol" value="Paciente">
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
                                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres', $paciente->nombres) }}" required>
                                </div>
                                @error('nombres')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
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
                                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $paciente->apellidos) }}" required>
                                </div>
                                @error('apellidos')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- CI -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ci">C.I.</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                    </div>
                                    <input type="text" name="ci" class="form-control" value="{{ old('ci', $paciente->ci) }}" required>
                                </div>
                                @error('ci')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- FECHA NACIMIENTO -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="fecha_nacimiento">Fecha de Nacimiento</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento) }}" required>
                                </div>
                                @error('fecha_nacimiento')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
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
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono', $paciente->telefono) }}" required>
                                </div>
                                @error('telefono')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- GENERO -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="genero">Género</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                                    </div>
                                    <select name="genero" class="form-control" required>
                                        <option value="">Seleccione género...</option>
                                        <option value="Masculino" {{ old('genero', $paciente->genero) == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero', $paciente->genero) == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero', $paciente->genero) == 'Otro' ? 'selected' : '' }}>Otro</option>
                                    </select>
                                </div>
                                @error('genero')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- DIRECCION -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="direccion">Dirección</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    </div>
                                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion', $paciente->direccion) }}" required>
                                </div>
                                @error('direccion')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- FOTO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-image"></i></span>
                                    </div>
                                    <input type="file" name="foto" id="fotoInput" class="form-control">
                                </div>

                                <!-- Foto actual -->
                                <div style="margin-bottom:10px;">
                                    <p><b>Foto actual:</b></p>
                                    <img src="{{ $paciente->foto ? url($paciente->foto) : url('uploads/fotos_pacientes/default.png') }}" alt="Foto actual" style="max-width:200px; border-radius:5px;">
                                </div>

                                <!-- Previsualización nueva -->
                                <div id="previewContainer" style="display:none;">
                                    <p><b>Nueva foto seleccionada:</b></p>
                                    <img id="preview" src="#" alt="Vista previa" style="max-width:200px; border-radius:5px;">
                                </div>

                                @error('foto')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo electrónico</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $paciente->usuario->email) }}" required>
                                </div>
                                @error('email')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <a href="{{ route('admin.pacientes.index') }}" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
    document.getElementById('fotoInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('preview');
            const previewContainer = document.getElementById('previewContainer');
            preview.src = URL.createObjectURL(file);
            previewContainer.style.display = 'block';
        }
    });
</script>
@stop


