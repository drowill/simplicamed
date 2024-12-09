<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConsultaCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => ['required'],
            'idade' => ['required', 'integer', 'min:18'],
            'descricao' => ['required', 'string'],
            'data' => ['required', 'date'],
            'horario' => ['required']
        ];
        
    }

    public function message()
    {
        return [
            'title.required' => 'O nome é obrigatório',
            'idade.min' => 'Você não possuí a idade minima para agendar a consulta, procure um responsável'
        ];
    }

}
