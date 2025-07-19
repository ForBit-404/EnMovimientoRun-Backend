<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class FileController extends Controller {
    // Método de ejemplo para obtener todos los archivos
    public function index() {
        $archivos = File::all();
        return response()->json($archivos);
    }

    // Método de ejemplo para mostrar un archivo por ID
    public function show($id) {
        $archivo = File::find($id);

        if (!$archivo) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        return response()->json($archivo);
    }

    // Método de ejemplo para crear un nuevo archivo
    public function store(Request $request) {
        $validated = $request->validate([
            'archivo' => 'required|file|max:51200', // máx. 50MB
        ]);

        $file = $request->file('archivo');
        $nombreOriginal = $file->getClientOriginalName();
        $tipo = $file->getClientMimeType();
        $size = $file->getSize(); // en bytes
        $ruta = $file->store('public/archivos'); // se guarda en storage/app/public/archivos

        $archivo = File::create([
            'nombre' => $nombreOriginal,
            'tipo' => $tipo,
            'size' => $size,
            'path' => $ruta
        ]);

        return response()->json([
            'message' => 'Archivo subido correctamente',
            'archivo' => $archivo
        ], 201);
    }

    // Método de ejemplo para eliminar un archivo por ID
    public function destroy($id) {  
        $archivo = File::find($id);

        if (!$archivo) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        $archivo->delete();

        return response()->json(['message' => 'Archivo eliminado correctamente']);
    }

    // Un método para actualizar un archivo:
    public function update(Request $request, $id) {
        $archivo = File::find($id);

        if (!$archivo) {
            return response()->json(['message' => 'Archivo no encontrado'], 404);
        }

        $validated = $request->validate([
            'nombre' => 'sometimes|required|string|max:255',
            'tipo' => 'sometimes|required|string|max:50',
            'size' => 'sometimes|required|integer',
            'path' => 'sometimes|required|string|max:255'
        ]);

        $archivo->update($validated);

        return response()->json([
            'message' => 'Archivo actualizado correctamente',
            'archivo' => $archivo
        ]);
    }
}