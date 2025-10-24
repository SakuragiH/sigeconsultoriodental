@extends('layouts.odontologo')

@section('title', 'Formaciones')

@section('content')
<div class="page-title">
    <h2>Formaciones del Dr. {{ Auth::user()->name }}</h2>
</div>

<div class="formaciones-container">
    <a href="{{ route('odontologo.formaciones.create') }}" class="btn-add">
        <i class="fas fa-plus"></i> Agregar Formación
    </a>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @if($formaciones->isEmpty())
        <p>No hay formaciones registradas.</p>
    @else
        <div class="grid-formaciones">
            @foreach($formaciones as $formacion)
                <div class="card-formacion">
                    <h4>{{ $formacion->descripcion ?? 'Sin descripción' }}</h4>
                    
                    @php
                        $ext = pathinfo($formacion->archivo, PATHINFO_EXTENSION);
                    @endphp

                    @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                        <img src="{{ asset('uploads/formaciones/'.$formacion->archivo) }}" alt="Formación">
                    @elseif(strtolower($ext) === 'pdf')
                        <embed src="{{ asset('uploads/formaciones/'.$formacion->archivo) }}" type="application/pdf" width="100%" height="200px">
                    @else
                        <p>Archivo: {{ $formacion->archivo }}</p>
                    @endif

                    <form action="{{ route('odontologo.formaciones.destroy', $formacion->id) }}" method="POST" onsubmit="return confirm('¿Deseas eliminar esta formación?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete"><i class="fas fa-trash"></i> Eliminar</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
