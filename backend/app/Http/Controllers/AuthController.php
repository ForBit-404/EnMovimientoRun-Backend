<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'usuario' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('usuario', $credentials['usuario'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        // Verificamos si es admin o no
        $isAdmin = $user->admin()->exists();

        return response()->json([
            'message' => 'Login exitoso',
            'usuario' => $user,
            'rol' => $isAdmin ? 'admin' : 'alumno'
        ]);
    }

    public function logout(Request $request){
        // Cierra la sesión del usuario autenticado
        auth()->logout();

        // Limpia todas las sesiones y cookies
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Opcional: devolver respuesta JSON para API
        return response()->json(['message' => 'Logout exitoso']);
    }
}