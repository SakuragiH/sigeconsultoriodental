@extends('adminlte::page')

@section('content_header')
    <h1><b>Servicios / Detalles del servicio</b></h1>
    <hr>
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Información detallada del servicio</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- FOTO -->
                    <div class="col-md-4 text-center">
                        <img src="{{ $servicio->foto ? url($servicio->foto) : url('storage/servicios/default.png') }}" 
                            alt="Foto del servicio" style="max-width: 250px; border-radius:5px;">
                    </div>

                    <!-- DATOS -->
                    <div class="col-md-8">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>Nombre</th>
                                    <td>{{ $servicio->nombre }}</td>
                                </tr>
                                <tr>
                                    <th>Precio</th>
                                    <td>
                                        @if($servicio->precio)
                                            {{ $servicio->moneda == 'USD' ? '$' : 'Bs' }} {{ number_format($servicio->precio, 2) }}
                                        @else
                                            No aplica
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Descripción</th>
                                    <td>{{ $servicio->descripcion ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Creado</th>
                                    <td>{{ $servicio->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Actualizado</th>
                                    <td>{{ $servicio->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- BOTÓN VOLVER ABAJO IZQUIERDA -->
                <div class="row mt-3">
                    <div class="col-md-12 text-left">
                        <a href="{{ route('admin.servicios.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@stop

