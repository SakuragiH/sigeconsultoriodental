@extends('adminlte::page')


@section('content_header')
    <h1>Inicio</h1>
    <hr>
@stop

@section('content')
    <div class="row">
    <!-- Odontólogos -->
    <div class="col-md-3">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalOdontologos }}</h3>
                <p>Odontólogos</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-md"></i>
            </div>
            <a href="{{ route('admin.odontologos.index') }}" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Pacientes -->
    <div class="col-md-3">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalPacientes }}</h3>
                <p>Pacientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-user"></i>
            </div>
            <a href="{{ route('admin.pacientes.index') }}" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Citas -->
    <div class="col-md-3">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalCitas }}</h3>
                <p>Citas</p>
            </div>
            <div class="icon">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="{{ route('admin.citas.index') }}" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <!-- Medicamentos -->
    <div class="col-md-3">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalMedicamentos }}</h3>
                <p>Medicamentos</p>
            </div>
            <div class="icon">
                <i class="fas fa-pills"></i>
            </div>
            <a href="{{ route('admin.medicamentos.index') }}" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row mt-3">
    <!-- Horarios -->
    <div class="col-md-3">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalHorarios }}</h3>
                <p>Horarios</p>
            </div>
            <div class="icon">
                <i class="fas fa-clock"></i>
            </div>
            <a href="{{ route('admin.horarios.index') }}" class="small-box-footer">
                Más info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="row">
    <!-- Gráfico de citas por odontólogo -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Citas por Odontólogo</h3>
            </div>
            <div class="card-body">
                <canvas id="citasChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Gráfico de citas por paciente -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Citas por Paciente</h3>
            </div>
            <div class="card-body">
                <canvas id="citasPacienteChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>




@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Citas por odontólogo
    new Chart(document.getElementById('citasChart'), {
        type: 'bar',
        data: {
            labels: @json($labelsOdontologo),
            datasets: [{
                label: 'Número de citas',
                data: @json($dataOdontologo),
                backgroundColor: 'rgba(54, 128, 139, 0.7)',
            }]
        },
        options: { responsive: true }
    });

    // Citas por paciente
    new Chart(document.getElementById('citasPacienteChart'), {
        type: 'bar',
        data: {
            labels: @json($labelsPaciente),
            datasets: [{
                label: 'Número de citas',
                data: @json($dataPaciente),
                backgroundColor: 'rgba(93, 166, 166, 0.7)',
            }]
        },
        options: { responsive: true }
    });
</script>

@stop
