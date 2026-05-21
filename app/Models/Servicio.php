<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'duracion',
        'estado'
    ];

    public function reservas(){
        return $this->hasMany(Reserva::class);
    }
}
