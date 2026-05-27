<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\User;
use App\Models\Servicio;

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

        $pendientes = Reserva::where(
            'estado',
            'Pendiente'
        )->count();

        $confirmadas = Reserva::where(
            'estado',
            'Confirmada'
        )->count();

        $completadas = Reserva::where(
            'estado',
            'Completada'
        )->count();

        $canceladas = Reserva::where(
            'estado',
            'Cancelada'
        )->count();

        $serviciosPopulares = Servicio::withCount('reservas')
            ->orderBy('reservas_count', 'desc')
            ->take(5)
            ->get();

        $ultimasReservas = Reserva::with([
            'user',
            'servicio',
            'horario'
        ])
        ->latest()
        ->take(5)
        ->get();

        return view('dashboard.index', compact(
            'totalReservas',
            'reservasPendientes',
            'reservasCompletadas',
            'totalClientes',
            'ingresos',
            'pendientes',
            'confirmadas',
            'completadas',
            'canceladas',
            'serviciosPopulares',
            'ultimasReservas'
        ));
    }
}
