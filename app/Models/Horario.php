<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
        'fecha',
        'hora_inicio',
        'hora_fin',
        'estado',
    ];

    public function reservas()
    {
        return $this->hasMany(Reserva::class);
    }
}
