<?php
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="API EnMovimientoRun",
 *     description="Documentación de la API EnMovimientoRun"
 * )
 */


use Illuminate\Support\Facades\Route;

// Importa el controlador de user (usuarios)
use App\Http\Controllers\UserController;
// Importa el controlador de pay (pagos)
// use App\Http\Controllers\PayController;
// Importa el controlador de student (estudiantes)
use App\Http\Controllers\StudentController;
// Importa el controlador de admin (administradores)
use App\Http\Controllers\AdminController;
// Importa el controlador de autenticación (login, logout, etc.)
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\WeekContoller;

//Rutas para los controladores de filtros
Route::get('/students/filters', [StudentController::class, 'filterStudents']); //Vas tipieando y va actualizandose
Route::get('/allUsers', [StudentController::class, 'filterAllStudents']); //Devuelve todos los tipos de alumnos ({"total_alumnos", "alumnos_al_dia", "alumnos_con_deuda", "alumnos_baja", "nuevos_alumnos_ultimos_30_dias")
Route::get('/students/filters-by-attributes', [StudentController::class, 'filterByAttributes']); // Filtra estudiantes por atributos específicos
Route::get('/payments/filters', [PayController::class, 'filterPayments']); // Filtra pagos por atributos específicos
Route::get('/students-with-payments/filters', [PayController::class, 'filterStudentsWithPayments']); // Filtra estudiantes con pagos por atributos específicos


// Rutas para el controlador de usuarios
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Rutas para el controlador de pagos
// Route::get('/pays', [PayController::class, 'index']);
// Route::get('/pays/{id}', [PayController::class, 'show']);
// Route::post('/pays', [PayController::class, 'store']);
// Route::put('/pays/{id}', [PayController::class, 'update']);
// Route::delete('/pays/{id}', [PayController::class, 'destroy']);

// Rutas para el controlador de estudiantes
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::put('/studentsBaja/{id}', [StudentController::class, 'darDeBaja']);
Route::put('/studentsAlta/{id}', [StudentController::class, 'darDeAlta']);

// Rutas para el controlador de administradores
Route::get('/admins', [AdminController::class, 'index']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::post('/admins', [AdminController::class, 'store']);
Route::put('/admins/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

// Rutas para el controlador de pagos
Route::get('/payments', [PayController::class, 'index']);
Route::get('/payments/{id}', [PayController::class, 'show']);
Route::get('/payments/{id}/withAlumno', [PayController::class, 'showWithAlumno']);
Route::get('/students/{id}/payments', [PayController::class, 'pagosDeAlumno']);
Route::post('/payments', [PayController::class, 'store']);
Route::put('/payments/{id}', [PayController::class, 'update']);
Route::delete('/payments/{id}', [PayController::class, 'destroy']);

// Rutas para el controlador de usuarios (login, logout, etc.)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
