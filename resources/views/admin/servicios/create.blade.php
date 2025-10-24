@extends('adminlte::page')

@section('content_header')
    <h1><b>Servicios / Registrar nuevo servicio</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Complete los datos del formulario</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.servicios.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- NOMBRE -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre</label><b> (*)</b>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-tag"></i></span>
                                    </div>
                                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" placeholder="Ingrese nombre del servicio..." required>
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
                                    <input type="number" name="precio" class="form-control" value="{{ old('precio') }}" placeholder="Ingrese precio..." step="0.01" min="0">
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
                                    <textarea name="descripcion" class="form-control" rows="3" placeholder="Ingrese descripción...">{{ old('descripcion') }}</textarea>
                                </div>
                                @error('descripcion')
                                    <small style="color: red">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- FOTO -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="foto">Foto</label><b> (*)</b>
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
                    </div>

                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Registrar</button>
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
