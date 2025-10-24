<?php

namespace App\Http\Controllers;

use App\Models\Odontologo;
use App\Models\Servicio;
use Illuminate\Http\Request;

class PaginasController extends Controller
{
    public function nosotros()
    {
        // Traemos todos los odontólogos con sus formaciones
        $odontologos = Odontologo::with('formaciones')->get();
        return view('paginas.nosotros', compact('odontologos'));
    }

    public function servicios()
    {
        // Traer todos los servicios activos (si no tienes 'activo', usamos todos)
        $servicios = Servicio::all();

        // Enviar los servicios a la vista pública
        return view('paginas.servicios', compact('servicios'));


    }

}