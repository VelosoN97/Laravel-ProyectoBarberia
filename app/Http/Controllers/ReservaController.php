<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservas = Reserva::with([
            'user',
            'servicio',
            'horario'
        ])->get();
        return view('reservas.index', compact('reservas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $servicios = Servicio::where('estado', true)->get();
        $horarios = Horario::where('estado', true)->get();
        return view('reservas.create', compact(
            'servicios',
            'horarios'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'horario_id' => 'required|exists:horarios,id',
        ]);

        Reserva::create([
            'user_id' => Auth::id(),
            'servicio_id' => $request->servicio_id,
            'horario_id' => $request->horario_id,
            'estado' => 'Pendiente',
        ]);

        Horario::where('id', $request->horario_id)
            ->update([
                'estado' => false
            ]);

        return redirect()
            ->route('reservas.index')
            ->with(
                'success',
                'Reserva creada correctamente.'
            );
    }

    /**
     * Display the specified resource.
     */
    public function show(Reserva $reserva)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        //
    }
}
