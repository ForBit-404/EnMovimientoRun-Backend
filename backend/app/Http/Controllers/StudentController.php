<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller{
    // Obtener todos los estudiantes
    public function index(){
        $estudiantes = Student::all(); // trae todos los estudiantes
        return response()->json($estudiantes);
    }

    // Obtener un estudiante por ID
    public function show($id){
        $student = Student::with('user')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        return response()->json($student);
    }

    // Crear estudiante
    public function store(Request $request){
        // Validar los datos del usuario de entrada
        $validatedUser = $request->validate([
            'nombre' => 'required|string',
            'usuario' => 'required|string',
            'email' => 'required|email',
            'apellido' => 'required|string',
            'password' => 'required|string|min:6',
            'sexo' => 'required|string'
        ]);
        // Crear el usuario
        $user = User::create([
            'nombre' => $validatedUser['nombre'],
            'usuario' => $validatedUser['usuario'],
            'email' => $validatedUser['email'],
            'apellido' => $validatedUser['apellido'],
            'password' => bcrypt($validatedUser['password']),
            'sexo' => $validatedUser['sexo']
        ]);
        // Validar los datos del estudiante de entrada
        $validatedStudent = $request->validate([
            'fecha_registro' => 'required|date',
            'estado_sit_actual' => 'required|boolean',
            'estado_pago' => 'required|boolean',
            'edad' => 'required|string',
            'profesion' => 'required|string',
            'dias_gym' => 'required|string',
            'dias_descanso' => 'required|string',
            'actividad_complementaria' => 'required|string',
            'km_objetivo' => 'required|string',
            'proximo_objetivo' => 'required|string',
            'horario_entrenamiento' => 'required|string',
            'tiene_reloj_garmin' => 'required|boolean',
            'condiciones_medicas' => 'required|string',
            'fecha_ultima_ergonometria' => 'required|date',
            'habitos_correr' => 'required|string'
        ]);
        // Crear el estudiante asociado al usuario
        $student = Student::create([
            'id' => $user->id, // Asignar el ID del usuario al estudiante
            'fecha_registro' => $validatedStudent['fecha_registro'],
            'estado_sit_actual' => $validatedStudent['estado_sit_actual'],
            'estado_pago' => $validatedStudent['estado_pago'],
            'edad' => $validatedStudent['edad'],
            'profesion' => $validatedStudent['profesion'],
            'dias_gym' => $validatedStudent['dias_gym'],
            'dias_descanso' => $validatedStudent['dias_descanso'],
            'actividad_complementaria' => $validatedStudent['actividad_complementaria'],
            'km_objetivo' => $validatedStudent['km_objetivo'],
            'proximo_objetivo' => $validatedStudent['proximo_objetivo'],
            'horario_entrenamiento' => $validatedStudent['horario_entrenamiento'],
            'tiene_reloj_garmin' => $validatedStudent['tiene_reloj_garmin'],
            'condiciones_medicas' => $validatedStudent['condiciones_medicas'],
            'fecha_ultima_ergonometria' => $validatedStudent['fecha_ultima_ergonometria'],
            'habitos_correr' => $validatedStudent['habitos_correr']
        ]);

        return response()->json(['usuario' => $user, 'alumno' => $student], 201);
    }
    // Actualizar estudiante
    public function update(Request $request, $id){
        $student = Student::with('user')->find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $user = $student->user;

        // Campos permitidos para usuario y alumno (modificá según tus modelos)
        $camposUsuario = ['nombre', 'usuario', 'email', 'apellido', 'password', 'sexo'];
        $camposAlumno = [
            'fecha_registro', 'estado_sit_actual', 'estado_pago', 'edad', 'profesion',
            'dias_gym', 'dias_descanso', 'actividad_complementaria', 'km_objetivo',
            'proximo_objetivo', 'horario_entrenamiento', 'tiene_reloj_garmin',
            'condiciones_medicas', 'fecha_ultima_ergonometria', 'habitos_correr', 'objetivo'
        ];

        // Actualizar dinámicamente campos de usuario
        foreach ($camposUsuario as $campo) {
            if ($request->has($campo)) {
                // Para password encriptarla
                if ($campo === 'password') {
                    $user->$campo = bcrypt($request->input($campo));
                } else {
                    $user->$campo = $request->input($campo);
                }
            }
        }
        $user->save();

        // Actualizar dinámicamente campos de alumno
        foreach ($camposAlumno as $campo) {
            if ($request->has($campo)) {
                $student->$campo = $request->input($campo);
            }
        }
        $student->save();

        return response()->json(['alumno' => $student, 'usuario' => $user]);
    }

    // Dar de baja estudiante
    public function darDeBaja($id){
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $student->estado_sit_actual = '0';
        $student->save();
        return response()->json(['message' => 'Estudiante dado de baja'], 200);
    }
    // Dar de alta estudiante
    public function darDeAlta($id){
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        $student->estado_sit_actual = '1';
        $student->save();
        return response()->json(['message' => 'Estudiante dado de alta'], 200);
    }
}