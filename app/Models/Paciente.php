<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'ci',
        'telefono',
        'direccion',
        'fecha_nacimiento',
        'genero',
        'foto',
        'estado',  
    ];

    // Relación con el modelo User Un Paciente solamente puede tener un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el modelo Cita Un Paciente puede tener muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
    
    // Relación con el modelo HistorialMedico
    public function historialesMedicos() {
    return $this->hasMany(HistorialMedico::class);
    }

    // Relación con el modelo Prescripcion
    public function prescripciones() {
        return $this->hasMany(Prescripcion::class);
    }

     // Helper: Nombre completo del paciente
    public function nombreCompleto()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}
