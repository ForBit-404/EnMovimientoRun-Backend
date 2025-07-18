<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest{
    /**
     * Determine if the user is authorized to make this request.
    */
    public function authorize(): bool{
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(){
        return [
            'nombre' => 'required|string',
            'usuario' => 'required|string|unique:usuario,usuario',
            'email' => 'required|email|unique:usuario,email',
            'password' => 'required|string|min:6',
            'apellido' => 'required|string',
            'sexo' => 'required|string',
            'dni' => 'required|integer|unique:usuario,dni',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|int'
        ];
    }
}