<?php

use Illuminate\Support\Facades\Route;

// Importa el controlador de user (usuarios)
use App\Http\Controllers\UserController;
// Importa el controlador de pay (pagos)
use App\Http\Controllers\PayController;
// Importa el controlador de student (estudiantes)
use App\Http\Controllers\StudentController;
// Importa el controlador de admin (administradores)
use App\Http\Controllers\AdminController;
// Importa el controlador de autenticación (login, logout, etc.)
use App\Http\Controllers\AuthController;

// En routes/api.php
Route::get('/test', function () {
    return response()->json(['status' => 'API OK']);
});

// Rutas para el controlador de usuarios
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

// Rutas para el controlador de estudiantes
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::put('/studentsBaja/{id}', [StudentController::class, 'darDeBaja']);
Route::put('/studentsAlta/{id}', [StudentController::class, 'darDeAlta']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);

// Rutas para el controlador de administradores
Route::get('/admins', [AdminController::class, 'index']);
Route::get('/admins/{id}', [AdminController::class, 'show']);
Route::post('/admins', [AdminController::class, 'store']);
Route::put('/admins/{id}', [AdminController::class, 'update']);
Route::delete('/admins/{id}', [AdminController::class, 'destroy']);

// Rutas para el controlador de pagos
Route::get('/pays', [PayController::class, 'index']);
Route::get('/pays/{id}', [PayController::class, 'show']);
Route::get('/pays/{id}/withAlumno', [PayController::class, 'showWithAlumno']);
Route::get('/students/{id}/pays', [PayController::class, 'pagosDeAlumno']);
Route::post('/pays', [PayController::class, 'store']);
Route::put('/pays/{id}', [PayController::class, 'update']);
Route::delete('/pays/{id}', [PayController::class, 'destroy']);

// Rutas para el controlador de usuarios (login, logout, etc.)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//Rutas para los controladores de filtros
Route::get('/students/filters', [StudentController::class, 'filterStudents']); //Vas tipieando y va actualizandose
Route::get('/allUsers', [StudentController::class, 'filterAllUsers']); //Devuelve todos los tipos de usuario ({"total_alumnos", "alumnos_al_dia", "alumnos_con_deuda", "alumnos_baja", "nuevos_alumnos_ultimos_30_dias")
