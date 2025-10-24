<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'odontologo_id',
        'servicio_id',
        'horario_id',
        'motivo',
        'observaciones',
        'estado',
    ];

    // Relaciones

    // Relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class);
    }

    // Relación con Odontologo
    public function odontologo()
    {
        return $this->belongsTo(Odontologo::class);
    }

    // Relación con Servicio
    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }

    // Relación con Horario
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

     // 🔹 Relación corregida
    public function historialesMedicos()
    {
        return $this->hasMany(HistorialMedico::class, 'cita_id');
    }
}
