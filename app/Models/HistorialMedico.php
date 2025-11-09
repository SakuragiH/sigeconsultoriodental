<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_id',
        'paciente_id',
        'diagnostico',
        'tratamiento',
        'observaciones_paciente',
        'archivo_path',
        'archivo_nombre_original',
    ];



     // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con Cita (opcional)
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    // En HistorialMedico.php
    public function prescripciones() 
    {
    return $this->hasMany(Prescripcion::class, 'historial_id');
    }

}
