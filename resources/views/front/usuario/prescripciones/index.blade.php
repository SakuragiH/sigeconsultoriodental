@extends('layouts.usuario')

@section('title', 'Prescripciones')

@section('content')
<div class="container mt-4">
    <h2 style="color:#12403B; font-weight:600;">Prescripciones</h2>

    @if($prescripciones->isEmpty())
        <div class="alert alert-info text-center">
            No tienes prescripciones aún.
        </div>
    @else
        <div class="table-responsive mt-3">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Fecha</th>
                        <th>Medicamento</th>
                        <th>Dosis</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescripciones as $prescripcion)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($prescripcion->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $prescripcion->medicamento->nombre }}</td>
                            <td>{{ $prescripcion->dosis }}</td>
                            <td>
                                <a href="{{ route('usuario.prescripciones.pdf', $prescripcion->id) }}" 
                                   class="btn btn-sm btn-primary" 
                                   target="_blank">
                                   <i class="fas fa-file-pdf"></i> Descargar PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
