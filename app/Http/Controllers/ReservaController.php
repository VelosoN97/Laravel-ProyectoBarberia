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
        if (Auth::user()->role == 'admin') {

            $reservas = Reserva::with([
                'user',
                'servicio',
                'horario'
            ])->get();
        } else {

            $reservas = Reserva::with([
                'user',
                'servicio',
                'horario'
            ])
                ->where('user_id', Auth::id())
                ->get();
        }
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
        $servicios = Servicio::where('estado', true)->get();
        $horarios = Horario::where('estado', true)
            ->orWhere('id', $reserva->horario_id)
            ->get();
        return view('reservas.edit', compact('reserva', 'servicios', 'horarios'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reserva $reserva)
    {
        $request->validate([
            'servicio_id' => 'required|exists:servicios,id',
            'horario_id' => 'required|exists:horarios,id',
            'estado' => 'required'
        ]);
        if ($reserva->horario_id != $request->horario_id) {
            Horario::where('id', $reserva->horario_id)->update(['estado' => true]);
            Horario::where('id', $request->horario_id)->update(['estado' => false]);
        }
        $reserva->update([
            'servicio_id' => $request->servicio_id,
            'horario_id' => $request->horario_id,
            'estado' => $request->estado
        ]);
        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reserva $reserva)
    {
        Horario::where('id', $reserva->horario_id)
            ->update([
                'estado' => true
            ]);

        $reserva->delete();

        return redirect()
            ->route('reservas.index')
            ->with(
                'success',
                'Reserva eliminada correctamente.'
            );
    }
}
