<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller{
    // Obtener todos los usuarios
    public function index(){
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    // Obtener un usuario por ID
    public function show($id){
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json($user);
    }

    // Crear nuevo usuario
    public function store(StoreUserRequest $request){
        $validated = $request->validated();
        $user = User::create($validated);

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);
    }
}