<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
    'odontologo_id',
    'fecha',
    'dia',
    'hora_inicio',
    'hora_fin',
    'disponible'
];





    // Relación con el modelo Cita
    public function citas()
    {
        return $this->hasMany(Cita::class, 'horario_id');
    }


    // Relación con el modelo Odontologo
    public function odontologo()
    {
        return $this->belongsTo(Odontologo::class);
    }

}
