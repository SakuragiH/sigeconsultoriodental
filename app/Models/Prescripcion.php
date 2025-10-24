<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescripcion extends Model
{
    use HasFactory;

    protected $fillable = [
        'historial_id',
        'medicamento_id',
        'dosis',
        'observaciones',
    ];

    // Relación con Historial Médico
    public function historial()
    {
        return $this->belongsTo(HistorialMedico::class, 'historial_id');
    }

    // Relación con Medicamento
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }
}
