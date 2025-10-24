<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OdontologoFormacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'odontologo_id',
        'archivo',
        'descripcion'
    ];

    public function odontologo()
    {
        return $this->belongsTo(Odontologo::class);
    }
}
