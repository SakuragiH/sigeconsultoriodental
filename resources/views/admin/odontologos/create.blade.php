@extends('adminlte::page')

@section('content_header')
    <h1><b>Odontólogos / Registro de un nuevo odontólogo</b></h1>
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
                    <form action="{{ route('admin.odontologos.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- SELECCION ROL -->
                            <!-- SELECCION ROL -->
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="rol">Rol asignado</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user-check"></i></span>
                                        </div>
                                        <!-- Mostrar el rol visualmente -->
                                        <input type="text" class="form-control" value="Odontologo" disabled>
                                        <!-- Valor real que se envía al servidor -->
                                        <input type="hidden" name="rol" value="Odontologo">
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
                                        <input type="text" class="form-control" name="nombres" value="{{ old('nombres') }}" placeholder="Ingrese nombres..." required>
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
                                        <input type="text" class="form-control" name="apellidos" value="{{ old('apellidos') }}" placeholder="Ingrese apellidos..." required>
                                    </div>
                                    @error('apellidos')
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
                                        <input type="text" class="form-control" name="telefono" value="{{ old('telefono') }}" placeholder="Ingrese teléfono..." required>
                                    </div>
                                    @error('telefono')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
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
                                        <input type="text" class="form-control" name="direccion" value="{{ old('direccion') }}" placeholder="Ingrese dirección..." required>
                                    </div>
                                    @error('direccion')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
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
                                        <input type="text" class="form-control" name="especialidad" value="{{ old('especialidad') }}" placeholder="Ingrese especialidad..." required>
                                    </div>
                                    @error('especialidad')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
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
                                        <input type="text" class="form-control" name="formacion" value="{{ old('formacion') }}" placeholder="Ingrese formación...">
                                    </div>
                                    @error('formacion')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
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
                                        <input type="file" class="form-control" name="foto" id="fotoInput" required>
                                    </div>
                                    <!-- Previsualización -->
                                    <img id="preview" src="#" alt="Vista previa" style="max-width: 200px; display: none; margin-top: 10px; border-radius: 5px;">
                                    @error('foto')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- EMAIL -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label><b> (*)</b>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        </div>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Ingrese correo..." required>
                                    </div>
                                    @error('email')
                                        <small style="color: red">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                                                    <!-- ESTADO -->
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="estado">Estado</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-toggle-on"></i></span>
                                            </div>
                                            <select name="estado" class="form-control" disabled>
                                                <option value="activo" selected>Activo</option>
                                            </select>
                                        </div>
                                        <input type="hidden" name="estado" value="activo">
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
    // Previsualización de la foto
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


