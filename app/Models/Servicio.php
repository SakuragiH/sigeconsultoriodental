<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [

        'nombre',
        'precio',
        'descripcion',
        'foto',
        
    ];


    
    public function citas()
    {
        return $this->hasMany(Cita::class);
    }

}
