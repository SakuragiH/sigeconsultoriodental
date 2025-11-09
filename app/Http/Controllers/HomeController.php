<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Horario;
use App\Models\Medicamento;
use App\Models\Odontologo;
use App\Models\Paciente;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $totalOdontologos = Odontologo::count();
        $totalPacientes = Paciente::count();
        $totalCitas = Cita::count();
        $totalMedicamentos = Medicamento::count();
        $totalHorarios = Horario::count(); // si quieres, puedes cambiar a otro modelo de agenda si tienes

         // Datos para gráficos
        // Citas por odontólogo
        $labelsOdontologo = Odontologo::pluck('nombres');
        $dataOdontologo   = Odontologo::withCount('citas')->pluck('citas_count');

        // Citas por paciente
        $labelsPaciente = Paciente::pluck('nombres');
        $dataPaciente   = Paciente::withCount('citas')->pluck('citas_count');


        return view('home', compact(
            'totalOdontologos',
            'totalPacientes',
            'totalCitas',
            'totalMedicamentos',
            'totalHorarios',
            'labelsOdontologo',
            'dataOdontologo',
            'labelsPaciente',
            'dataPaciente'
        ));
    }
}
