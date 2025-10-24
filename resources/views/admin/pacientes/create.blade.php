@extends('adminlte::page')

@section('content_header')
    <h1><b>Pacientes/ Registro de un nuevo paciente</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Llene los datos del formulario</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.pacientes.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                    <!-- ROL -->
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rol">Nombre del Rol</label><b> (*)</b>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                </div>

                                @php
                                    $rolPaciente = $roles->firstWhere('name', 'Paciente');
                                @endphp

                                @if($rolPaciente)
                                    <input type="text" class="form-control" value="Paciente" disabled>
                                    <input type="hidden" name="rol" value="Paciente">
                                @else
                                    <input type="text" class="form-control" value="No existe el rol Paciente" disabled>
                                    <input type="hidden" name="rol" value="">
                                @endif

                            </div>
                            @error('rol')
                                <small style="color: red">{{ $message }}</small>
                            @enderror
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
                                    <input type="text" name="nombres" class="form-control" value="{{ old('nombres') }}" placeholder="Ingrese nombres..." required>
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
                                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}" placeholder="Ingrese apellidos..." required>
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
                                    <input type="text" name="ci" class="form-control" value="{{ old('ci') }}" placeholder="Ingrese C.I..." required>
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
                                    <input type="date" name="fecha_nacimiento" class="form-control" value="{{ old('fecha_nacimiento') }}" required>
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
                                    <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" placeholder="Ingrese teléfono..." required>
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
                                        <option value="Masculino" {{ old('genero') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                        <option value="Femenino" {{ old('genero') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                        <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Otro</option>
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
                                    <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" placeholder="Ingrese dirección..." required>
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
                                    <input type="file" name="foto" id="fotoInput" class="form-control" required>
                                </div>
                                <img id="preview" src="#" alt="Vista previa" style="max-width:200px; display:none; margin-top:10px; border-radius:5px;">
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
                                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Ingrese correo..." required>
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
                                <button type="submit" class="btn btn-primary">Registrar</button>
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

@section('css')
@stop

@section('js')
<script>
    document.getElementById('fotoInput').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@stop



