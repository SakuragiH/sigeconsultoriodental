<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odontologo extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'telefono',
        'direccion',
        'especialidad',
        'formacion',
        'foto',
        'estado',  
    ];


    // Relación con el modelo User Un odontólogo solamente puede tener un usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el modelo Cita Un odontólogo puede tener muchas citas
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }


    // Relación con el modelo Horario Un odontólogo puede tener muchos horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    // Relación con el modelo OdontologoFormacion Un odontólogo puede tener muchas formaciones
    public function formaciones()
{
    return $this->hasMany(OdontologoFormacion::class);
}

}
