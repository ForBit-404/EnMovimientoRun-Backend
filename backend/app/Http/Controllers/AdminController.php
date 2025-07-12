<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest; 

class AdminController extends Controller{
    // Obtener todos los administradores
    public function index(){
        $administradores = Admin::all(); // trae todos los administradores
        return response()->json($administradores);
    }

    // Obtener un administrador por ID
    public function show($id){
        $admin = Admin::with('user')->find($id);

        if (!$admin) {
            return response()->json(['message' => 'Administrador no encontrado'], 404);
        }
        return response()->json($admin);
    }

    // Crear administrador
    public function store(StoreUserRequest  $request){
        // Validar los datos del usuario
        $validatedUser = $request->validated();

        // Crear usuario (password se hashea con el mutator en el modelo)
        $user = User::create($validatedUser);

        // Crear el administrador (con la FK de user)
        $admin = Admin::create([
            'id' => $user->id,
            'isAdmin' => true
        ]);

        return response()->json([
            'message' => 'Administrador creado correctamente',
            'usuario' => $user,
            'administrador' => $admin
        ], 201);
    }

}