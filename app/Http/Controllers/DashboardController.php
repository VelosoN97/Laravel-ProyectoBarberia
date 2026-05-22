<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalReservas = Reserva::count();

        $reservasPendientes = Reserva::where(
            'estado',
            'Pendiente'
        )->count();

        $reservasCompletadas = Reserva::where(
            'estado',
            'Completada'
        )->count();

        $totalClientes = User::where(
            'role',
            'cliente'
        )->count();

        $ingresos = Reserva::where(
            'estado',
            'Completada'
        )
            ->with('servicio')
            ->get()
            ->sum(function ($reserva) {

                return $reserva->servicio->precio;
            });

        return view('dashboard.index', compact(
            'totalReservas',
            'reservasPendientes',
            'reservasCompletadas',
            'totalClientes',
            'ingresos'
        ));
    }
}
