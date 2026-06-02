<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Servicio;
use App\Models\Horario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaCreadaMail;
use App\Mail\CambioEstadoReservaMail;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reserva::with([
            'user',
            'servicio',
            'horario'
        ]);

        if (Auth::user()->role != 'admin') {

            $query->where(
                'user_id',
                Auth::id()
            );
        }

        if ($request->filled('buscar')) {

            $query->whereHas('user', function ($q) use ($request) {

                $q->where(
                    'name',
                    'like',
                    '%' . $request->buscar . '%'
                );
            });
        }

        if ($request->filled('estado')) {

            $query->where(
                'estado',
                $request->estado
            );
        }

        if ($request->filled('fecha')) {

            $query->whereHas('horario', function ($q) use ($request) {

                $q->where(
                    'fecha',
                    $request->fecha
                );
            });
        }

        $reservas = $query
            ->paginate(10)
            ->withQueryString();

        return view(
            'reservas.index',
            compact('reservas')
        );
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

        $horarioDisponible = Horario::where(
            'id',
            $request->horario_id
        )
            ->where(
                'estado',
                true
            )
            ->exists();

        if (!$horarioDisponible) {
            return back()
                ->withErrors([
                    'horario_id' => 'El horario seleccionado ya no está disponible.'
                ])
                ->withInput();
        }

        $reserva = Reserva::create([
            'user_id' => Auth::id(),
            'servicio_id' => $request->servicio_id,
            'horario_id' => $request->horario_id,
            'estado' => 'Pendiente',
        ]);

        $reserva->load([
            'user',
            'servicio',
            'horario'
        ]);

        Mail::to($reserva->user->email)->send(new ReservaCreadaMail($reserva));

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

    public function cambiarEstado(Request $request, Reserva $reserva)
    {
        $request->validate([
            'estado' => 'required'
        ]);

        $reserva->update([
            'estado' => $request->estado
        ]);

        if ($request->estado == 'Cancelada') {

            Horario::where(
                'id',
                $reserva->horario_id
            )->update([
                'estado' => true
            ]);
        }

        $reserva->load([
            'user',
            'servicio',
            'horario'
        ]);

        Mail::to($reserva->user->email)->send(new CambioEstadoReservaMail($reserva));

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente'
        ]);
    }

    public function calendario()
    {

        $reservas = Reserva::with([
            'user',
            'servicio',
            'horario'
        ])->get();

        $eventos = [];
        foreach ($reservas as $reserva) {
            $eventos[] = [

                'title' =>
                $reserva->servicio->nombre .
                    ' - ' .
                    $reserva->user->name,

                'start' =>
                $reserva->horario->fecha .
                    'T' .
                    $reserva->horario->hora_inicio,

                'color' => match ($reserva->estado) {
                    'Pendiente' => '#ffc107',
                    'Confirmada' => '#0d6efd',
                    'Completada' => '#198754',
                    'Cancelada' => '#dc3545',

                    default => '#6c757d'
                }
            ];
        }
        return view('reservas.calendario', compact('eventos'));
    }

    public function horariosDisponibles(Request $request)
    {
        $horarios = Horario::where(
            'fecha',
            $request->fecha
        )
            ->where('estado', true)
            ->orderBy('hora_inicio')
            ->get();

        return response()->json($horarios);
    }

    public function exportarPDF()
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

        $pdf = Pdf::loadView(
            'reservas.pdf',
            compact('reservas')
        );

        return $pdf->download('reservas.pdf');
    }
}
