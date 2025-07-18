<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\User; 
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest; 

class StudentController extends Controller{
    // Obtener todos los estudiantes
    public function index(){
        $students = Student::with('user')->get();
        return response()->json($students);
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
    public function store(StoreUserRequest  $request){
        // Validar los datos del usuario de entrada
        $validatedUser = $request->validated();
        $user = User::create($validatedUser);
        // Validar los datos del estudiante de entrada
        $validatedStudent = $request->validate([
            'estado_sit_actual' => 'required|boolean',
            'estado_pago' => 'required|boolean',
            'edad' => 'required|string',
            'profesion' => 'required|string',
            'dias_gym' => 'required|string',
            'dia_descanso' => 'required|string',
            'actividad_complementaria' => 'required|string',
            'km_objetivo' => 'required|string',
            'proximo_objetivo' => 'required|string',
            'horario_entrenamiento' => 'required|string',
            'tiene_reloj_garmin' => 'required|boolean',
            'condiciones_medicas' => 'required|string',
            'fecha_ultima_ergonometria' => 'required|date',
            'habitos_correr' => 'required|string',
            'marcaCelular' => 'required|string'
        ]);
        // Crear el estudiante asociado al usuario
        $student = Student::create([
            'id' => $user->id, // Asignar el ID del usuario al estudiante
            'estado_sit_actual' => $validatedStudent['estado_sit_actual'],
            'estado_pago' => $validatedStudent['estado_pago'],
            'edad' => $validatedStudent['edad'],
            'profesion' => $validatedStudent['profesion'],
            'dias_gym' => $validatedStudent['dias_gym'],
            'dia_descanso' => $validatedStudent['dia_descanso'],
            'actividad_complementaria' => $validatedStudent['actividad_complementaria'],
            'km_objetivo' => $validatedStudent['km_objetivo'],
            'proximo_objetivo' => $validatedStudent['proximo_objetivo'],
            'horario_entrenamiento' => $validatedStudent['horario_entrenamiento'],
            'tiene_reloj_garmin' => $validatedStudent['tiene_reloj_garmin'],
            'condiciones_medicas' => $validatedStudent['condiciones_medicas'],
            'fecha_ultima_ergonometria' => $validatedStudent['fecha_ultima_ergonometria'],
            'habitos_correr' => $validatedStudent['habitos_correr'],
            'marcaCelular' => $validatedStudent['marcaCelular']
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
        $camposUsuario = ['nombre', 'usuario', 'email', 'apellido', 'password', 'sexo', 'dni'];
        $camposAlumno = [
            'fecha_registro', 'estado_sit_actual', 'estado_pago', 'edad', 'profesion',
            'dias_gym', 'dia_descanso', 'actividad_complementaria', 'km_objetivo',
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

    // Eliminar estudiante
    public function destroy($id){
        $student = Student::find($id);

        if (!$student) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        }

        // Eliminar el usuario asociado al estudiante
        $user = $student->user;
        $user->delete();

        // Eliminar el estudiante
        $student->delete();

        return response()->json(['message' => 'Estudiante eliminado correctamente'], 200);
    }

    public function filterStudents(Request $request) {
        $query = $request->input('query'); // texto que se va tipeando

        $students = Student::with('user')
            ->whereHas('user', function ($q) use ($query) {
                $q->where('nombre', 'like', "%{$query}%")
                ->orWhere('apellido', 'like', "%{$query}%")
                ->orWhere('usuario', 'like', "%{$query}%");
            })
            ->get();

        return response()->json($students);
    }

    public function filterAllStudents(Request $request) {
        $totalAlumnos = Student::count();

        $alumnosAlDia = Student::where('estado_pago', 1)->count();
        $alumnosConDeuda = Student::where('estado_pago', 0)->count();

        $alumnosBaja = Student::where('estado_sit_actual', 0)->count();

        $nuevosAlumnos = Student::where('fecha_registro', '>=', now()->subDays(30))->count();

        return response()->json([
            'total_alumnos' => $totalAlumnos,
            'alumnos_al_dia' => $alumnosAlDia,
            'alumnos_con_deuda' => $alumnosConDeuda,
            'alumnos_baja' => $alumnosBaja,
            'nuevos_alumnos_ultimos_30_dias' => $nuevosAlumnos
        ]);
    }

    /**
     * Filtra estudiantes por atributos específicos.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */
    public function filterByAttributes(Request $request){
        $students = Student::with('user') // Relación con usuario
            ->where(function ($query) use ($request) {
                // Filtros del modelo alumno
                if ($request->filled('fecha_registro')) {
                    $query->whereDate('fecha_registro', $request->fecha_registro);
                }
                if ($request->filled('estado_sit_actual')) {
                    $query->where('estado_sit_actual', $request->estado_sit_actual);
                }
                if ($request->filled('estado_pago')) {
                    $query->where('estado_pago', $request->estado_pago);
                }
                if ($request->filled('objetivo')) {
                    $query->where('objetivo', 'like', '%' . $request->objetivo . '%');
                }
                if ($request->filled('profesion')) {
                    $query->where('profesion', 'like', '%' . $request->profesion . '%');
                }
                if ($request->filled('dias_gym')) {
                    $query->where('dias_gym', $request->dias_gym);
                }
                if ($request->filled('dia_descanso')) {
                    $query->where('dia_descanso', $request->dia_descanso);
                }
                if ($request->filled('actividad_complementaria')) {
                    $query->where('actividad_complementaria', 'like', '%' . $request->actividad_complementaria . '%');
                }
                if ($request->filled('km_objetivo')) {
                    $query->where('km_objetivo', $request->km_objetivo);
                }
                if ($request->filled('proximo_objetivo')) {
                    $query->where('proximo_objetivo', 'like', '%' . $request->proximo_objetivo . '%');
                }
                if ($request->filled('horario_entrenamiento')) {
                    $query->where('horario_entrenamiento', $request->horario_entrenamiento);
                }
                if ($request->filled('tiene_reloj_garmin')) {
                    $query->where('tiene_reloj_garmin', $request->tiene_reloj_garmin);
                }
                if ($request->filled('condiciones_medicas')) {
                    $query->where('condiciones_medicas', 'like', '%' . $request->condiciones_medicas . '%');
                }
                if ($request->filled('fecha_ultima_ergonometria')) {
                    $query->whereDate('fecha_ultima_ergonometria', $request->fecha_ultima_ergonometria);
                }
                if ($request->filled('habitos_correr')) {
                    $query->where('habitos_correr', 'like', '%' . $request->habitos_correr . '%');
                }
            })
            ->whereHas('user', function ($q) use ($request) {
                // Filtros del modelo usuario
                if ($request->filled('nombre')) {
                    $q->where('nombre', 'like', '%' . $request->nombre . '%');
                }
                if ($request->filled('apellido')) {
                    $q->where('apellido', 'like', '%' . $request->apellido . '%');
                }
                if ($request->filled('usuario')) {
                    $q->where('usuario', 'like', '%' . $request->usuario . '%');
                }
                if ($request->filled('email')) {
                    $q->where('email', 'like', '%' . $request->email . '%');
                }
                if ($request->filled('sexo')) {
                    $q->where('sexo', $request->sexo);
                }
                if ($request->filled('dni')) {
                    $q->where('dni', $request->dni);
                }
            })
            ->get();
        return response()->json($students);
    }
}