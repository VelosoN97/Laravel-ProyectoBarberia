<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Servicio;
use App\Models\Horario;

class Reserva extends Model
{
    protected $fillable = [
        'user_id',
        'servicio_id',
        'horario_id',
        'estado'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }

    public function horario(){
        return $this->belongsTo(Horario::class);
    }
}
