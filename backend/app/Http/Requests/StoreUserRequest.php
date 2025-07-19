<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;

class StoreUserRequest extends FormRequest{
    /* Determine if the user is authorized to make this request.*/
    public function authorize(): bool{
        return true;
    }

    /* Get the validation rules that apply to the request. */
    public function rules(){
        return [
            'nombre' => 'required|string',
            'usuario' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string',
            'apellido' => 'required|string',
            'sexo' => 'required|string',
            'dni' => 'required|integer|unique:usuario,dni',
            'fecha_nacimiento' => 'required|date',
            'telefono' => 'required|integer'
        ];
    }

}