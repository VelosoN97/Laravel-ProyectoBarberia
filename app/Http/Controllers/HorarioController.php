<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $horarios = Horario::orderBy('fecha', 'asc')
            ->orderBy('hora_inicio', 'asc')
            ->get();
        return view('horarios.index', compact('horarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('horarios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'estado' => 'required|boolean',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')
            ->with('success', 'Horario creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Horario $horario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Horario $horario)
    {
        return view('horarios.edit', compact('horario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Horario $horario)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required',
            'hora_fin' => 'required|after:hora_inicio',
            'estado' => 'required|boolean',
        ]);
        $horario->update($request->all());
        return redirect()->route('horarios.index')
        ->with('success', 'Horario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Horario $horario)
    {
        $horario->delete();
        return redirect()->route('horarios.index')
        ->with('success', 'Horario eliminado correctamente.');
    }
}
