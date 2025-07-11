<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    public function store(Request $request){
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'usuario' => 'required|string|max:255|unique:usuario,usuario',
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|string|min:6',
            'apellido' => 'required|string|max:255',
            'sexo' => 'required|string',
            'dni' => 'required|int|unique:usuario,dni',
            'fecha_nacimiento' => 'required|date'
        ]);

        dd($validated);  // <---- Esto muestra qué datos llegan validados
        $user = User::create($validated); // El mutator en User se encargará de hashear el password

        return response()->json([
            'message' => 'Usuario creado correctamente',
            'user' => $user
        ], 201);
    }
}