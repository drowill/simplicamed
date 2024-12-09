<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class ProfissionalCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Administrador: 2
     * Profissional: 1
     * Cliente: 0
     */
    public function authorize(): bool
    {
        return Auth::user()->permission_level === 2;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', 
            'email' => 'required|string|email|max:255|unique:users', 
            'password' => 'required|string|min:8', 
            'cpf' => 'required|string|max:14|unique:users', 
            'data_nascimento' => 'required|date', 
            'endereco' => 'required|string|max:255', 
            'telefone' => 'required|string|max:15', 
        ];
    }
}
