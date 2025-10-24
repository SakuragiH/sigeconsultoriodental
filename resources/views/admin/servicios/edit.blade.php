@extends('adminlte::page')

@section('content_header')
    <h1><b>Servicios / Editar servicio</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Actualice los datos del servicio</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.servicios.update', $servicio->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <!-- NOMBRE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    </div>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $servicio->nombre) }}" required>
                                </div>
                                @error('nombre')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- PRECIO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>
                                    <input type="number" name="precio" class="form-control" value="{{ old('precio', $servicio->precio) }}" step="0.01" min="0">
                                </div>
                                @error('precio')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- DESCRIPCION -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-align-left"></i></span>
                                    </div>
                                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                                </div>
                                @error('descripcion')
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
                                    <input type="file" name="foto" id="fotoInput" class="form-control">
                                </div>

                                <!-- Foto actual -->
                                <div style="margin-bottom:10px;">
                                    <p><b>Foto actual:</b></p>
                                    <img src="{{ $servicio->foto ? url($servicio->foto) : url('storage/servicios/default.png') }}" alt="Foto actual" style="max-width:200px; border-radius:5px;">
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
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                                <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">Cancelar</a>
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
