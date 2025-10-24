@extends('layouts.odontologo')

@section('title', 'Servicios Odontólogo')

@section('content')
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 style="color:#12403B;">Servicios Disponibles</h2>
        <a href="{{ route('odontologo.servicios.create') }}" 
           class="btn" 
           style="background-color:#36808B; color:#ffffff;">
            <i class="fas fa-plus"></i> Agregar Servicio
        </a>
    </div>

    <table class="table table-bordered table-striped" style="background-color:#f8f9fa;">
        <thead style="background-color:#5DA6A6; color:#ffffff;">
            <tr>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Descripción</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servicios as $servicio)
            <tr>
                <td>{{ $servicio->nombre }}</td>
                <td>${{ number_format($servicio->precio, 2) }}</td>
                <td>{{ $servicio->descripcion }}</td>
                <td>
                    <img 
                        src="{{ $servicio->foto ? (str_starts_with($servicio->foto,'storage') ? url($servicio->foto) : url('storage/'.$servicio->foto)) : url('storage/servicios/default.png') }}" 
                        alt="{{ $servicio->nombre }}" 
                        width="80" height="80" 
                        style="object-fit:cover; border-radius:5px;"
                    >
                </td>
                <td>
                    <!-- Ver -->
                    <a href="{{ route('odontologo.servicios.show', $servicio->id) }}" 
                       class="btn btn-sm" 
                       style="background-color:#1A1D22; color:#ffffff;" 
                       title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>

                    <!-- Editar -->
                    <a href="{{ route('odontologo.servicios.edit', $servicio->id) }}" 
                       class="btn btn-sm" 
                       style="background-color:#36808B; color:#ffffff;" 
                       title="Editar">
                        <i class="fas fa-pen"></i>
                    </a>

                    <!-- Eliminar -->
                    <form action="{{ route('odontologo.servicios.destroy', $servicio->id) }}" 
                          method="POST" class="form-delete" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="btn btn-sm" 
                                style="background-color:#12403B; color:#ffffff;" 
                                title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
