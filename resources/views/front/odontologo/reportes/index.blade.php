@extends('layouts.odontologo')

@section('content')
<div class="container mt-5">
    <div class="row">

        {{-- Reporte de Pacientes --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('odontologo.reportes.pacientes') }}" class="card text-white h-100 text-decoration-none" style="background-color: #36808B;">
                <div class="card-body text-center">
                    <i class="fas fa-user fa-2x mb-2"></i>
                    <h5 class="card-title">Pacientes</h5>
                </div>
            </a>
        </div>

        {{-- Reporte de Citas --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('odontologo.reportes.citas') }}" class="card text-white h-100 text-decoration-none" style="background-color: #5DA6A6;">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-check fa-2x mb-2"></i>
                    <h5 class="card-title">Citas</h5>
                </div>
            </a>
        </div>

        {{-- Reporte de Horarios --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('odontologo.reportes.horarios') }}" class="card text-white h-100 text-decoration-none" style="background-color: #12403B;">
                <div class="card-body text-center">
                    <i class="fas fa-clock fa-2x mb-2"></i>
                    <h5 class="card-title">Horarios</h5>
                </div>
            </a>
        </div>

        {{-- Reporte de Servicios --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('odontologo.reportes.servicios') }}" class="card text-white h-100 text-decoration-none" style="background-color: #36808B;">
                <div class="card-body text-center">
                    <i class="fas fa-concierge-bell fa-2x mb-2"></i>
                    <h5 class="card-title">Servicios</h5>
                </div>
            </a>
        </div>

        {{-- Reporte de Historial Médico --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('odontologo.reportes.historialesmedicos') }}" class="card text-white h-100 text-decoration-none" style="background-color: #1A1D22;">
                <div class="card-body text-center">
                    <i class="fas fa-notes-medical fa-2x mb-2"></i>
                    <h5 class="card-title">Historial Médico</h5>
                </div>
            </a>
        </div>

        {{-- Reporte de Medicamentos --}}
        <div class="col-md-4 mb-3">
            <a href="{{ route('odontologo.reportes.medicamentos') }}" class="card text-white h-100 text-decoration-none" style="background-color: #5DA6A6;">
                <div class="card-body text-center">
                    <i class="fas fa-pills fa-2x mb-2"></i>
                    <h5 class="card-title">Medicamentos</h5>
                </div>
            </a>
        </div>

    </div>

    {{-- Gráficas estadísticas --}}
    <h3 class="mt-5">Estadísticas</h3>
    <div class="row mt-3">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-white" style="background-color: #36808B;">Pacientes por mes</div>
                <div class="card-body">
                    <canvas id="pacientesChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-white" style="background-color: #5DA6A6;">Citas por estado</div>
                <div class="card-body">
                    <canvas id="citasChart" style="height:300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pacientes por mes
    const pacientesCtx = document.getElementById('pacientesChart').getContext('2d');
    const pacientesChart = new Chart(pacientesCtx, {
        type: 'bar',
        data: {
            labels: @json(array_map(function($m){ return \Carbon\Carbon::create()->month($m)->format('F'); }, $pacientesPorMes->keys()->toArray())),
            datasets: [{
                label: 'Pacientes',
                data: @json($pacientesPorMes->values()),
                backgroundColor: '#36808B'
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // Citas por estado
    const citasCtx = document.getElementById('citasChart').getContext('2d');
    const citasChart = new Chart(citasCtx, {
        type: 'pie',
        data: {
            labels: @json($citasPorEstado->keys()),
            datasets: [{
                label: 'Citas',
                data: @json($citasPorEstado->values()),
                backgroundColor: ['#36808B','#5DA6A6','#12403B']
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
});
</script>
@endpush
