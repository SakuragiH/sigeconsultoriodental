@extends('layouts.odontologo')

@section('title', 'Perfil Odontólogo')

@section('content')
<div class="perfil-page">

    <div class="perfil-column preview">
        <div class="card perfil-card">
            <div class="perfil-foto">
                @if($odontologo->foto)
                    <img src="{{ asset('storage/odontologos/'.$odontologo->foto) }}" alt="Foto Odontólogo">
                @else
                    <img src="{{ asset('img/default-avatar.png') }}" alt="Foto Odontólogo">
                @endif
            </div>
            <h2>{{ $odontologo->nombres }} {{ $odontologo->apellidos }}</h2>
        </div>

        <div class="card perfil-card">
            <p><strong>Teléfono:</strong> {{ $odontologo->telefono ?? 'No registrado' }}</p>
        </div>

        <div class="card perfil-card">
            <p><strong>Dirección:</strong> {{ $odontologo->direccion ?? 'No registrada' }}</p>
        </div>

        <div class="card perfil-card">
            <p><strong>Especialidad:</strong> {{ $odontologo->especialidad ?? 'No registrada' }}</p>
        </div>

        <div class="card perfil-card">
            <h3>Formaciones</h3>

            @if($formaciones->isEmpty())
                <p>No hay formaciones registradas.</p>
            @else
                <div class="formaciones-grid">
                    @foreach($formaciones as $formacion)
                        <div class="formacion-item">
                            <p><strong>{{ $formacion->descripcion ?? 'Sin descripción' }}</strong></p>

                            @php
                                $ext = pathinfo($formacion->archivo, PATHINFO_EXTENSION);
                            @endphp

                            @if(in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ asset('storage/'.$formacion->archivo) }}" alt="Formación">
                            @elseif(strtolower($ext) === 'pdf')
                                <iframe src="{{ asset('storage/'.$formacion->archivo) }}" width="100%" height="250px"></iframe>
                            @else
                                <p>Archivo: {{ $formacion->archivo }}</p>
                            @endif

                            <form action="{{ route('odontologo.formaciones.destroy', $formacion->id) }}" method="POST" class="form-delete">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-eliminar">Eliminar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="nueva-formacion">
                <h4>Agregar nueva formación</h4>
                <form action="{{ route('odontologo.formaciones.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="descripcion">Descripción o título:</label>
                        <input type="text" name="descripcion" id="descripcion" placeholder="Ej: Título en ortodoncia" required>
                    </div>
                    <div class="form-group">
                        <label for="archivo">Archivo (PDF o imagen):</label>
                        <input type="file" name="archivo" id="archivo" accept=".pdf,.jpg,.jpeg,.png,.gif" required>
                    </div>
                    <button type="submit" class="btn-agregar">Subir Formación</button>
                </form>
            </div>
        </div>
    </div>

    <div class="perfil-column edit">
        <div class="card perfil-card">
            <h3>Editar Perfil</h3>
            <form action="{{ route('odontologo.perfil.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label>Nombres</label>
                    <input type="text" name="nombres" value="{{ $odontologo->nombres }}" required>
                </div>
                <div class="form-group">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" value="{{ $odontologo->apellidos }}" required>
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" value="{{ $odontologo->telefono }}">
                </div>
                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" value="{{ $odontologo->direccion }}">
                </div>
                <div class="form-group">
                    <label>Especialidad</label>
                    <input type="text" name="especialidad" value="{{ $odontologo->especialidad }}">
                </div>
                <div class="form-group">
                    <label>Foto</label>
                    <input type="file" name="foto" accept="image/*" onchange="previewFoto(event)">
                </div>
                <div class="form-group">
                    <label>Previsualización:</label>
                    <div>
                        <img id="foto-preview" 
                             src="{{ $odontologo->foto ? asset('storage/odontologos/'.$odontologo->foto) : asset('img/default-avatar.png') }}" 
                             alt="Previsualización" 
                             style="max-width: 200px; border-radius: 8px; margin-top: 10px;">
                    </div>
                </div>
                <button type="submit" class="btn-guardar">Guardar Cambios</button>
            </form>
        </div>
    </div>

</div>

<script>
    function previewFoto(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('foto-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
