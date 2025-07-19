<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\TrainingPlan;
use App\Models\Student;
use Illuminate\Http\Request;


class TrainginPlanController extends Controller {
    // Obtener todos los planes de entrenamiento
    public function index() {
        $planes = TrainingPlan::all(); // trae todos los planes de entrenamiento
        return response()->json($planes);
    }

    // Obtener un plan de entrenamiento por ID
    public function show($id) {
        $plan = TrainingPlan::with('alumno.user')->find($id);

        if (!$plan) {
            return response()->json(['message' => 'Plan de entrenamiento no encontrado'], 404);
        }
        return response()->json($plan);
    }

    // Obtener un plan de entrenamiento con el alumno asociado
    // Esto es útil para obtener el pago junto con los detalles del alumno
    public function showWithAlumno($id) {
        $plan = TrainingPlan::with('alumno.user')->find($id);

        if (!$plan) {
            return response()->json(['message' => 'Plan de entrenamiento no encontrado'], 404);
        }

        return response()->json($plan);
    }

    // Crear plan de entrenamiento
    public function store(Request $request) {
        // Validar datos
        $validatedData = $request->validate([
            'id_alumno' => 'required|integer',
            'id_historial_entrenamiento' => 'required|integer',
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
        ]);

        // Verificar que el alumno exista (y que no sea un admin)
        $alumno = Student::find($validatedData['id_alumno']);

        if (!$alumno) {
            return response()->json(['error' => 'El usuario no es un alumno válido'], 403);
        }

        // Crear el plan de entrenamiento
        $plan = TrainingPlan::create($validatedData);

        return response()->json($plan, 201);
    }

    // Actualizar plan de entrenamiento
    public function update(Request $request, $id) {
        $plan = TrainingPlan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Plan de entrenamiento no encontrado'], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_alumno' => 'required|integer',
            'id_historial_entrenamiento' => 'required|integer',
            'nombre' => 'required|string',
            'fecha_inicio' => 'required|date',
        ]);

        // Actualizar el plan de entrenamiento
        $plan->update($validatedData);

        return response()->json($plan);
    }
    // Eliminar plan de entrenamiento
    public function destroy($id) {
        $plan = TrainingPlan::find($id);

        if (!$plan) {
            return response()->json(['message' => 'Plan de entrenamiento no encontrado'], 404);
        }

        // Eliminar el plan de entrenamiento
        $plan->delete();

        return response()->json(['message' => 'Plan de entrenamiento eliminado correctamente']);
    }

}   