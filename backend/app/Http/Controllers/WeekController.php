<?php

namespace App\Http\Controllers;

use App\Models\Week;
use Illuminate\Http\Request;

class WeekController extends Controller{
    // Obtener todos los usuarios
    public function index(){
        $week = Week::all();
        return response()->json($week);
    }

    // Obtener un usuario por ID
    public function showWeek($id){
        $week = Week::find($id);

        if (!$week) {
            return response()->json(['message' => 'Semana no encontrada'], 404);
        }

        return response()->json($week);
    }

    public function storeWeek(Request $request){
        try{
            $validated = $request->validate([
                'id_historial_entreno' => 'required|integer|exists:historial_entreno,id',
                'dia' => 'required|string|max:20',
                'fecha' => 'required|date',
                'cant_km' => 'nullable|numeric',
                'ritmo' => 'nullable|string|max:20',
                'comentario' => 'nullable|string|max:255',
                'tiempo' => 'nullable|regex:/^\d{2}:\d{2}(:\d{2})?$/',
            ]);
            $week = Week::create($validated);
            return response()->json([
                'message' => 'Semana creada correctamente',
                'week' => $week
            ], 201);
        }catch(\Exception $e){
            return response()->json([
                'message' => 'Error al crear la semana',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    public function updateWeek(Request $request, $id){
        $week = Week::find($id);

        if (!$week) {
            return response()->json(['message' => 'Semana no encontrada'], 404);
        }

        $camposSemana = [
            'id_historial_entreno', 'dia', 'fecha', 'cant_km', 'ritmo',
            'comentario', 'tiempo',
        ];

        foreach ($camposSemana as $campo) {
            if ($request->has($campo)) {
                $week->$campo = $request->input($campo);
            }
        }
        $week->save();

        return response()->json(['week' => $week]);
    }
    public function destroyWeek($id){
        $week = Week::find($id);

        if (!$week) {
            return response()->json(['message' => 'Semana no encontrada'], 404);
        }

        $week->delete();
        return response()->json(['message' => 'Semana eliminada correctamente']);
    }

}