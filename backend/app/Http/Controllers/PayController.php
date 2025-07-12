<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pay;
use App\Models\Student;
use Illuminate\Http\Request;


class PayController extends Controller {
    // Obtener todos los pagos
    public function index() {
        $pagos = Pay::all(); // trae todos los pagos
        return response()->json($pagos);
    }

    // Obtener un pago por ID
    public function show($id) {
        $pago = Pay::with('alumno.user')->find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }
        return response()->json($pago);
    }

    // Obtener un pago con el alumno asociado
    // Esto es útil para obtener el pago junto con los detalles del alumno
    public function showWithAlumno($id) {
        $pago = Pay::with('alumno.user')->find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        return response()->json($pago);
    }

    // Crear pago
    public function store(Request $request) {
        // Validar datos
        $validatedData = $request->validate([
            'id_alumno' => 'required|integer',
            'fecha_pago' => 'required|date',
            'monto' => 'required|numeric',
            'fecha_vencimiento' => 'required|date',
            'medio_pago' => 'required|string',
            'estado' => 'required|string'
        ]);

        // Verificar que el alumno exista (y que no sea un admin)
        $alumno = Student::find($validatedData['id_alumno']);

        if (!$alumno) {
            return response()->json(['error' => 'El usuario no es un alumno válido'], 403);
        }

        // Crear el pago
        $pago = Pay::create($validatedData);

        return response()->json($pago, 201);
    }

    // Actualizar pago
    public function update(Request $request, $id) {
        $pago = Pay::find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        // Validar los datos de entrada
        $validatedData = $request->validate([
            'id_alumno' => 'sometimes|required|integer',
            'fecha_pago' => 'sometimes|required|date',
            'monto' => 'sometimes|required|numeric',
            'fecha_vencimiento' => 'sometimes|required|date',
            'medio_pago' => 'sometimes|required|string',
            'estado' => 'sometimes|required|string'
        ]);

        // Actualizar el pago
        $pago->update($validatedData);

        return response()->json($pago);
    }
    // Eliminar pago
    public function destroy($id) {
        $pago = Pay::find($id);

        if (!$pago) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        // Eliminar el pago
        $pago->delete();

        return response()->json(['message' => 'Pago eliminado correctamente']);
    }

    // Obtener todos los pagos de un alumno
    public function pagosDeAlumno($idAlumno) {
        $alumno = Student::find($idAlumno);

        if (!$alumno) {
            return response()->json(['message' => 'Alumno no encontrado'], 404);
        }

        $pagos = Pay::with('alumno')->where('id_alumno', $idAlumno)->get();

        return response()->json($pagos);
    }
    // Filtrar pagos por atributos específicos
    public function filterPayments(Request $request){
        $sql = "SELECT * FROM pago WHERE 1=1";
        $bindings = [];

        if ($request->filled('estado')) {
            $sql .= " AND UPPER(TRIM(estado)) = ?";
            $bindings[] = strtoupper(trim($request->estado));
        }

        if ($request->filled('medio_pago')) {
            $sql .= " AND UPPER(TRIM(medio_pago)) = ?";
            $bindings[] = strtoupper(trim($request->medio_pago));
        }

        if ($request->filled('monto_min')) {
            $sql .= " AND monto >= ?";
            $bindings[] = $request->monto_min;
        }

        if ($request->filled('monto_max')) {
            $sql .= " AND monto <= ?";
            $bindings[] = $request->monto_max;
        }

        if ($request->filled('fecha_inicio')) {
            $sql .= " AND fecha_pago >= ?";
            $bindings[] = $request->fecha_inicio;
        }

        if ($request->filled('fecha_fin')) {
            $sql .= " AND fecha_pago <= ?";
            $bindings[] = $request->fecha_fin;
        }

        $pagos = DB::select($sql, $bindings);

        if (empty($pagos)) {
            return response()->json(['message' => 'Pago no encontrado'], 404);
        }

        return response()->json($pagos);
    }

    public function filterStudentsWithPayments(Request $request) {
        $query = Student::query();

        // Filtros alumno
        if ($request->filled('estado_pago')) {
            $query->where('estado_pago', $request->estado_pago);
        }

        // Join con pagos y filtro sobre pagos
        if ($request->filled('estado_pago_pago')) {
            $query->whereHas('pagos', function($q) use ($request) {
                $q->where('estado', $request->estado_pago_pago);
            });
        }

        $students = $query->with('pagos')->get();

        return response()->json($students);
    }
}   